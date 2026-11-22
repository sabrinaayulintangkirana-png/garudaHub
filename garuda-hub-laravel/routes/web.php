<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BidController;


Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect()->route('projects.index');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::resource('projects', ProjectController::class);
    Route::resource('bids', BidController::class);
});