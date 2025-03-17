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

        //allow up to 100 exercises to be returned

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://exercisedb.p.rapidapi.com/exercises/equipment/$equipment?limit=100",
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
    //filter exercises based where $target_muscles matches $decodedresponse['bodyPart']
    $filteredExercises = array_filter($workoutData, function ($exercise) use ($validatedData) {
        return in_array($exercise['bodyPart'], $validatedData['target_muscles']);
    });
    //ouput the contents of $filteredExercises
    //dd($filteredExercises);
    //now use $totaldays to generate a workout plan
    //$volume is number of exercises per workout / available_day
    $volume = 6;
    //create a workout plan based on the user's fitness level and available days 
    $plan = [];
    //make each days exercises a split of the bodypart exercises
    //e.g. day 1 has 6 exercises, day 2 has 6 exercises, day 3 has 6 exercises but each day has different exercises with equal volume of selected target muscles
    if($totalDays == 1){
        $workoutData = array_slice($filteredExercises, 0, $volume);
    } else
    if($totalDays == 2){
        $workoutData = array_slice($filteredExercises, 0, $volume*2);
        //create a workout plan for two days with day 1 and day 2 each with 6 exercises
        $plan = [
            'Day 1' => array_slice($workoutData, 0, $volume),
            'Day 2' => array_slice($workoutData, $volume, $volume)
        ];
        //dd($plan);
        
    }elseif($totalDays == 3){
        $workoutData = array_slice($filteredExercises, 0, $volume*3);
        //create a workout plan for three days with day 1, day 2 and day 3 each with 6 exercises
        $plan = [
            'Day 1' => array_slice($workoutData, 0, $volume),
            'Day 2' => array_slice($workoutData, $volume, $volume),
            'Day 3' => array_slice($workoutData, $volume*2, $volume)
        ];
    }elseif($totalDays == 4){
        $workoutData = array_slice($filteredExercises, 0, $volume*4);
        //create a workout plan for four days with day 1, day 2, day 3 and day 4 each with 6 exercises
        $plan = [
            'Day 1' => array_slice($workoutData, 0, $volume),
            'Day 2' => array_slice($workoutData, $volume, $volume),
            'Day 3' => array_slice($workoutData, $volume*2, $volume),
            'Day 4' => array_slice($workoutData, $volume*3, $volume)
        ];
    } elseif($totalDays == 5){
        $workoutData = array_slice($filteredExercises, 0, $volume*5);
        //create a workout plan for five days with day 1, day 2, day 3, day 4 and day 5 each with 6 exercises
        $plan = [
            'Day 1' => array_slice($workoutData, 0, $volume),
            'Day 2' => array_slice($workoutData, $volume, $volume),
            'Day 3' => array_slice($workoutData, $volume*2, $volume),
            'Day 4' => array_slice($workoutData, $volume*3, $volume),
            'Day 5' => array_slice($workoutData, $volume*4, $volume)
        ];
    } elseif($totalDays == 6){
        $workoutData = array_slice($filteredExercises, 0, $volume*6);
        //create a workout plan for six days with day 1, day 2, day 3, day 4, day 5 and day 6 each with 6 exercises
        $plan = [
            'Day 1' => array_slice($workoutData, 0, $volume),
            'Day 2' => array_slice($workoutData, $volume, $volume),
            'Day 3' => array_slice($workoutData, $volume*2, $volume),
            'Day 4' => array_slice($workoutData, $volume*3, $volume),
            'Day 5' => array_slice($workoutData, $volume*4, $volume),
            'Day 6' => array_slice($workoutData, $volume*5, $volume)
        ];
        
    } elseif($totalDays == 7){
        $workoutData = array_slice($filteredExercises, 0, $volume*7);
        //create a workout plan for seven days with day 1, day 2, day 3, day 4, day 5, day 6 and day 7 each with 6 exercises
        $plan = [
            'Day 1' => array_slice($workoutData, 0, $volume),
            'Day 2' => array_slice($workoutData, $volume, $volume),
            'Day 3' => array_slice($workoutData, $volume*2, $volume),
            'Day 4' => array_slice($workoutData, $volume*3, $volume),
            'Day 5' => array_slice($workoutData, $volume*4, $volume),
            'Day 6' => array_slice($workoutData, $volume*5, $volume),
            'Day 7' => array_slice($workoutData, $volume*6, $volume)
        ];
    }



    //dd($workoutData);
    //return workout result view
    return view('workouts.result', [
        'workoutPlan' => $validatedData,
        //to access the workout plan in the results.blade.php would need to use $workoutData
        //to ouput each days individual exercises would need to use $plan
        'workoutData' => $plan,
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