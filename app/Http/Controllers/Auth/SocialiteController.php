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
     */
    public function redirect(): RedirectResponse
    {
        // This should now work correctly.
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub and link the account.
     */
    public function callback(): RedirectResponse
    {
        $localUser = Auth::user();

        if (!$localUser) {
            return redirect()->route('login')->with('error', 'You must be logged in to link an account.');
        }

        try {
            $githubUser = Socialite::driver('github')->user();

            $localUser->linkedAccounts()->updateOrCreate(
                [
                    'provider_name' => 'github',
                    'provider_id'   => $githubUser->getId(),
                ],
                [
                    'name'          => $githubUser->getName(),
                    'nickname'      => $githubUser->getNickname(),
                    'email'         => $githubUser->getEmail(),
                    'avatar'        => $githubUser->getAvatar(),
                    'token'         => $githubUser->token,
                    'refresh_token' => $githubUser->refreshToken,
                    'expires_at'    => property_exists($githubUser, 'expiresIn') ? now()->addSeconds($githubUser->expiresIn) : null,
                ]
            );

            return redirect()->route('my-accounts.index')
                             ->with('status', 'GitHub account linked successfully!');

        } catch (Throwable $e) {
            report($e);
            return redirect()->route('my-accounts.index')
                             ->with('error', 'Failed to link GitHub account. Please try again.');
        }
    }
}
