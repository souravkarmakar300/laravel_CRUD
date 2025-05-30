<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MultipleImageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// For Products Table

// Registetr Page
Route::get('/', [ProductController::class, 'register'])->name('register')->name('home');
Route::post('/register/store', [ProductController::class, 'register_store'])->name('register.store');

// Login Page 
Route::get('/login', [ProductController::class, 'Show_login'])->name('login');
Route::post('/login/store', [ProductController::class, 'login_store'])->name('login.store');

Route::middleware(['auth:web'])->group(function(){

    Route::get('/index', [ProductController::class, 'index'])->name('index');
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products/store', [ProductController::class, 'store']);
    Route::get('/ownprofile/{id}/show', [ProductController::class, 'ownprofile'])->name('ownprofile');

// Admin Route Authenticate Using Gate
    route::middleware('can:isAdmin')->group(function(){

        Route::get('products/{id}/edit', [ProductController::class, 'edit']);
        Route::put('/products/{id}/update', [ProductController::class, 'update']);
    });

    Route::delete('/products/{id}/delete', [ProductController::class, 'destroy']);
    Route::get('/products/{id}/show', [ProductController::class, 'show']);
    Route::get('/logout', [ProductController::class, 'logout'])->name('logout');
});

Route::resource('customer', CustomerController::class);
Route::resource('post', PostController::class);




// Multiple Image Upload
Route::get('/images',[MultipleImageController::class, 'images'])->name('images');
Route::post('/images/store',[MultipleImageController::class, 'store'])->name('images.store');
Route::get('/image/{id}/edit',[MultipleImageController::class, 'edit'])->name('image.edit');
route::put('/image/{id}/update',[MultipleImageController::class, 'update'])->name('image.update');
