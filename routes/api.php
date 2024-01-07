<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\AuthenticationController::class, 'login']);
    // Add other authentication routes here
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [App\Http\Controllers\ProductsController::class, 'index']);
        Route::get('/show', [App\Http\Controllers\ProductsController::class, 'show']);
        Route::post('/create', [App\Http\Controllers\ProductsController::class, 'store']);
        Route::get('/edit/{id}', [App\Http\Controllers\ProductsController::class, 'edit']);
        Route::put('/update/{id}', [App\Http\Controllers\ProductsController::class, 'update']);
        Route::delete('/delete/{id}', [App\Http\Controllers\ProductsController::class, 'destroy']);
    });
});
