<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTagController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('tags', AdminTagController::class)->only(['index', 'create', 'store', 'destroy']);
});
