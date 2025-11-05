<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Display the user's accounts page.
     */
public function index(){
    // 1. Get the currently logged-in user
    $user = auth()->user();

    // 2. Load the linked accounts related to this user
    // We use 'latest()' to show the most recently linked account first.
    $linkedAccounts = $user->linkedAccounts()->latest()->get();

    // 3. Pass the data to the view
    return view('my-accounts', [
        'linkedAccounts' => $linkedAccounts,
    ]);
}
}
