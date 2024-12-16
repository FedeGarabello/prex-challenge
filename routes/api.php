<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\GifController;
use App\Http\Middleware\ApiRequestResponseLogger;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::prefix('gifs')->group(function () {
    Route::get('/search', [GifController::class, 'searchGifts'])->middleware('auth:api');
    Route::get('/{id}', [GifController::class, 'searchGifById'])->middleware('auth:api');
    Route::post('/{id}/favorite', [GifController::class, 'saveGifAsFavorite'])->middleware('auth:api');
});

