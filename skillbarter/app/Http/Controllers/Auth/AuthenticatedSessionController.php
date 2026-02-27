<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required','email'],
        'password' => ['required'],
    ]);

    // look up user so we can enforce verification before even attempting auth
    $user = \\App\\Models\\User::where('email', $request->email)->first();
    if ($user && ! $user->hasVerifiedEmail()) {
        return back()->withErrors([
            'email' => 'Please verify your email address before logging in.',
        ]);
    }

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    $request->session()->regenerate();

    $request->session()->regenerate();



    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // non-admin users should land on the public home page after login
    // the old behaviour sent teachers/students straight to their dashboards,
    // which could create a redirect loop if a teacher wasn’t yet approved.
    return redirect()->intended(RouteServiceProvider::HOME);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // redirect to home page after logout
    }
}
