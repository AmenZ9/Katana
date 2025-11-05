<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/', function () {
    return view('welcome');
});

// --- Guest-Only Routes ---
Route::middleware('guest')->group(function () {
    require __DIR__.'/auth.php';
});

// --- Authenticated Routes ---
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-accounts', [AccountController::class, 'index'])->name('my-accounts.index');

    Route::get('/auth/github/redirect', [SocialiteController::class, 'redirect'])->name('auth.github.redirect');
    Route::get('/auth/github/callback', [SocialiteController::class, 'callback'])->name('auth.github.callback');
});
