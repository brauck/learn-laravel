<?php
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;


// Route::get('/', function () {
//     return view('home');
// });

/*// Home route
Route::get('/', [ChirpController::class, 'index']);
// Route::post('/chirps', [ChirpController::class, 'store']);
// Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
// Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
// Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);

// Route::resource('chirps', ChirpController::class)
//     ->only(['store', 'edit', 'update', 'destroy']);

// Registration routes
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');

Route::post('/register', Register::class)
    ->middleware('guest');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/chirps', [ChirpController::class, 'store']);
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);
});

// Login routes
Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', Login::class)
    ->middleware('guest');

// Logout route
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');


// Profile route
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Like routes
Route::post('/chirps/{chirp}/like', [LikeController::class, 'store'])
    ->middleware('auth')
    ->name('chirps.like');

Route::delete('/chirps/{chirp}/like', [LikeController::class, 'destroy'])
    ->middleware('auth')
    ->name('chirps.unlike');*/

// Home
Route::get('/', [ChirpController::class, 'index'])->name('home');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', Register::class)->name('register.store');

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', Login::class)->name('login.store');
});

// Auth routes
Route::middleware('auth')->group(function () {

    // Chirps
    Route::resource('chirps', ChirpController::class)
        ->only(['store', 'edit', 'update', 'destroy']);

    // Likes
    Route::post('/chirps/{chirp}/like', [LikeController::class, 'store'])->name('chirps.like');
    Route::delete('/chirps/{chirp}/like', [LikeController::class, 'destroy'])->name('chirps.unlike');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Logout
    Route::post('/logout', Logout::class)->name('logout');
});
