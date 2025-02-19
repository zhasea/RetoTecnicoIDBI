<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/holaxd', function () {
    return response()->json(['message' => 'Hola Mundo']);
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('/products', [ProductController::class, 'index']); 
    Route::post('/products', [ProductController::class, 'store'])->middleware('role:vendedor,admin'); 
    Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('role:vendedor,admin'); 
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('role:admin'); 
});


