<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class OAuthController extends Controller
{
    /**
     * Redirect to the OAuth provider (Google, Apple, etc.)
     */
    public function redirect(string $provider)
    {
        // Validate provider
        if (!in_array($provider, ['google', 'apple'])) {
            return redirect()->route('login')->with('error', 'Invalid OAuth provider.');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle OAuth provider callback
     */
    public function callback(string $provider)
    {
        try {
            // Validate provider
            if (!in_array($provider, ['google', 'apple'])) {
                return redirect()->route('login')->with('error', 'Invalid OAuth provider.');
            }

            $oauthUser = Socialite::driver($provider)->user();

            // Check if email is available
            if (!$oauthUser->getEmail()) {
                return redirect()->route('login')->with('error', 'OAuth provider did not return email. Please try another method.');
            }

            // Find or create user
            $user = User::where('email', $oauthUser->getEmail())->first();

            if ($user) {
                // Update existing user with OAuth details if not already set
                if (!$user->provider) {
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $oauthUser->getId(),
                        'provider_token' => $oauthUser->token,
                        'provider_refresh_token' => $oauthUser->refreshToken ?? null,
                        'oauth_synced_at' => now(),
                    ]);
                }
            } else {
                // Create new user from OAuth
                $user = User::create([
                    'name' => $oauthUser->getName() ?? $oauthUser->getNickname() ?? 'User',
                    'email' => $oauthUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $oauthUser->getId(),
                    'provider_token' => $oauthUser->token,
                    'provider_refresh_token' => $oauthUser->refreshToken ?? null,
                    'password' => bcrypt(Str::random(32)), // Random password for OAuth users
                    'role' => 'user',
                    'oauth_synced_at' => now(),
                ]);

                // Mark email as verified since it comes from OAuth provider
                $user->markEmailAsVerified();
            }

            // Log the user in
            Auth::login($user, remember: true);

            // Mark email as verified if not already
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }

            return redirect()->route('dashboard')->with('status', 'Welcome! You have successfully logged in.');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'OAuth authentication failed. Please try again or use another method.');
        }
    }

    /**
     * Disconnect OAuth provider
     */
    public function disconnect(string $provider)
    {
        $user = Auth::user();

        if ($user && $user->provider === $provider) {
            // Only allow disconnect if user has password (can login without OAuth)
            if (!$user->password) {
                return back()->with('error', 'You must set a password before disconnecting this OAuth provider.');
            }

            $user->update([
                'provider' => null,
                'provider_id' => null,
                'provider_token' => null,
                'provider_refresh_token' => null,
                'oauth_synced_at' => null,
            ]);

            return back()->with('status', 'OAuth provider disconnected successfully.');
        }

        return back()->with('error', 'Unable to disconnect OAuth provider.');
    }
}
