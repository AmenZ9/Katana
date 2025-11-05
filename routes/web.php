<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

require __DIR__.'/auth.php';
use App\Http\Controllers\AccountController;

Route::get('/my-accounts', [AccountController::class, 'index'])->middleware(['auth'])->name('my-accounts');

use App\Http\Controllers\Auth\SocialiteController;

// ... (other routes) ...

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    // The existing profile routes are already here
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // The existing "My Accounts" route
    Route::get('/my-accounts', [AccountController::class, 'index'])->name('my-accounts.index'); // Corrected the name here

    // --- ADD THE SOCIALITE ROUTES INSIDE THIS GROUP ---
    Route::get('/auth/github/redirect', [SocialiteController::class, 'redirect'])->name('auth.github.redirect');
    Route::get('/auth/github/callback', [SocialiteController::class, 'callback'])->name('auth.github.callback');
});
