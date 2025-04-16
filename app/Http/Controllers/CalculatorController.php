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
                'age' => 'required|integer|min:18|max:100',
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

            //oxford/henry equation used
            //https://macrofactorapp.com/best-bmr-equations/
            if ($sex === 'male')
            {
                if($age >= 18 and $age <=30)
                {
                    //BMR = 14.4 × Body Mass + 3.13 × Height + 113
                    $bmr = (14.4*$weight) + (3.13*$height) + 113;
                }
                if ($age > 30 and $age <= 60)
                {
                    //BMR = 11.4 × Body Mass + 5.41 × Height -137
                    $bmr = (11.4*$weight) + (5.41*$height) - 137;
                }
                if ($age > 60)
                {
                    //BMR = 11.4 × Body Mass + 5.41 × Height – 256
                    $bmr = (11.4*$weight) + (5.41*$height) - 256;
                }
                

            }
            else if ($sex === 'female')
            {
                if($age >= 18 and $age <= 30)
                {
                    //BMR = 10.4 × Body Mass + 6.15 × Height – 282
                    $bmr = (10.4*$weight) + (6.15*$height) - 282;
                }
                if ($age > 30 and $age <= 60)
                {
                    //BMR = 8.18 × Body Mass + 5.02 × Height – 11.6
                    $bmr = (8.18*$weight) + (5.02*$height) - 11.6;
                }
                if ($age > 60)
                {
                    //BMR = 8.52 × Body Mass + 4.21 × Height + 10.7
                    $bmr = (8.52*$weight) + (4.21*$height) + 10.7;
                }
            }
           

            //associate values with activity levels
            $activityLevels = [
                'bmr' => 1,
                'sedentary' => 1.2,
                'light' => 1.375,
                'moderate' => 1.55,
                'active' => 1.725,
                'very_active' => 1.9,
            ];

            //calculate TDEE = BMR * activity level value
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
