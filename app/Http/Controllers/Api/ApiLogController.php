<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\WeightLog;
use Illuminate\Http\Request;

class ApiLogController extends Controller
{
    /**
     * Log a workout activity
     * POST /api/v1/logs/activity
     */
    public function storeActivity(Request $request)
    {
        $validatedData = $request->validate([
            'workout_name' => 'required|string|max:255',
            'duration' => 'required|numeric|min:1|max:240',
        ]);

        // Convert duration to int
        $duration = (int) $validatedData['duration'];

        $activityLog = $request->user()->activityLogs()->create([
            'workout_name' => $validatedData['workout_name'],
            'duration' => $duration,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Workout logged successfully',
            'data' => [
                'id' => $activityLog->id,
                'workout_name' => $activityLog->workout_name,
                'duration' => $activityLog->duration,
                'created_at' => $activityLog->created_at,
            ],
        ], 201);
    }

    /**
     * Get all activity logs for authenticated user
     * GET /api/v1/logs/activity
     */
    public function getActivity(Request $request)
    {
        $limit = $request->query('limit', 50);
        
        $activityLogs = $request->user()
            ->activityLogs()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'workout_name' => $log->workout_name,
                    'duration' => $log->duration,
                    'created_at' => $log->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'activity_logs' => $activityLogs,
                'total' => $activityLogs->count(),
            ],
        ], 200);
    }

    /**
     * Log weight with business logic validation
     * POST /api/v1/logs/weight
     */
    public function storeWeight(Request $request)
    {
        $validatedData = $request->validate([
            'weight' => 'required|numeric|min:30|max:500',
            'goal' => 'required|string|max:255',
        ]);

        // Convert weight to float
        $weight = floatval($validatedData['weight']);

        // Check weekly limit - user can only log weight once a week
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $weeklyLog = $request->user()->weightLogs()
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->first();

        if ($weeklyLog) {
            return response()->json([
                'success' => false,
                'message' => 'Weekly weight log already exists',
                'error' => 'You can only log your weight once per week. Try again next week.',
                'data' => [
                    'next_available_date' => $weekEnd->addDay()->format('Y-m-d'),
                    'existing_log' => [
                        'id' => $weeklyLog->id,
                        'weight' => (float) $weeklyLog->weight,
                        'logged_at' => $weeklyLog->created_at,
                    ],
                ],
            ], 422);
        }

        // Sensitivity warning - check for unusual weight changes
        $lastLog = $request->user()->weightLogs()->latest()->first();
        
        if ($lastLog) {
            $currentWeight = (float) $lastLog->weight;
            $daysSinceLastLog = abs(now()->diffInDays($lastLog->created_at));
            
            // Allow 2% per week, scaled by time elapsed
            $weeksSinceLastLog = max(1, $daysSinceLastLog / 7);
            $maxDifference = $currentWeight * 0.02 * $weeksSinceLastLog;
            
            // Cap at a reasonable maximum (12 weeks worth = 24%)
            $maxDifference = min($maxDifference, $currentWeight * 0.02 * 12);
            
            $difference = abs($currentWeight - $weight);
            
            if ($difference > $maxDifference) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sensitivity warning: Unusual weight change detected',
                    'error' => 'Your logged weight appears unusual and cannot be logged.',
                    'data' => [
                        'previous_weight' => round($currentWeight, 2),
                        'submitted_weight' => round($weight, 2),
                        'weight_change' => round($difference, 2),
                        'days_since_last_log' => $daysSinceLastLog,
                        'weeks_since_last_log' => round($weeksSinceLastLog, 1),
                        'maximum_recommended_change' => round($maxDifference, 2),
                        'reason' => 'Weight change exceeds safe threshold of 2% per week',
                    ],
                ], 422);
            }
        }

        // Create weight log
        $weightLog = $request->user()->weightLogs()->create([
            'weight' => $weight,
            'goal' => $validatedData['goal'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Weight logged successfully',
            'data' => [
                'id' => $weightLog->id,
                'weight' => (float) $weightLog->weight,
                'goal' => $weightLog->goal,
                'created_at' => $weightLog->created_at,
            ],
        ], 201);
    }

    /**
     * Get all weight logs for authenticated user
     * GET /api/v1/logs/weight
     */
    public function getWeight(Request $request)
    {
        $limit = $request->query('limit', 50);
        
        $weightLogs = $request->user()
            ->weightLogs()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'weight' => (float) $log->weight,
                    'goal' => $log->goal,
                    'created_at' => $log->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'weight_logs' => $weightLogs,
                'total' => $weightLogs->count(),
            ],
        ], 200);
    }

    /**
     * Delete an activity log
     * DELETE /api/v1/logs/activity/{id}
     */
    public function destroyActivity(Request $request, $id)
    {
        $log = $request->user()->activityLogs()->findOrFail($id);
        $log->delete();

        return response()->json([
            'success' => true,
            'message' => 'Activity log deleted successfully',
        ], 200);
    }

    /**
     * Delete a weight log
     * DELETE /api/v1/logs/weight/{id}
     */
    public function destroyWeight(Request $request, $id)
    {
        $log = $request->user()->weightLogs()->findOrFail($id);
        $log->delete();

        return response()->json([
            'success' => true,
            'message' => 'Weight log deleted successfully',
        ], 200);
    }

    /**
     * Get dashboard summary data
     * GET /api/v1/dashboard
     */
    public function getDashboard(Request $request)
    {
        $loggedWorkouts = $request->user()
            ->activityLogs()
            ->orderBy('created_at', 'asc')
            ->get();

        $loggedWeights = $request->user()
            ->weightLogs()
            ->orderBy('created_at', 'asc')
            ->get();

        // Group workouts by week and count
        $workoutCount = $loggedWorkouts->groupBy(function ($item) {
            return $item->created_at->startOfWeek()->format('d/m');
        })->map(function ($group) {
            return $group->count();
        });

        return response()->json([
            'success' => true,
            'data' => [
                'activity_logs' => $loggedWorkouts->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'workout_name' => $log->workout_name,
                        'duration' => $log->duration,
                        'created_at' => $log->created_at->format('d/m/y'),
                    ];
                }),
                'weight_logs' => $loggedWeights->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'weight' => (float) $log->weight,
                        'goal' => $log->goal,
                        'created_at' => $log->created_at->format('d/m/y'),
                    ];
                }),
                'workout_count_by_week' => $workoutCount,
                'summary' => [
                    'total_workouts' => $loggedWorkouts->count(),
                    'total_weight_logs' => $loggedWeights->count(),
                    'latest_weight' => $loggedWeights->last() ? (float) $loggedWeights->last()->weight : null,
                ],
            ],
        ], 200);
    }
}
