<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LogController::class, 'showLogs'])->name('home');

//Dashboard route
Route::get('/dashboard', [LogController::class, 'showLogs'])->name('dashboard');


//Calculator routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/calculator/{type}', [CalculatorController::class, 'show'])->name('calculator.show');
    //Route for calculate function
    Route::post('/calculator/{type}/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

});

//workout routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/workouts/create', [WorkoutController::class, 'show'])->name('generator.show');
    Route::get('/userInfo/savedWorkouts', [WorkoutController::class, 'showSavedWorkouts'])->name('workouts.show');
    Route::post('/workouts/result', [WorkoutController::class, 'generate'])->name('generate.workout');
    Route::post('/userInfo/savedWorkouts', [WorkoutController::class, 'saveWorkout'])->name('save.workout');
    Route::get('/workouts/result', [WorkoutController::class, 'showResult'])->name('workouts.result');
    Route::delete('/userInfo/savedWorkouts/{id}', [WorkoutController::class, 'deletePlan'])->name('plan.delete');
});

//Log routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/Logs/activity-log', [LogController::class, 'showActivity'])->name('activityLog.show');
    Route::get('/Logs/weight-log', [LogController::class, 'showWeight'])->name('weightLog.show');
    Route::post('/Logs/activity-log', [LogController::class, 'logWorkout'])->name('log.workout');
    Route::post('/Logs/weight-log', [LogController::class, 'logWeight'])->name('log.weight');
});


//Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';