<?php

namespace App\Services;

use App\Models\Exercise;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExerciseDBService
{
    private $apiKey;
    private $baseUrl = 'https://exercisedb.p.rapidapi.com';

    public function __construct()
    {
        $this->apiKey = env('EXERCISE_DB_API_KEY');
    }

    /**
     * Get exercises by equipment with caching
     * First checks database, then calls API if needed
     */
    public function getByEquipment(string $equipment, int $limit = 100): array
    {
        // Check cache first
        $cachedExercises = Exercise::getByEquipment($equipment, $limit);

        if ($cachedExercises->count() > 0) {
            Log::info("Serving {$equipment} exercises from cache", [
                'count' => $cachedExercises->count()
            ]);
            return $cachedExercises->toArray();
        }

        // Cache miss - fetch from API
        Log::info("Cache miss for {$equipment}, fetching from ExerciseDB API");
        return $this->fetchAndCacheByEquipment($equipment, $limit);
    }

    /**
     * Fetch exercises from ExerciseDB API and cache them
     */
    private function fetchAndCacheByEquipment(string $equipment, int $limit): array
    {
        try {
            $response = Http::withHeaders([
                'x-rapidapi-host' => 'exercisedb.p.rapidapi.com',
                'x-rapidapi-key' => $this->apiKey,
            ])->get("{$this->baseUrl}/exercises/equipment/{$equipment}", [
                'limit' => $limit,
            ]);

            if ($response->successful()) {
                $exercises = $response->json();
                
                // Cache each exercise
                foreach ($exercises as $exercise) {
                    $this->cacheExercise($exercise);
                }

                Log::info("Cached {$equipment} exercises", [
                    'count' => count($exercises)
                ]);

                return $exercises;
            }

            Log::error("ExerciseDB API error", [
                'equipment' => $equipment,
                'status' => $response->status(),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error("Exception fetching exercises", [
                'equipment' => $equipment,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Cache a single exercise
     */
    private function cacheExercise(array $exerciseData): void
    {
        Exercise::updateOrCreate(
            ['exercise_db_id' => $exerciseData['id']],
            [
                'name' => $exerciseData['name'],
                'body_part' => $exerciseData['bodyPart'],
                'equipment' => $exerciseData['equipment'],
                'target' => $exerciseData['target'],
                'gif_url' => $exerciseData['gifUrl'] ?? null,
                'secondary_muscles' => $exerciseData['secondaryMuscles'] ?? [],
                'instructions' => $exerciseData['instructions'] ?? [],
            ]
        );
    }

    /**
     * Get exercises by multiple equipment types
     */
    public function getByMultipleEquipment(array $equipmentList, int $limit = 100): array
    {
        $allExercises = [];

        foreach ($equipmentList as $equipment) {
            $exercises = $this->getByEquipment($equipment, $limit);
            $allExercises = array_merge($allExercises, $exercises);
        }

        return $allExercises;
    }

    /**
     * Filter cached exercises by target muscles
     */
    public function filterByTargetMuscles(array $exercises, array $targetMuscles): array
    {
        return array_filter($exercises, function ($exercise) use ($targetMuscles) {
            $bodyPart = $exercise['body_part'] ?? $exercise['bodyPart'] ?? null;
            return in_array($bodyPart, $targetMuscles);
        });
    }

    /**
     * Seed database with common exercises
     * Run this once to populate the cache
     */
    public function seedCommonExercises(): int
    {
        $commonEquipment = ['barbell', 'dumbbell', 'body weight', 'cable', 'kettlebell'];
        $totalCached = 0;

        foreach ($commonEquipment as $equipment) {
            $exercises = $this->fetchAndCacheByEquipment($equipment, 100);
            $totalCached += count($exercises);
        }

        return $totalCached;
    }
}
