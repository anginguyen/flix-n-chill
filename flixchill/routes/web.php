<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/home', 'home')->name('index');
Route::get('/search', [ApiController::class, 'search'])->name('search');

Route::get('/details/{type}/{id}', [ApiController::class, 'show'])->name('show');

Route::view('/register', 'auth/registration')->name('registration');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::view('/login', 'auth/login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit/{id}', [ProfileController::class, 'index'])->name('profile.edit');
    Route::post('/profile/edit/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete/{id}', [ProfileController::class, 'delete'])->name('profile.delete');
    Route::post('/profile/favorite/{id}', [ProfileController::class, 'favorite'])->name('profile.favorite');

    Route::post('/details/post', [MediaController::class, 'post'])->name('show.post');
    Route::post('/details/favorite', [MediaController::class, 'favorite'])->name('show.favorite');
    Route::get('/details/{type}/{id}/edit/{review_id?}', [ApiController::class, 'show'])->name('show.edit');
    Route::post('/details/{type}/{id}/edit/{review_id?}', [MediaController::class, 'update'])->name('show.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});