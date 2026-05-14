<?php

use Illuminate\Support\Facades\Route;
use App\Domain\Auth\Controllers\RegisterController;
use App\Domain\Auth\Controllers\LoginController;
use App\Domain\Auth\Controllers\MeController;
use App\Domain\Auth\Controllers\LogOutController;
use App\Domain\Categories\Controllers\CategoryController;
use App\Domain\Products\Controllers\ProductController;

// Auth
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'login']);

// Public categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/products', [ProductController::class, 'index']);


// Private routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [MeController::class, 'me']);
    Route::post('/logout', [LogOutController::class, 'logout']);

    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});
