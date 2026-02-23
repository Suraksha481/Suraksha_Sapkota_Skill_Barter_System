<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    protected $providers = ['google', 'apple'];

    public function redirect(Request $request, $provider)
    {
        if (! in_array($provider, $this->providers)) {
            abort(404);
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback(Request $request, $provider)
    {
        if (! in_array($provider, $this->providers)) {
            abort(404);
        }

        try {
            $social = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'OAuth failed: ' . $e->getMessage());
        }

        // Find or create user
        $user = User::where('provider', $provider)
                    ->where('provider_id', $social->getId())
                    ->first();

        if (! $user && $social->getEmail()) {
            $user = User::where('email', $social->getEmail())->first();
        }

        if (! $user) {
            $user = User::create([
                'name' => $social->getName() ?? $social->getNickname() ?? 'User',
                'email' => $social->getEmail(),
                'provider' => $provider,
                'provider_id' => $social->getId(),
                'provider_token' => $social->token ?? null,
                'password' => null,
                'email_verified_at' => $social->getEmail() ? now() : null,
            ]);
        } else {
            // update provider tokens and ids
            $user->update([
                'provider' => $provider,
                'provider_id' => $social->getId(),
                'provider_token' => $social->token ?? $user->provider_token,
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }

    public function disconnect(Request $request, $provider)
    {
        $user = $request->user();
        if (! $user) abort(403);

        if ($user->provider === $provider) {
            $user->update(['provider' => null, 'provider_id' => null, 'provider_token' => null]);
        }

        return redirect()->back()->with('success', 'Disconnected ' . ucfirst($provider));
    }
}
