<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Collections\MyCollection;
use App\Http\Resources\UserCollection;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ProductBaseController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\LoginRegisterController;

Route::get('/', function () {
    return view('welcome');
});

// Middleware function
Route::middleware(['logRequests'])->group(function () {

    // CURD function
    Route::resource('notes', NoteController::class);

    // Custom function
    Route::get('test-helper', [TestController::class, 'testHelperMethod']);
    Route::get('test-interface', [TestController::class, 'testInferfaceMethod']);
    Route::get('test-service', [TestController::class, 'testServiceMethod']);
    Route::get('test-enum', [TestController::class, 'testEnumMethod']);
    Route::get('test-trait', [TestController::class, 'testTraitMethod']);
    Route::get('test-once', [TestController::class, 'testOnceMethod']);
    Route::get('test-facade', [TestController::class, 'testFacadeMethod']);

    // Users
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/search', [UserController::class, 'search'])->name('users.search');

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
        Route::post('/logout', 'logout')->name('logout');
    });
    
    // Auth::routes();

    // Products
    Route::get('/products', [ProductBaseController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductBaseController::class, 'create'])->name('products.create');
    Route::get('/products/{product}', [ProductBaseController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductBaseController::class, 'edit'])->name('products.edit'); 
    Route::post('/products', [ProductBaseController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductBaseController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductBaseController::class, 'destroy'])->name('products.destroy');

    // File Upload
    Route::get('/file-upload', [FileUploadController::class, 'index'])->name('fileupload.index');
    Route::post('/multiple-file-upload', [FileUploadController::class, 'multipleUpload'])->name('multiple.fileupload');

});

// Users Routes with Middleware & Multi Auth
Route::middleware(['auth', 'authUser:user', 'logRequests'])->group(function () {
    Route::controller(LoginRegisterController::class)->group(function () {
        Route::get('/user/dashboard', 'userDashboard')->name('user.dashboard');
    });
});

// Manager Routes with Middleware & Multi Auth
Route::middleware(['auth', 'authUser:manager', 'logRequests'])->group(function () {
    Route::get('/manager/dashboard', [LoginRegisterController::class, 'managerDashboard'])->name('manager.dashboard');
});

// Super Admin Routes with Middleware & Multi Auth
Route::middleware(['auth', 'authUser:admin', 'logRequests'])->group(function () {
    Route::get('/admin/dashboard', [LoginRegisterController::class, 'adminDashboard'])->name('admin.dashboard');
});
