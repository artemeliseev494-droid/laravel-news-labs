<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JournalistController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewsController::class, 'index'])->name('home');
Route::get('/category/{id?}', [NewsController::class, 'category'])->name('category');
Route::get('/article/{id}', [NewsController::class, 'show'])->name('article.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['role:journalist,admin'])->group(function () {
    Route::get('/journalist', [JournalistController::class, 'index'])->name('journalist.index');
    Route::post('/journalist', [JournalistController::class, 'store'])->name('journalist.store');
    Route::get('/journalist/{id}/edit', [JournalistController::class, 'edit'])->name('journalist.edit');
    Route::put('/journalist/{id}', [JournalistController::class, 'update'])->name('journalist.update');
    Route::delete('/journalist/{id}', [JournalistController::class, 'destroy'])->name('journalist.destroy');
});

Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/articles/{id}/toggle-block', [AdminController::class, 'toggleBlock'])->name('admin.articles.toggleBlock');
    Route::delete('/articles/{id}', [AdminController::class, 'deleteArticle'])->name('admin.articles.delete');
    Route::get('/articles/{id}/edit', [AdminController::class, 'editArticle'])->name('admin.articles.edit');
    Route::put('/articles/{id}', [AdminController::class, 'updateArticle'])->name('admin.articles.update');
    Route::post('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.updateRole');
});
