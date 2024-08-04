<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Collections\MyCollection;
use App\Http\Resources\UserCollection;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\LoginRegisterController;

Route::get('/', function () {
    return view('welcome');
});

// CURD function
Route::resource('notes', NoteController::class);
// Custom function
Route::get('test-helper', [TestController::class, 'testHelperMethod']);
Route::get('test-interface', [TestController::class, 'testInferfaceMethod']);
Route::get('test-service', [TestController::class, 'testServiceMethod']);
Route::get('test-enum', [TestController::class, 'testEnumMethod']);
Route::get('test-trait', [TestController::class, 'testTraitMethod']);
Route::get('test-once', [TestController::class, 'testOnceMethod']);
// Middleware function
Route::middleware(['logRequests'])->group(function () {
    Route::get('/middleware-1', function () {
        return 'Example route';
    });
    Route::get('/middleware-2', function () {
        return 'Example route 2';
    });
});
// Users
Route::get('users', [UserController::class, 'index']);
// Localization
Route::get('lang', [LocalizationController::class, 'index']);
Route::get('change/lang', [LocalizationController::class, 'lang_change'])->name('LangChange');
// Collection
Route::get('users-own-collection', function () {
    $users = User::query()->paginate(10);
    return new MyCollection($users, 'Users data as Collection', true, [
        'follow-me' => true
    ]);
});
Route::get('users-collection', function () {
    $users = User::query()->paginate(10);
    return (new UserCollection($users))->additional([
        'meta' => [
            'prefix' => 'laravel-',
            'sufix' => '-laravel'
        ]
    ]);
});

// Login & Register
Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'registration')->name('register');
    Route::post('/register', 'postRegistration')->name('register.post');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'postLogin')->name('login.post');
    Route::get('/home', 'home')->name('home');
    Route::post('/logout', 'logout')->name('logout');
});

// Auth::routes();

// Users Routes with Middleware & Multi Auth
Route::middleware(['auth', 'authUser:user'])->group(function () {
    Route::get('/user/dashboard', [LoginRegisterController::class, 'userDashboard'])->name('user.dashboard');
});

// Manager Routes with Middleware & Multi Auth
Route::middleware(['auth', 'authUser:manager'])->group(function () {
    Route::get('/manager/dashboard', [LoginRegisterController::class, 'managerDashboard'])->name('manager.dashboard');
});

// Super Admin Routes with Middleware & Multi Auth
Route::middleware(['auth', 'authUser:admin'])->group(function () {
    Route::get('/admin/dashboard', [LoginRegisterController::class, 'adminDashboard'])->name('admin.dashboard');
});
