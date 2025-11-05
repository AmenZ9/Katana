<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Publicly accessible routes
Route::get('/', function () {
    return view('welcome');
});

// Routes that require the user to be logged in
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Linked Social Accounts
    Route::get('/my-accounts', [AccountController::class, 'index'])->name('my-accounts.index');

    // Socialite (GitHub) Authentication Routes
    Route::get('/auth/github/redirect', [SocialiteController::class, 'redirect'])->name('auth.github.redirect');
    Route::get('/auth/github/callback', [SocialiteController::class, 'callback'])->name('auth.github.callback');

});

// This file contains the login, register, password reset, etc. routes
require __DIR__.'/auth.php';
