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
        $currentWeight = auth()->user()->weightLogs()->latest()->value('weight');
        if ($currentWeight)
        {
            //use 2% of the current weight as the maximum difference weight can deviate in a week
            $maxDifference = $currentWeight * 0.02; // 2% of the current weight
            //calculate the difference between the current weight and the new weight
            $difference = abs($currentWeight - $validatedData['weight']);
            //if the difference is greater than the max difference
            if($difference > $maxDifference)
            {
                //redirect to dashboard with sensitivity warning
                return redirect()->route('dashboard')->with('error', '<b>Sensitivity Warning:<b><br>
                Your logged weight is unsafe and will not be logged<br>
                The safest maximum log would be to lose or gain:<br>' .round($maxDifference,2). ' kg
                based on your current weight of ' . round($currentWeight,2) . ' kg');
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





