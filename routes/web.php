<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rutas del Blog
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Rutas de Autenticación y Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas del editor
Route::middleware(['auth'])->group(function () {
    Route::get('/editor/posts/{post}', [App\Http\Controllers\PostEditorController::class, 'edit'])
        ->name('editor.post.edit');
    Route::post('/editor/posts/{post}/save', [App\Http\Controllers\PostEditorController::class, 'save'])
        ->name('editor.post.save');
});

require __DIR__.'/auth.php';
