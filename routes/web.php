<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- Public Routes ---
Route::get('/', function () {
    return view('welcome');
});

// --- Authenticated Routes ---
// The 'verified' middleware has been REMOVED from the group definition.
// Now, these routes only require the user to be logged in ('auth').
Route::middleware('auth')->group(function () {
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
});

// --- Guest-Only Routes ---
// This file contains routes for login, registration, password reset, etc.
// It is included at the end to ensure authenticated routes are prioritized.
require __DIR__.'/auth.php';
