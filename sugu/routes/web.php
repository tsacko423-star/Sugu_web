<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AttributsController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EmploieController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoitureController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])->middleware('admin')->name('dashboard.admin');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AnnonceController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/voitures/create', [VoitureController::class, 'create'])->name('voitures.create');
    Route::post('/voitures', [VoitureController::class, 'store'])->name('voitures.store');
    Route::get ('/emplois/create', [EmploieController::class, 'create'])->name('emploie.create');
    Route::post('/emplois', [EmploieController::class, 'store'])->name('emplois.store');
    Route::get('/bien/create', [BienController::class, 'create'])->name('bien.create');
    Route::post('/bien', [BienController::class, 'store'])->name('bien.store');
    Route::get('/bien/{bien}/edit', [BienController::class, 'edit'])->name('bien.edit');
    Route::put('/bien/{bien}', [BienController::class, 'update'])->name('bien.update');
    Route::delete('/bien/{bien}', [BienController::class, 'destroy'])->name('bien.destroy');
     Route::get('/voitures', [VoitureController::class, 'index'])->name('voitures.index');
     Route::get('/emplois', [EmploieController::class, 'index'])->name('emplois.index');
     Route::get('/bien', [BienController::class, 'index'])->name('bien.index');
     Route::get('/voitures/{voiture}/edit', [VoitureController::class, 'edit'])->name('voitures.edit');
    Route::put('/voitures/{voiture}', [VoitureController::class, 'update'])->name('voitures.update');
    Route::delete('/voitures/{voiture}', [VoitureController::class, 'destroy'])->name('voitures.destroy');
    
     Route::get('/emplois/{emploie}/edit', [EmploieController::class, 'edit'])->name('emplois.edit');
    Route::put('/emplois/{emploie}', [EmploieController::class, 'update'])->name('emplois.update');
    Route::delete('/emplois/{emploie}', [EmploieController::class, 'destroy'])->name('emplois.destroy');




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