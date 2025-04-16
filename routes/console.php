<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\SendLogReminder;

Artisan::command('reminder:log', function () {
    $this->call(SendLogReminder::class);
})->describe('Send a weekly log reminder to all users');

Schedule::call(function () {
    Artisan::call('reminder:log');  
})->weeklyOn(1, '10:00') 
  ->timezone('Europe/London');
