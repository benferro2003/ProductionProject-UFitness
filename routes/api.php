<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiWorkoutController;
use App\Http\Controllers\Api\ApiLogController;
use App\Http\Controllers\Api\ApiCalculatorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes (no authentication required)
Route::prefix('v1')->group(function () {
    // Authentication routes only
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
});

// Protected routes (require authentication)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    
    // Auth routes
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Dashboard route
    Route::get('/dashboard', [ApiLogController::class, 'getDashboard']);
    
    // Calculator routes (PROTECTED - require auth)
    Route::post('/calculators/calorie', [ApiCalculatorController::class, 'calorie']);
    Route::post('/calculators/one-rep-max', [ApiCalculatorController::class, 'oneRepMax']);
    Route::post('/calculators/bmi', [ApiCalculatorController::class, 'bmi']);
    
    // Workout routes
    Route::post('/workouts/generate', [ApiWorkoutController::class, 'generate']);
    Route::get('/workouts', [ApiWorkoutController::class, 'index']);
    Route::post('/workouts', [ApiWorkoutController::class, 'store']);
    Route::get('/workouts/{id}', [ApiWorkoutController::class, 'show']);
    Route::delete('/workouts/{id}', [ApiWorkoutController::class, 'destroy']);
    
    // Activity Log routes
    Route::post('/logs/activity', [ApiLogController::class, 'storeActivity']);
    Route::get('/logs/activity', [ApiLogController::class, 'getActivity']);
    Route::delete('/logs/activity/{id}', [ApiLogController::class, 'destroyActivity']);
    
    // Weight Log routes
    Route::post('/logs/weight', [ApiLogController::class, 'storeWeight']);
    Route::get('/logs/weight', [ApiLogController::class, 'getWeight']);
    Route::delete('/logs/weight/{id}', [ApiLogController::class, 'destroyWeight']);
});
