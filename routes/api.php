<?php

use Illuminate\Support\Facades\Route;
use App\Domain\Auth\Controllers\RegisterController;
use App\Domain\Auth\Controllers\LoginController;
use App\Domain\Auth\Controllers\MeController;
use App\Domain\Auth\Controllers\LogOutController;
use App\Domain\Categories\Controllers\CategoryController;
use App\Domain\Products\Controllers\ProductController;
use App\Domain\Cart\Controllers\CartController;
use App\Domain\Order\Controllers\OrderController;

// Auth
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'login']);

// Public categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Public products
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Authenticated user routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [MeController::class, 'me']);
    Route::post('/logout', [LogOutController::class, 'logout']);
    Route::post('/cart/items', [CartController::class, 'store']);
    Route::get('/cart', [CartController::class, 'show']);
    Route::delete('/cart/items/{id}', [CartController::class, 'destroy']);
    Route::patch('/cart/items/{id}', [CartController::class, 'patch']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
});

// Admin only routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::post('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::get('/admin/orders', [OrderController::class, 'adminIndex']);
    Route::get('/admin/orders/{id}', [OrderController::class, 'adminShow']);
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);
});
