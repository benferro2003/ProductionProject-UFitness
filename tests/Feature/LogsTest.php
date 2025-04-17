<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogsTest extends TestCase
{
    
    //test valid data for weight log
     public function testValidWeightLogFormEntry()
     {
         // simulated a logged in user
         $user = User::factory()->create();
         $this->actingAs($user);
 
         $response = $this->from(route('weightLog.show'))
         ->post(route('log.weight'), [
             'weight' => '83.00',
             'weight_goal' => 'loss', 
         ]);
     
         $response->assertRedirect(route('dashboard'));
         $this->assertDatabaseHas('weight_logs', [
            'user_id' => $user->id,
            'weight' => '83.00',
            'goal' => 'loss',
        ]);
     }

     //test valid data for workout log
     public function testValidActivityLogFormEntry()
     {
        // simulated a logged in user
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->from(route('activityLog.show'))
        ->post(route('log.workout'), [
            'workout_name' => 'push',
            'duration' => '50', 
        ]);
    
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'workout_name' => 'push',
            'duration' => '50',
        ]);
    }

    //test invalid data for weight log
    public function testInvalidWeightLogFormEntry()
    {
        // simulated a logged in user
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->from(route('weightLog.show'))
        ->post(route('log.weight'), [
            'weight' => 'hello',
            'weight_goal' => 'loss', 
        ]);
    
        $response->assertSessionHasErrors(['weight']);
    }

    //test invalid data for workout log - extreme duration
    public function testInvalidActivityLogFormEntry()
    {
        // simulated a logged in user
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->from(route('activityLog.show'))
        ->post(route('log.workout'), [
            'workout_name' => 'push',
            'duration' => '1000000000', 
        ]);
    
        $response->assertSessionHasErrors(['duration']);
    }
 
}
