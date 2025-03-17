<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function show()
    {
        //return the associated calculator view
        return view('workouts.create');
    }

    public function generate(Request $request)
{
    // Validate the request
    $validatedData = $request->validate([
        'available_days' => 'required|array',
        'equipment' => 'required|array',
        'fitness_level' => 'required|string',
        'training_goal' => 'required|string',
        'workout_length' => 'required|int',
        'target_muscles' => 'required|array',

    ]);

    // Get the list of equipment
    $equipmentList = $validatedData['equipment'];
    // Get the total number of days available to train
    $totalDays = count($validatedData['available_days']);

    // create empty array to store workout data
    $workoutData = [];

    //can only send one equipment at a time so loop through each equipment in the list
    foreach ($equipmentList as $equipment) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://exercisedb.p.rapidapi.com/exercises/equipment/$equipment",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: exercisedb.p.rapidapi.com",
                "x-rapidapi-key: " . env('EXERCISE_DB_API_KEY')
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        //decode json
        $decodedResponse = json_decode($response, true);

        // Ensure response is valid
        if (is_array($decodedResponse)) {
            $workoutData = array_merge($workoutData, $decodedResponse);
        }
    }

    //filter exercises based on bodypart e.g. waist, upper arms, lower arms, chest, back, legs, shoulders using target_muscles

    //return workout result view
    return view('workouts.result', [
        'workoutPlan' => $validatedData,
        'workoutData' => $workoutData,
    ]);
}

}

//currently only returns exercises based on equipment, need to add more logic to generate a workout plan
//for the user based on their fitness level and available days
//accessing /exercises/equipment/type
//response gives
//[
    //{
      //"bodyPart": "",
      //"equipment": "",
      //"gifUrl": "",
      //"id": "",
      //"name": "",
      //"target": "",
      //"secondaryMuscles": [],
      //"instructions": []
    //}
 //]

 //next time i code I need to...
 //filter exercises based on bodypart e.g. waist, upper arms, lower arms, chest, back, legs, shoulders
 //create a workout plan based on the user's fitness level and available days
 //return the workout plan to the user in results blade