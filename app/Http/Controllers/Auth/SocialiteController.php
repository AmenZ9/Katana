<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * THIS IS THE MODIFIED FUNCTION FOR DEBUGGING.
     * The try-catch block has been removed to expose the real error.
     *
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        // This line will now throw a visible error page if it fails.
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub and link the account.
     *
     * This function remains unchanged.
     *
     * @return RedirectResponse
     */
    public function callback(): RedirectResponse
    {
        // Get the currently authenticated user from your application.
        $localUser = Auth::user();

        // If for some reason no user is logged in, redirect to login.
        if (!$localUser) {
            return redirect()->route('login')->with('error', 'You must be logged in to link an account.');
        }

        try {
            // Get the user data from GitHub.
            $githubUser = Socialite::driver('github')->user();

            // Use the 'linkedAccounts' relationship to create/update the record.
            $localUser->linkedAccounts()->updateOrCreate(
                [
                    // Find by...
                    'provider_name' => 'github',
                    'provider_id'   => $githubUser->getId(),
                ],
                [
                    // Create or Update with...
                    'name'          => $githubUser->getName(),
                    'nickname'      => $githubUser->getNickname(),
                    'email'         => $githubUser->getEmail(),
                    'avatar'        => $githubUser->getAvatar(),
                    'token'         => $githubUser->token,
                    'refresh_token' => $githubUser->refreshToken,
                    'expires_at'    => property_exists($githubUser, 'expiresIn') ? now()->addSeconds($githubUser->expiresIn) : null,
                ]
            );

            // Redirect back with a success message.
            return redirect()->route('my-accounts.index')
                             ->with('status', 'GitHub account linked successfully!');

        } catch (Throwable $e) {
            // If anything goes wrong during the callback, handle it gracefully.
            report($e);
            return redirect()->route('my-accounts.index')
                             ->with('error', 'Failed to link GitHub account. Please try again.');
        }
    }
}
