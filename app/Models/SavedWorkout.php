<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedWorkout extends Model
{
    use HasFactory;

    protected $table = 'saved_workouts'; 
    protected $fillable = ['user_id', 'workout_plan']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
