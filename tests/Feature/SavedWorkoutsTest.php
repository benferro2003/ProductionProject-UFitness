<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SavedWorkoutsTest extends TestCase
{
    use RefreshDatabase;

    public function testValidPlanAllowsWorkoutToBeSaved()
    {
        // simulated a logged in user
        $user = User::factory()->create();
        $this->actingAs($user);

        // created mock workout plan similar to format in db
        $mockWorkoutPlan = [
            "Day 1 - Push" => [
                [  "bodyPart" => "chest",
                    "equipment" => "barbell",
                    "gifUrl" => "https://v2.exercisedb.io/image/Q98AcyRhQY6nu1",
                    "id" => "0033",
                    "name" => "barbell decline bench press",
                    "target" => "pectorals",
                    "secondaryMuscles" => ["triceps", "shoulders"],
                    "instructions" => ["Lie on a decline bench "]],
            ]];
        //encoded mock workout plan to JSON format
        $mockPlan = json_encode($mockWorkoutPlan);
        //simulate a post request to the save workout route
        $response = $this->post(route('save.workout'),
         ['workout_plan' => $mockPlan,]);
        //ensured response is redirect to the saved workouts page
        $response->assertRedirect(route('workouts.show'));
        //asserted that the workout plan was saved in the database
        $this->assertDatabaseHas('saved_workouts', [
            'user_id' => $user->id,
            'workout_plan' => $mockPlan,
        ]);
    }

    //test for invalid data 
    public function testMissingPlanDoesNotAllowPlanToBeSaved()
    {
        // simulated a logged in user
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->from(route('workouts.result'))->post(route('save.workout'), [
            'workout_plan' => '', 
        ]);
    
        $response->assertSessionHasErrors(['workout_plan']);
    }

    //test only authenticated users can save workouts
    public function testUnAuthenticatedUserCannotSaveWorkout()
    {
        //response is not authenticated
        $response = $this->post(route('save.workout'), [
            'workout_plan' => 'WorkoutPlan',
        ]);
    
        //asserted that the user is redirected to the login page
        $response->assertRedirect(route('login'));
    }




}