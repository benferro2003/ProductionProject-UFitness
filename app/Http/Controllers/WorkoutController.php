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
        'workout_split' => 'string',
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

    //dd($filteredExercises);


    //set volume of exercises per workout based on the user's fitness level
    //For now just set the volume based on the fitness level not the split.
    $fitnessLevel = $validatedData['fitness_level'];
    switch($fitnessLevel){
        case 'Beginner':
            $volume = 4;
            break;
        case 'Intermediate':
            $volume = 6;
            break;
        case 'Advanced':
            $volume = 8;
            break;
    }


    $goal = $validatedData['training_goal'];
 
    //switch case to set the number of sets and reps based on the user's goal
    switch($goal){
        case 'strength':
            $reps = "4-6";
            $sets = 2;
            break;
        case 'hypertrophy':
            $reps = "8-10";
            $sets = 3;
            break;
        case 'endurance':
            $reps = "10-12";
            $sets = 4;
            break;
    }

    $splits = [
        'FullBody' => ['FullBody'],
        'UpperLower' => ['UpperDay', 'LowerDay'],
        'PPL' => ['Push', 'Pull', 'Legs'],
    ];

    $split = $validatedData['workout_split']??null;
    function createSplit($totalDays,$split = null): string
    {
        if($split){return $split;}
        else{
            if ($totalDays <= 2){return 'FullBody';}
            elseif ($totalDays <= 3){return 'UpperLower';}
            else{return 'PPL';}
        }

    }

    //function to create a workout plan 
    //based on the filtered exercises, volume and total days
    //returns an array of workout plan
    function createPlan($filteredExercises,$volume,$totalDays,$splitChosen,$splits){
        $workoutData = array_slice($filteredExercises, 0, $volume * $totalDays);
        $plan = [];

        $splitDays = $splits[$splitChosen];
        $splitCount = count($splitDays);

        for ($i = 0; $i < $totalDays; $i++) {
            $day = $splitDays[$i % $splitCount];
            $plan["Day" . ($i+1) . " - $day"] = array_slice($workoutData, $i * $volume, $volume);
        }

        return $plan;
    }

    $splitChosen = createSplit($totalDays,$split);
    $plan = createPlan($filteredExercises,$volume,$totalDays,$splitChosen,$splits);



    //dd($workoutData);
    //return workout result view
    return view('workouts.result', [
        'workoutPlan' => $validatedData,
        'workoutData' => $plan,
        'sets' => $sets,
        'reps' => $reps
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