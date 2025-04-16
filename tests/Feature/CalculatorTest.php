<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;

class CalculatorTest extends TestCase
{
    /**
     * ensure invalid form entrys returns error.
     */
    public function testNonIntegerValue()
    {
        //simulate a logged in user
        $user = User::factory()->create();
        $this->actingAs($user);
        //simulate a post request to the calculator route
        $response = $this->from(route('calculator.show', 'calorie'))
        ->post(route('calculator.calculate', 'calorie'), 
        [
            'age' => 'hello', //non-integer value
            'weight' => 83,
            'height' => 165,
            'sex' => 'male',
            'activity' => 'active',
        ]);

        //assert that the response is a redirect to the calculator page
        $response->assertRedirect('/calculator/calorie');
        //assert that the session has the validation errors
        $response->assertSessionHasErrors(['age']);
    }
}



