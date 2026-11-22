
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BidController;

// Halaman utama
Route::get('/', function () {
    return redirect()->route('projects.index');
});

// Route CRUD Project
Route::resource('projects', ProjectController::class);

// Route CRUD Bid
Route::resource('bids', BidController::class);
