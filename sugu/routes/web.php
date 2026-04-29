<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AttributsController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EmploieController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoitureController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AnnonceController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/voitures/create', [VoitureController::class, 'create'])->name('voitures.create');
    Route::post('/voitures', [VoitureController::class, 'store'])->name('voitures.store');
    Route::get('/dashboard', [AnnonceController::class, 'dashboard'])->name('dashboard');
    Route::get ('/emplois/create', [EmploieController::class, 'create'])->name('emploie.create');
    Route::post('/emplois', [EmploieController::class, 'store'])->name('emplois.store');
    Route::get('/bien/create', [BienController::class, 'create'])->name('bien.create');
    Route::post('/bien', [BienController::class, 'store'])->name('bien.store');
    });

Route::get('/acceuil', [AnnonceController::class, 'index'])->name('acceuil');

Route::resource('annonces', AnnonceController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('attributs', AttributsController::class);
Route::get('/home', [VoitureController::class, 'index'])->name('home');
Route::post('/message/send', [MessagesController::class, 'send']);
Route::get('/messages/inbox', [MessagesController::class, 'inbox']);
Route::get('/messages/sent', [MessagesController::class, 'sent']);

require __DIR__.'/auth.php';