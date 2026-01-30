<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightLog;
use App\Models\ActivityLog;
use Ramsey\Uuid\Type\Decimal;
use Carbon\Carbon;

class LogController extends Controller
{
    public function showActivity()
    {
        return view('Logs.activity-log');
    }

    public function showWeight()
    {
        return view('Logs.weight-log');
    }

    public function logWorkout(Request $request)
    {
        $validatedData = $request->validate([
            'workout_name' => 'required|string',
            'duration' => 'required|numeric|min:1|max:240',
        ]);

        //duration converted to int
        $request->duration = (int)$validatedData['duration'];

        auth()->user()->activityLogs()->create([
            'workout_name' => value($validatedData['workout_name']),
            'duration' => value($validatedData['duration']),
        ]);

        return redirect()->route('dashboard')->with('success', 'Workout logged successfully');
    }

    public function logWeight(Request $request)
    {
        $validatedData = $request->validate([
            'weight' => 'required|numeric|min:30|max:500',
            'weight_goal' => 'required|string',
        ]);

        //weight converted to decimal
        $request->weight = floatval($validatedData['weight']);

     
        //user can only log weight once a week
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $weeklyLog = auth()->user()->weightLogs()
            ->whereBetween('created_at', [$weekStart,$weekEnd]) ->first();
        if ($weeklyLog) {
            return redirect()->route('dashboard')->with('error', 'Weekly weight log already exists, try again next week');
        }

//sensitivity warning
//user's last weight log
$lastLog = auth()->user()->weightLogs()->latest()->first();
if ($lastLog)
{
    $currentWeight = $lastLog->weight;
    $daysSinceLastLog = abs(now()->diffInDays($lastLog->created_at)); // Use abs() to handle any date issues
    
    // Allow 2% per week, scaled by time elapsed
    $weeksSinceLastLog = max(1, $daysSinceLastLog / 7);
    $maxDifference = $currentWeight * 0.02 * $weeksSinceLastLog;
    
    // Optional: Cap at a reasonable maximum (e.g., 12 weeks worth = 24%)
    $maxDifference = min($maxDifference, $currentWeight * 0.02 * 12);
    
    $difference = abs($currentWeight - $validatedData['weight']);
    
    if($difference > $maxDifference)
    {
        return redirect()->route('dashboard')->with('error', '<b>Sensitivity Warning:
        Your logged weight appears unusual and will not be logged.
        Days since last log: ' . $daysSinceLastLog . ' (' . round($weeksSinceLastLog, 1) . ' weeks)
        Maximum recommended change: ' . round($maxDifference, 2) . ' kg
        Your change: ' . round($difference, 2) . ' kg
        (from your previous weight of ' . round($currentWeight, 2) . ' kg)');
    }
}


        


        auth()->user()->weightLogs()->create([
            'weight' => value($validatedData['weight']),
            'goal' => value($validatedData['weight_goal']),
        ]);

        return redirect()->route('dashboard')->with('success', 'Weight logged successfully');
    }

    public function showLogs()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
        $loggedWorkouts = auth()->user()->activityLogs()->orderBy('created_at', 'asc')->get();
        $loggedWeights = auth()->user()->weightLogs()->orderBy('created_at', 'asc')->get();

        //variable to group workouts by week
        //return the count of workouts per week
        //map the count of workouts to variable count
        $workoutCount = $loggedWorkouts->groupBy(function ($item) {
            return $item->created_at->startofWeek()->format('d/m');
        })-> map (function ($group) {
            return $group->count();
        });

        //view weight trend
        //get weight of each day
        //group by date

        return view('home', [
            'loggedWorkouts' => $loggedWorkouts,
            'loggedWeights' => $loggedWeights,
            'workoutCount' => $workoutCount,
        ]);
    }

}





