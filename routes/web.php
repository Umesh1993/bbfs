<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Products\ProductController;

//website
use App\Http\Controllers\Website\Auth\AuthController as WebAuthController;

Route::prefix('/')->name('web.')->middleware('guest:web')->group(function () {
     Route::get('/', [WebAuthController::class, 'showLoginForm'])->name('login');
});


Route::middleware('auth:web')->group(function () {
});

Route::prefix('admin')->name('admin.')->middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'admin.role'])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    // categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

    // products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


