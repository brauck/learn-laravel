<?php
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [ChirpController::class, 'index']);