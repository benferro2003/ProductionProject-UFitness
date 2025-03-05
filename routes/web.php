<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalculatorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

//Dashboard route
Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

//Calculator routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/calculator/{type}', [CalculatorController::class, 'show'])->name('calculator.show');
    //Route for calculating the calories
    Route::post('/calculator/{type}/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

});

//Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
