<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\RegisterApiController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/test_auth', function () {
        return response()->json([ 'valid' => auth()->check()]);
    });
});

Route::group(['middleware' => ['logRequests']], function () {
    // Products
    Route::apiResource('products', ProductApiController::class);

    // Material
    Route::get('/material', [ProductController::class, 'index']);
    Route::get('/material/{product}', [ProductController::class, 'show']);
    Route::post('/material', [ProductController::class, 'store']);
    Route::put('/material/{product}', [ProductController::class, 'update']);
    Route::delete('/material/{product}', [ProductController::class, 'destroy']);

    // Login & Register
    Route::controller(RegisterApiController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
});
Route::middleware('auth:api')->group(function () {
    Route::controller(RegisterApiController::class)->group(function () {
        Route::get('me', 'me');
        Route::get('logout', 'logout');
    });
});