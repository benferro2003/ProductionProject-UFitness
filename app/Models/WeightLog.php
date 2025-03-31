<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeightLog extends Model
{
    use HasFactory;

    protected $table = 'weight_logs'; 
    protected $fillable = ['user_id', 'weight', 'goal']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
