<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LinkedAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialiteController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        // We keep the stateless mode as it proved to be the most reliable solution
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        $localUser = Auth::user();
        if (!$localUser) {
            return redirect()->route('login')->with('error', 'You must be logged in to link an account.');
        }

        try {
            $providerUser = Socialite::driver($provider)->stateless()->user();

            // Security Check: Is this social account already linked to a DIFFERENT user?
            $existingAccount = LinkedAccount::where('provider_name', $provider)
                                            ->where('provider_id', $providerUser->getId())
                                            ->first();

            if ($existingAccount && $existingAccount->user_id !== $localUser->id) {
                return redirect()->route('my-accounts.index')
                                 ->with('error', 'This ' . ucfirst($provider) . ' account is already linked to another user.');
            }

            // Create or update the linked account for the CURRENT logged-in user.
            // The 'created' or 'updated' event will be logged automatically by the model's trait.
            $linkedAccount = $localUser->linkedAccounts()->updateOrCreate(
                [
                    'provider_name' => $provider,
                    'provider_id'   => $providerUser->getId(),
                ],
                [
                    'name'          => $providerUser->getName(),
                    'nickname'      => $providerUser->getNickname(),
                    'email'         => $providerUser->getEmail(),
                    'avatar'        => $providerUser->getAvatar(),
                    'token'         => $providerUser->token,
                    'refresh_token' => $providerUser->refreshToken,
                    'expires_at'    => property_exists($providerUser, 'expiresIn') ? now()->addSeconds($providerUser->expiresIn) : null,
                ]
            );

            // --- THIS IS THE NEW ADDITION ---
            // Log a custom, more descriptive event.
            activity()
                ->causedBy($localUser) // The user who performed the action
                ->on($linkedAccount)   // The model that was affected
                ->withProperty('provider', $provider) // Add extra context
                ->log('User linked a social account'); // The description of the action

            return redirect()->route('my-accounts.index')
                             ->with('status', ucfirst($provider) . ' account linked successfully!');

        } catch (Throwable $e) {
            report($e);
            return redirect()->route('my-accounts.index')
                             ->with('error', 'Failed to link ' . ucfirst($provider) . ' account. Please try again.');
        }
    }
}
