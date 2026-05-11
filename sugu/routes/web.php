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
Route::get('/acceuil', [AnnonceController::class, 'index'])->name('acceuil');

Route::middleware('auth')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Annonces
    Route::resource('annonces', AnnonceController::class);
    
    // Messages
    Route::post('/message/send', [MessagesController::class, 'send']);
    Route::get('/messages/inbox', [MessagesController::class, 'inbox']);
    Route::get('/messages/sent', [MessagesController::class, 'sent']);
    
    // Attributs
    Route::resource('attributs', AttributsController::class);
    Route::resource('annonce-attributs', AnnonceAttributsController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('categories', CategoriesController::class);
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
});

Route::get('/home', [VoitureController::class, 'index'])->name('home');

require __DIR__.'/auth.php';