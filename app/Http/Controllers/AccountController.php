<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Display the user's linked accounts.
     */
    public function index(): View
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Eager load the linked accounts to prevent multiple database queries
        $user->load('linkedAccounts');

        // Pass the user object to the correct view
        // The view is 'my-accounts', not 'my-accounts.index'
        return view('my-accounts', [
            'user' => $user,
        ]);
    }
}
