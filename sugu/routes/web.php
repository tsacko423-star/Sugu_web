<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnonceAttributsController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AttributsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoitureController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('annonces', AnnonceController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('categories', CategoriesController::class);
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
});
Route::get('/acceuil', [AnnonceController::class, 'index'])->name('acceuil');



Route::resource('attributs', AttributsController::class);
Route::get('/home', [VoitureController::class, 'index'])->name('home');
Route::post('/message/send', [MessagesController::class, 'send']);
Route::get('/messages/inbox', [MessagesController::class, 'inbox']);
Route::get('/messages/sent', [MessagesController::class, 'sent']);
Route::resource('annonce-attributs', AnnonceAttributsController::class);

require __DIR__.'/auth.php';