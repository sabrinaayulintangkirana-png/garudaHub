<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\RatingController;


Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Halaman yang hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {

    // Halaman utama
    Route::get('/', function () {
        return redirect()->route('projects.index');
    });

    
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Pengelolaan project
    Route::resource('projects', ProjectController::class);

    // Pengelolaan bid
    Route::resource('bids', BidController::class);

    // rating ke developer
    Route::post('/ratings', [RatingController::class, 'store'])
        ->name('ratings.store');
});
