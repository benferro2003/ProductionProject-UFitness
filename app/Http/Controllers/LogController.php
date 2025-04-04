<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightLog;
use App\Models\ActivityLog;
use Ramsey\Uuid\Type\Decimal;

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
            'duration' => 'required|string',
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
            'weight' => 'required|string',
            'weight_goal' => 'required|string',
        ]);

        //weight converted to decimal
        $request->weight = floatval($validatedData['weight']);

        //user can only log weight once a day
        
        //get the current user
        $user = auth()->user();
        //get the current date
        $today = now()->toDateString();
        
        //check if the user has already logged their weight today
        $currentLog = $user->weightLogs()->whereDate('created_at', $today)->first();

        //if the user has already logged their weight today, return an error message
        if ($currentLog) {
            return redirect()->route('dashboard')->with('error', 'Daily weight log already exists, try again tomorrow');
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
        $loggedWorkouts = auth()->user()->activityLogs()->orderBy('created_at', 'desc')->get();
        $loggedWeights = auth()->user()->weightLogs()->orderBy('created_at', 'desc')->get();
        return view('home', [
            'loggedWorkouts' => $loggedWorkouts,
            'loggedWeights' => $loggedWeights,
        ]);
    }

}





