<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function show($type)
    {
        //check if the calculator type is valid
        $validCalculators = ['calorie', 'one_rep_max', 'bmi'];

        //if not valid, return 404
        if (!in_array($type, $validCalculators)) {
            abort(404); 
        }

        //return the associated calculator view
        return view('calculators.' . $type);
    }




    public function calculate(Request $request, $type)
    {
        //again check if the calculator type is valid
        $validCalculators = ['calorie', 'one_rep_max', 'bmi'];

        //if not valid, return 404
        if (!in_array($type, $validCalculators)) {
            abort(404);
        }

        if ($type === 'calorie')
        {

            $request->validate([
                'age' => 'required|integer|min:18|max:50',
                'weight' => 'required|numeric|min:30',
                'height' => 'required|numeric|min:100',
                'sex' => 'required|in:male,female',
                'activity' => 'required',
            ]);

            $age = $request->input('age');
            $weight = $request->input('weight');
            $height = $request->input('height');
            $sex = $request->input('sex');
            $activity = $request->input('activity');

            //link for bmi calculation: https://www.omnicalculator.com/health/bmr-harris-benedict-equation
            //first need to calculate the BMR
            if ($sex === 'male')
            {
                $bmr = (10*$weight) + (6.25*$height) - (5*$age) + 5;

            }
            else
            {
                $bmr = (10*$weight) + (6.25*$height) - (5*$age) + 5;

            }

            //associate values with activity levels
            $activityLevels = [
                'sedentary' => 1.2,
                'light' => 1.375,
                'moderate' => 1.55,
                'active' => 1.725,
                'very_active' => 1.9,
            ];

            //link for tdee calculation: https://www.omnicalculator.com/health/tdee
            //Calculate total daily expenditure
            $tdee = $bmr * $activityLevels[$activity];

            //store result
            return redirect()->back()->with('result', round($tdee,2));
        }

        //one rep max calculator
        if ($type === 'one_rep_max')
        {
            //validate the request
            $request->validate([
                'max_weight' => 'required|numeric|min:1',
                'reps' => 'required|integer|min:1',
            ]);

            //get the values
            $max = $request->input('max_weight');
            $reps = $request->input('reps');

            //link for calculation: https://www.omnicalculator.com/sports/one-rep-max
            //calculate one rep max
            $oneRepMax = $max * (1 + ($reps/30));

            //store result
            return redirect()->back()->with('result', round($oneRepMax,2));
        }

        //bmi calculator
        if ($type === 'bmi')
        {
            //validate the request
            $request->validate([
                'weight' => 'required|numeric|min:30',
                'height' => 'required|numeric|min:100',

                
            ]);
            $weight = $request->input('weight');
            $height = $request->input('height');

            //calculate bmi
            //link for calculation: https://www.nhs.uk/health-assessment-tools/calculate-your-body-mass-index/calculate-bmi-for-adults
            $height = $height / 100;
            //bmi = weight in kg / height in meters squared 
            $bmi = $weight / ($height * $height);
            //store result
            return redirect()->back()->with('result', round($bmi,2));

        }



    }
}
