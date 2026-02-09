<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
});

// Protected routes (require authentication)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Workouts routes (we'll add these next)
    // Route::post('/workouts/generate', [WorkoutController::class, 'generate']);
    // Route::get('/workouts', [WorkoutController::class, 'index']);
    // Route::post('/workouts', [WorkoutController::class, 'store']);
    // Route::delete('/workouts/{id}', [WorkoutController::class, 'destroy']);
    
    // Logs routes (we'll add these next)
    // Route::post('/logs/activity', [LogController::class, 'storeActivity']);
    // Route::post('/logs/weight', [LogController::class, 'storeWeight']);
    // Route::get('/logs/activity', [LogController::class, 'getActivity']);
    // Route::get('/logs/weight', [LogController::class, 'getWeight']);
    
    // Dashboard route (we'll add this next)
    // Route::get('/dashboard', [DashboardController::class, 'index']);
});
