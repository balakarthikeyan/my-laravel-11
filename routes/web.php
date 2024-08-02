<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('notes', [NoteController::class, 'index']);
// Route::get('notes/create', [NoteController::class, 'create']);
// Route::post('notes', [NoteController::class, 'store']);
// Route::get('notes/{id}', [NoteController::class, 'show']);
// Route::get('notes/{id}/edit', [NoteController::class, 'edit']);
// Route::put('notes/{id}', [NoteController::class, 'update']);
// Route::delete('notes/{id}', [NoteController::class, 'destroy']);

Route::resource('notes', NoteController::class);

Route::get('test-helper', [TestController::class, 'testHelperMethod']);
Route::get('test-interface', [TestController::class, 'testInferfaceMethod']);
Route::get('test-service', [TestController::class, 'testServiceMethod']);
Route::get('test-enum', [TestController::class, 'testEnumMethod']);
Route::get('test-trait', [TestController::class, 'testTraitMethod']);

Route::middleware(['logRequests'])->group(function () {
    Route::get('/middleware-1', function () {
        return 'Example route';
    });
      
    Route::get('/middleware-2', function () {
        return 'Example route 2';
    });
});