<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\RegisterApiController;
use App\Http\Controllers\LoginRegisterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(Authenticate::using('sanctum'));

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('products', ProductApiController::class);
});

// Route::get('/products', [ProductController::class, 'index']);
// Route::get('/products/{id}', [ProductController::class, 'show']);
// Route::post('/products', [ProductController::class, 'store']);
// Route::put('/products/{id}', [ProductController::class, 'update']);
// Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::controller(RegisterApiController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'registration')->name('register');
    Route::post('/register', 'postRegistration')->name('register.post');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'postLogin')->name('login.post');
    Route::get('/home', 'home')->name('home');
    Route::post('/logout', 'logout')->name('logout');
});