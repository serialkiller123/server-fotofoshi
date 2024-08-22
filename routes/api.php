<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\APIKeyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Routes that require Sanctum authentication
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/{id}', [UserController::class, 'getUserById']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/apikeys/{userId}', [APIKeyController::class, 'getAllKeys']);
    Route::post('/generate-key', [APIKeyController::class, 'generate']);
    Route::delete('/keys/{id}', [APIKeyController::class, 'deleteKey']);
    Route::resource('images', ImageController::class);
    
    // Route::post('/logout', [LoginController::class, 'logout']);
});

// Routes that require API key validation
Route::middleware('api_key')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/user-x/{id}', [UserController::class, 'getUserById']);
    Route::resource('images-app', ImageController::class);
    Route::get('/validate-apikey/{key}', [APIKeyController::class, 'validateKey']);
    
});
Route::post('/logout-user', [AuthenticatedSessionController::class, 'destroy']);
