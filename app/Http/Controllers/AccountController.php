<?php

namespace App\Http\Controllers;

use App\Models\LinkedAccount; // Make sure this is imported
use Illuminate\Http\RedirectResponse;
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
        // Eager load the linked accounts for the currently authenticated user
        $user = Auth::user()->load('linkedAccounts');

        // Pass the user's linked accounts collection directly to the view
        // The view expects a variable named $linkedAccounts
        return view('my-accounts', [
            'linkedAccounts' => $user->linkedAccounts,
        ]);
    }

    /**
     * Unlink (delete) a social account.
     */
    public function destroy(LinkedAccount $account): RedirectResponse
    {
        // Security Check: Make sure the logged-in user owns this account
        // If not, stop the process with a "403 Forbidden" error.
        if ($account->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to perform this action.');
        }

        // If the check passes, delete the account
        $account->delete();

        // Redirect back to the accounts page with a success message
        return redirect()->route('my-accounts.index')
            ->with('status', 'Account unlinked successfully!');
    }
}
