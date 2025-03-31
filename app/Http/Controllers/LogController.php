<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedWorkout;

class LogController extends Controller
{
    public function showActivity()
    {
        return view('Logs.activity-log');
    }

    public function showWeight()
    {
        return view('Logs.weight-log');
    }


}





