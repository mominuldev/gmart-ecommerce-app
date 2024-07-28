<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

// User routes
Route::middleware('auth')->group(function () {
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// Admin routes
Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
