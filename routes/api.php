<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

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

    Route::get('/sales', [SaleController::class, 'index']); // Lista las ventas
    Route::post('/sales', [SaleController::class, 'store']); // Registra una nueva venta

    Route::get('/sales/report', [SaleController::class, 'generateReport'])->middleware('role:admin');
});


