<?php

use App\Http\Controllers\Api\ChirpLikeController;
use Illuminate\Support\Facades\Route;

// Префикс /api/ уже применяется автоматически!
Route::middleware('web'/*'auth:sanctum'*/)->group(function () {
    Route::post('/chirps/{chirp}/like', [ChirpLikeController::class, 'like']);
    Route::post('/chirps/{chirp}/unlike', [ChirpLikeController::class, 'unlike']);
});

// Временно убираем middleware для теста
// Route::post('/chirps/{chirp}/like', [ChirpLikeController::class, 'like']);
// Route::post('/chirps/{chirp}/unlike', [ChirpLikeController::class, 'unlike']);