<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\CalculatorController;

class CalculatorTest extends TestCase
{

    //test function to test valid calorie data
    public function testValidCalorieData()
    {
        $weight = 83;
        $height = 165;
        $age = 21;
        $activity = 'active';
        $sex = 'male';
        $result = $this
        ->calculateTDEE($age,$weight,$height,$sex,$activity);
        $this->assertEquals(3147.52,$result);

    }

    //test calculate method with invalid data
    private function calculateTDEE($age,$weight,$height,$sex,$activity)
    {
        //check if any parameters are empty)
        if (empty($age) || empty($weight) || empty($height) || empty($sex) || empty($activity)) {
            return 0;
        }

        if ($sex === 'male')
            {
                if($age >= 18 and $age <=30)
                {$bmr = (14.4*$weight) + (3.13*$height) + 113;}
                if ($age > 30 and $age <= 60)
                {$bmr = (11.4*$weight) + (5.41*$height) - 137;}
                if ($age > 60)
                {$bmr = (11.4*$weight) + (5.41*$height) - 256;}
            }
        else if ($sex === 'female')
            {
                if($age >= 18 and $age <= 30)
                { $bmr = (10.4*$weight) + (6.15*$height) - 282;}
                if ($age > 30 and $age <= 60)
                {$bmr = (8.18*$weight) + (5.02*$height) - 11.6;}
                if ($age > 60)
                {$bmr = (8.52*$weight) + (4.21*$height) + 10.7;}
            }
            $activityLevels = [
                'bmr' => 1,
                'sedentary' => 1.2,
                'light' => 1.375,
                'moderate' => 1.55,
                'active' => 1.725,
                'very_active' => 1.9,
            ];
            $tdee = $bmr * $activityLevels[$activity];
            return round($tdee,2);
    }
}
