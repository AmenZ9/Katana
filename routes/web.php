<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // <-- IMPORT THIS
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/', function () {
    return view('welcome');
});

// --- Guest-Only Routes ---
// We keep the login, register, etc. routes here for guests.
Route::middleware('guest')->group(function () {
    // We will require the auth routes file, but we will define logout separately.
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
    Route::delete('/my-accounts/{account}', [AccountController::class, 'destroy'])->name('my-accounts.destroy');

    Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('auth.social.redirect');
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('auth.social.callback');

    // --- EXPLICIT LOGOUT ROUTE FOR AUTHENTICATED USERS ---
    // This route is ONLY accessible to logged-in users.
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
