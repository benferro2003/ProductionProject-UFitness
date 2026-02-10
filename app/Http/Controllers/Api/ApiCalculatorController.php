<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiCalculatorController extends Controller
{
    /**
     * Calculate TDEE (Total Daily Energy Expenditure)
     * POST /api/v1/calculators/calorie
     * 
     * Uses Oxford/Henry equation for BMR calculation
     */
    public function calorie(Request $request)
    {
        $validatedData = $request->validate([
            'age' => 'required|integer|min:18|max:100',
            'weight' => 'required|numeric|min:30',
            'height' => 'required|numeric|min:100',
            'sex' => 'required|in:male,female',
            'activity' => 'required|in:bmr,sedentary,light,moderate,active,very_active',
        ]);

        $age = $validatedData['age'];
        $weight = $validatedData['weight'];
        $height = $validatedData['height'];
        $sex = $validatedData['sex'];
        $activity = $validatedData['activity'];

        // Calculate BMR using Oxford/Henry equation
        // https://macrofactorapp.com/best-bmr-equations/
        if ($sex === 'male') {
            if ($age >= 18 && $age <= 30) {
                // BMR = 14.4 × Body Mass + 3.13 × Height + 113
                $bmr = (14.4 * $weight) + (3.13 * $height) + 113;
            } elseif ($age > 30 && $age <= 60) {
                // BMR = 11.4 × Body Mass + 5.41 × Height - 137
                $bmr = (11.4 * $weight) + (5.41 * $height) - 137;
            } else { // age > 60
                // BMR = 11.4 × Body Mass + 5.41 × Height – 256
                $bmr = (11.4 * $weight) + (5.41 * $height) - 256;
            }
        } else { // female
            if ($age >= 18 && $age <= 30) {
                // BMR = 10.4 × Body Mass + 6.15 × Height – 282
                $bmr = (10.4 * $weight) + (6.15 * $height) - 282;
            } elseif ($age > 30 && $age <= 60) {
                // BMR = 8.18 × Body Mass + 5.02 × Height – 11.6
                $bmr = (8.18 * $weight) + (5.02 * $height) - 11.6;
            } else { // age > 60
                // BMR = 8.52 × Body Mass + 4.21 × Height + 10.7
                $bmr = (8.52 * $weight) + (4.21 * $height) + 10.7;
            }
        }

        // Activity level multipliers
        $activityLevels = [
            'bmr' => 1,
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'active' => 1.725,
            'very_active' => 1.9,
        ];

        // Calculate TDEE = BMR * activity level
        $tdee = $bmr * $activityLevels[$activity];

        return response()->json([
            'success' => true,
            'message' => 'Calorie calculation completed',
            'data' => [
                'bmr' => round($bmr, 2),
                'tdee' => round($tdee, 2),
                'activity_level' => $activity,
                'activity_multiplier' => $activityLevels[$activity],
                'input' => [
                    'age' => $age,
                    'weight' => $weight,
                    'height' => $height,
                    'sex' => $sex,
                ],
            ],
        ], 200);
    }

    /**
     * Calculate One Rep Max
     * POST /api/v1/calculators/one-rep-max
     * 
     * Uses Epley formula: 1RM = weight × (1 + reps/30)
     */
    public function oneRepMax(Request $request)
    {
        $validatedData = $request->validate([
            'max_weight' => 'required|numeric|min:1',
            'reps' => 'required|integer|min:1|max:30',
        ]);

        $maxWeight = $validatedData['max_weight'];
        $reps = $validatedData['reps'];

        // Calculate one rep max using Epley formula
        // https://www.omnicalculator.com/sports/one-rep-max
        $oneRepMax = $maxWeight * (1 + ($reps / 30));

        return response()->json([
            'success' => true,
            'message' => 'One rep max calculation completed',
            'data' => [
                'one_rep_max' => round($oneRepMax, 2),
                'input' => [
                    'weight' => $maxWeight,
                    'reps' => $reps,
                ],
                // Bonus: Calculate percentage-based training weights
                'training_percentages' => [
                    '95%' => round($oneRepMax * 0.95, 2),
                    '90%' => round($oneRepMax * 0.90, 2),
                    '85%' => round($oneRepMax * 0.85, 2),
                    '80%' => round($oneRepMax * 0.80, 2),
                    '75%' => round($oneRepMax * 0.75, 2),
                    '70%' => round($oneRepMax * 0.70, 2),
                ],
            ],
        ], 200);
    }

    /**
     * Calculate BMI (Body Mass Index)
     * POST /api/v1/calculators/bmi
     * 
     * Formula: BMI = weight(kg) / height(m)²
     */
    public function bmi(Request $request)
    {
        $validatedData = $request->validate([
            'weight' => 'required|numeric|min:30|max:500',
            'height' => 'required|numeric|min:100|max:250',
        ]);

        $weight = $validatedData['weight'];
        $heightCm = $validatedData['height'];

        // Convert height from cm to meters
        $heightM = $heightCm / 100;

        // Calculate BMI
        // https://www.nhs.uk/health-assessment-tools/calculate-your-body-mass-index/calculate-bmi-for-adults
        $bmi = $weight / ($heightM * $heightM);

        // Determine BMI category
        if ($bmi < 18.5) {
            $category = 'Underweight';
            $description = 'Below healthy weight range';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            $category = 'Healthy weight';
            $description = 'Within healthy weight range';
        } elseif ($bmi >= 25 && $bmi < 30) {
            $category = 'Overweight';
            $description = 'Above healthy weight range';
        } else { // $bmi >= 30
            $category = 'Obese';
            $description = 'Significantly above healthy weight range';
        }

        return response()->json([
            'success' => true,
            'message' => 'BMI calculation completed',
            'data' => [
                'bmi' => round($bmi, 2),
                'category' => $category,
                'description' => $description,
                'input' => [
                    'weight' => $weight,
                    'height' => $heightCm,
                ],
                // Reference ranges
                'ranges' => [
                    'underweight' => '< 18.5',
                    'healthy' => '18.5 - 24.9',
                    'overweight' => '25.0 - 29.9',
                    'obese' => '≥ 30.0',
                ],
            ],
        ], 200);
    }
}
