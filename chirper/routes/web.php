<?php
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [ChirpController::class, 'index']);
// Route::post('/chirps', [ChirpController::class, 'store']);
// Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
// Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
// Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);

Route::resource('chirps', ChirpController::class)
    ->only(['store', 'edit', 'update', 'destroy']);