<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/', function () {
    // Jika user sudah terautentikasi, arahkan ke dashboard.
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Auth
Route::get('register', [RegisterController::class, 'show'])->name('register');
Route::post('register', [RegisterController::class, 'store']);

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

// Dashboard and posts
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Specific routes MUST come before resource routes to match first
    Route::get('posts/export', [PostController::class, 'export'])->name('posts.export');
    Route::get('posts/chart-data', [PostController::class, 'postsPerMonth'])->name('posts.chart');

    // Resource routes
    Route::resource('posts', PostController::class);
});
