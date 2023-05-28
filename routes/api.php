<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ModelController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{product}', 'show');
    Route::post('/products', 'store');
    Route::put('/products/{product}', 'update');
    Route::patch('/products/{product}', 'update');
    Route::delete('/products/{product}', 'destroy');
});

Route::controller(ClientController::class)->group(function () {
    Route::get('/clients', 'index');
    Route::get('/clients/{client}', 'show');
    Route::post('/clients', 'store');
    Route::put('/clients/{client}', 'update');
    Route::patch('/clients/{client}', 'update');
    Route::delete('/clients/{client}', 'destroy');
});

Route::controller(OrderController::class)->group(function () {
    Route::get('/orders', 'index');
    Route::get('/orders/{order}', 'show');
    Route::post('/orders', 'store');
    Route::put('/orders/{order}', 'update');
    Route::patch('/orders/{order}', 'update');
    Route::delete('/orders/{order}', 'destroy');
    Route::post('/orders/{order}/confirm', 'confirm');
    Route::post('/orders/{order}/reject', 'reject');
    Route::post('/orders/{order}/deliver', 'deliver');
});

Route::get('/models/{model}', [ModelController::class, 'index']);
Route::get('/models/{model}/{id}', [ModelController::class, 'show']);

