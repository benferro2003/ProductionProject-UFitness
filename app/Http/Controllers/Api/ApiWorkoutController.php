<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SavedWorkout;
use App\Services\ExerciseDBService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiWorkoutController extends Controller
{
    private $exerciseService;

    public function __construct(ExerciseDBService $exerciseService)
    {
        $this->exerciseService = $exerciseService;
    }

    /**
     * Generate a workout plan
     * POST /api/v1/workouts/generate
     */
    public function generate(Request $request)
    {
        $validatedData = $request->validate([
            'available_days' => 'required|array',
            'equipment' => 'required|array',
            'fitness_level' => 'required|string|in:Beginner,Intermediate,Advanced',
            'training_goal' => 'required|string|in:strength,hypertrophy,endurance',
            'workout_split' => 'nullable|string|in:FullBody,UpperLower,PPL',
            'target_muscles' => 'required|array',
        ]);

        // Handle "all" selections
        if (isset($validatedData['target_muscles'][0]) && $validatedData['target_muscles'][0] === 'full body') {
            $validatedData['target_muscles'] = ['back', 'cardio', 'chest', 'lower arms', 'lower legs', 'shoulders', 'upper arms', 'upper legs', 'waist', 'neck'];
        }

        if (isset($validatedData['available_days'][0]) && $validatedData['available_days'][0] === 'all days') {
            $validatedData['available_days'] = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        }

        if (isset($validatedData['equipment'][0]) && $validatedData['equipment'][0] === 'all equipment') {
            $validatedData['equipment'] = ['dumbbell', 'barbell', 'kettlebell', 'body weight', 'cable'];
        }

        // Get exercises from cache/API
        $equipmentList = $validatedData['equipment'];
        $workoutData = $this->exerciseService->getByMultipleEquipment($equipmentList, 100);

        // Filter by target muscles
        $filteredExercises = $this->exerciseService->filterByTargetMuscles(
            $workoutData,
            $validatedData['target_muscles']
        );

        // Set volume based on fitness level
        $volume = match ($validatedData['fitness_level']) {
            'Beginner' => 4,
            'Intermediate' => 6,
            'Advanced' => 8,
        };

        // Set sets and reps based on goal
        [$sets, $reps] = match ($validatedData['training_goal']) {
            'strength' => [2, '4-6'],
            'hypertrophy' => [3, '8-10'],
            'endurance' => [4, '10-12'],
        };

        // Create workout split
        $totalDays = count($validatedData['available_days']);
        $splitChosen = $this->determineSplit($totalDays, $validatedData['workout_split'] ?? null);
        
        // Map exercises to split
        $mappedExercises = $this->mapExercisesToSplit(
            $splitChosen,
            $filteredExercises
        );

        // Create the final plan
        $plan = $this->createPlan(
            $mappedExercises,
            $volume,
            $totalDays,
            $splitChosen
        );

        return response()->json([
            'success' => true,
            'message' => 'Workout plan generated successfully',
            'data' => [
                'workout_plan' => $plan,
                'sets' => $sets,
                'reps' => $reps,
                'split' => $splitChosen,
                'exercises_count' => count($filteredExercises),
            ],
        ], 200);
    }

    /**
     * Save a generated workout
     * POST /api/v1/workouts
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'workout_plan' => 'required|json',
        ]);

        $savedWorkout = $request->user()->savedWorkouts()->create([
            'workout_plan' => $validatedData['workout_plan'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Workout saved successfully',
            'data' => [
                'id' => $savedWorkout->id,
                'workout_plan' => json_decode($savedWorkout->workout_plan, true),
                'created_at' => $savedWorkout->created_at,
            ],
        ], 201);
    }

    /**
     * Get all saved workouts for authenticated user
     * GET /api/v1/workouts
     */
    public function index(Request $request)
    {
        $savedWorkouts = $request->user()
            ->savedWorkouts()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($workout) {
                return [
                    'id' => $workout->id,
                    'workout_plan' => json_decode($workout->workout_plan, true),
                    'created_at' => $workout->created_at,
                    'updated_at' => $workout->updated_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'workouts' => $savedWorkouts,
                'total' => $savedWorkouts->count(),
            ],
        ], 200);
    }

    /**
     * Get a specific saved workout
     * GET /api/v1/workouts/{id}
     */
    public function show(Request $request, $id)
    {
        $workout = $request->user()->savedWorkouts()->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $workout->id,
                'workout_plan' => json_decode($workout->workout_plan, true),
                'created_at' => $workout->created_at,
                'updated_at' => $workout->updated_at,
            ],
        ], 200);
    }

    /**
     * Delete a saved workout
     * DELETE /api/v1/workouts/{id}
     */
    public function destroy(Request $request, $id)
    {
        $workout = $request->user()->savedWorkouts()->findOrFail($id);
        $workout->delete();

        return response()->json([
            'success' => true,
            'message' => 'Workout deleted successfully',
        ], 200);
    }

    // Helper functions (copied from your original WorkoutController)

    private function determineSplit(int $totalDays, ?string $split): string
    {
        if ($split) {
            return $split;
        }

        if ($totalDays <= 3) {
            return 'FullBody';
        } elseif ($totalDays <= 4) {
            return 'UpperLower';
        } else {
            return 'PPL';
        }
    }

    private function mapExercisesToSplit(string $splitChosen, array $workoutData): array
    {
        $splits = [
            'FullBody' => ['FullBody', 'FullBody', 'FullBody'],
            'UpperLower' => ['UpperDay', 'LowerDay'],
            'PPL' => ['Push', 'Pull', 'Legs'],
        ];

        $splitTarget = [
            'FullBody' => ['abs', 'biceps', 'calves', 'cardiovascular system', 'delts', 'forearms', 'glutes', 'hamstrings', 'lats', 'pectorals', 'quads', 'serratus anterior', 'spine', 'traps', 'triceps', 'upper back'],
            'UpperDay' => ['biceps', 'delts', 'forearms', 'lats', 'pectorals', 'traps', 'triceps', 'upper back'],
            'LowerDay' => ['abs', 'calves', 'cardiovascular system', 'glutes', 'hamstrings', 'quads', 'spine', 'abductors', 'adductors'],
            'Push' => ['pectorals', 'traps', 'delts', 'triceps'],
            'Pull' => ['lats', 'biceps', 'forearms', 'upper back'],
            'Legs' => ['quads', 'hamstrings', 'glutes', 'calves', 'abductors', 'adductors'],
        ];

        $splitDays = $splits[$splitChosen];
        $filteredExercises = [];

        for ($i = 0; $i < count($splitDays); $i++) {
            shuffle($workoutData);
            $filteredExercises[$splitDays[$i]] = array_filter($workoutData, function ($exercise) use ($splitTarget, $splitDays, $i) {
                $target = $exercise['target'] ?? null;
                return in_array($target, $splitTarget[$splitDays[$i]]);
            });
        }

        return $filteredExercises;
    }

    private function createPlan(array $filteredExercises, int $volume, int $totalDays, string $splitChosen): array
    {
        $splits = [
            'FullBody' => ['FullBody', 'FullBody', 'FullBody'],
            'UpperLower' => ['UpperDay', 'LowerDay'],
            'PPL' => ['Push', 'Pull', 'Legs'],
        ];

        $plan = [];
        $splitDays = $splits[$splitChosen];
        $splitCount = count($splitDays);

        for ($i = 0; $i < $totalDays; $i++) {
            $day = $splitDays[$i % $splitCount];
            $exercises = $filteredExercises[$day];
            
            // Convert to array and shuffle
            $exercisesArray = array_values($exercises);
            shuffle($exercisesArray);
            
            $plan["Day " . ($i + 1) . " - $day"] = array_slice($exercisesArray, 0, $volume);
        }

        return $plan;
    }
}
