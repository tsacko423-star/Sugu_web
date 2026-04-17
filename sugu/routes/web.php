<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AttributsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BienController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoriesController::class)->only(['create', 'store']);
});
Route::get('/acceuil', [AnnonceController::class, 'index'])->name('acceuil');

Route::get('/', [BienController::class, 'index']);

Route::resource('annonces', AnnonceController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('attributs', AttributsController::class);

// Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');

Route::post('/message/send', [MessagesController::class, 'send']);
Route::get('/messages/inbox', [MessagesController::class, 'inbox']);
Route::get('/messages/sent', [MessagesController::class, 'sent']);

require __DIR__.'/auth.php';