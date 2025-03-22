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

    //if value of target muscles is fullbody, then set target muscles to all target muscles
    if($validatedData['target_muscles'][0] === 'full body'){
        $validatedData['target_muscles'] = ['back', 'cardio', 'chest', 'lower arms', 'lower legs', 'shoulders', 'upper arms', 'upper legs','waist','neck'];
    }

    //same for available days
    if($validatedData['available_days'][0] === 'all days'){
        $validatedData['available_days'] = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    }

    //same for equipment
    if($validatedData['equipment'][0] === 'all equipment'){
        $validatedData['equipment'] = ['dumbbell', 'barbell', 'kettlebell', 'body weight', 'cable'];
    }

    //dd($validatedData);

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
    //dd($validatedData);
    //filter exercises based where $target_muscles matches $decodedresponse['bodyPart']
    $filteredExercises = array_filter($workoutData, function ($exercise) use ($validatedData) {
        return in_array($exercise['bodyPart'], $validatedData['target_muscles']);
    });

    //dd($filteredExercises);
    //dd($validatedData);


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
    //api target muscles list
    //0:"abductors"
    //1:"abs"
    //2:"adductors"
    ///3:"biceps"
    ///4:"calves"
    ///5:"cardiovascular system"
    ///6:"delts"
    ///7:"forearms"
    ///8:"glutes"
    ///9:"hamstrings"
    ///10:"lats"
    ///11:"levator scapulae"
    ///12:"pectorals"
    ///13:"quads"
    ///14:"serratus anterior"
    ///15:"spine"
    ///16:"traps"
    ///17:"triceps"
    ///18:"upper back"
    $splitTarget = [
        'FullBody' => ['abs', 'biceps', 'calves', 'cardiovascular system', 'delts', 'forearms', 'glutes', 'hamstrings', 'lats', 'pectorals', 'quads', 'serratus anterior', 'spine', 'traps', 'triceps', 'upper back'],
        'UpperDay' => ['biceps', 'delts', 'forearms','lats', 'pectorals','traps', 'triceps', 'upper back'],
        'LowerDay' => ['abs', 'calves', 'cardiovascular system', 'glutes', 'hamstrings', 'quads', 'spine','abductors','adductors'],
        'Push' => ['pectorals','traps', 'delts', 'triceps'],
        'Pull' => ['lats', 'biceps', 'forearms', 'upper back'],
        'Legs' => ['quads', 'hamstrings', 'glutes', 'calves', 'abductors', 'adductors'],
    ];

    //dd($splitTarget);


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

    //function that filters workout data based on the split chosen which matched to splitTarget which has the associatd target muscles for each split(splitChosen)
    function mapExercisesToSplit($splitChosen,$splits,$workoutData,$splitTarget)
    {
        //use splitChosen to get splitTarget, then use splitTarget to filter workoutData matching the target muscles
        //Illegal offset type
        //$i relates to index of split days e.g. $splitDays[0] = 'Push', in this instance
        //need to make for loop to filter 
        $splitDays = $splits[$splitChosen];
        $filteredExercises = [];
        for ($i = 0; $i < count($splitDays); $i++) {
            //randomize the exercises
            shuffle($workoutData);
            $filteredExercises[$splitDays[$i]] = array_filter($workoutData, function ($exercise) use ($splitTarget,$splitDays,$i) {
                return in_array($exercise['target'], $splitTarget[$splitDays[$i]]);
            });
        }
        return $filteredExercises;
    }

    //function to create a workout plan 
    //based on the filtered exercises, volume and total days
    //returns an array of workout plan
    function createPlan($filteredExercises,$volume,$totalDays,$splitChosen,$splits){
        $plan = [];

        //retrieve the split days based on the split chosen e.g. PPL = ['Push', 'Pull', 'Legs']
        $splitDays = $splits[$splitChosen];
        //count of split days e.g. PPL = 3
        $splitCount = count($splitDays);
    
        //for loop to create the workout plan
        for ($i = 0; $i < $totalDays; $i++) {
            //get the day based on the split days
            $day = $splitDays[$i % $splitCount]; 
            //get the exercises for the day
            $exercises = $filteredExercises[$day];
            //shuffle exercises
            $plan["Day " . ($i + 1) . " - $day"] = array_slice($exercises, 0, $volume);
        }
        
        return $plan;
    }

    $splitChosen = createSplit($totalDays,$split);
    $filteredExercises = mapExercisesToSplit($splitChosen,$splits,$filteredExercises,$splitTarget);
    //dd($filteredExercises);
    //result shows correct filtering of push pull leg exercises
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

//to do:
//ensure that the exercises are shuffled such as an upper day has a variety of exercises and tries to cover all target muscles in that split day.
