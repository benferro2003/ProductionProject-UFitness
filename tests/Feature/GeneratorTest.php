<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class GeneratorTest extends TestCase
{
 
    
    public function testValidEntryWithSplitSelected()
    {
        //simulate a logged in user
        $user = User::factory()->create();
        //simulate a post request to the workout generator route
        $this->actingAs($user);
        $response = $this->post(route('generate.workout'), 
        [
            'available_days' => ['Mon','Tue','Wed'],
            'equipment' => ['dumbbell', 'barbell'],
            'fitness_level' => 'Beginner',
            'training_goal' => 'hypertrophy',
            'workout_split' => 'PPL',
            'target_muscles' => ['fullbody'],
            
        ]);

        //assert response is redirect to result page
        $response->assertRedirect(route('workouts.result'));
        //assert that the session has the workout data - workout plan created
        $response->assertSessionHas('workoutData');
    }


    //test for valid entry with no split selected
    public function testValidEntryWithNoSplitSelected()
    {
        //simulate a logged in user
        $user = User::factory()->create();
        //simulate a post request to the workout generator route
        $this->actingAs($user);
        $response = $this->post(route('generate.workout'), 
        [
            'available_days' => ['Mon','Tue','Wed'],
            'equipment' => ['dumbbell', 'barbell'],
            'fitness_level' => 'Beginner',
            'training_goal' => 'hypertrophy',
            'target_muscles' => ['fullbody'],
            
        ]);

        //assert response is redirect to result page
        $response->assertRedirect(route('workouts.result'));
        //assert that the session has the workout data - workout plan created
        $response->assertSessionHas('workoutData');
    }


    //test for invalid entry with no available days selected
    public function testInvalidEntryWithNoAvailableDays()
    {
        //simulate a logged in user
        $user = User::factory()->create();
        //simulate a post request to the workout generator route
        $this->actingAs($user);
        $response = $this->from(route('generator.show'))
        ->post(route('generate.workout'), 
        [
            'equipment' => ['dumbbell', 'barbell'],
            'fitness_level' => 'Beginner',
            'training_goal' => 'hypertrophy',
            'workout_split' => 'PPL',
            'target_muscles' => ['fullbody'],
            
        ]);

        //assert that the response is a redirect to the workout generator page
        $response->assertRedirect(route('generator.show'));
        //assert that the session has the validation errors
        $response->assertSessionHasErrors(['available_days']);
    }
}
