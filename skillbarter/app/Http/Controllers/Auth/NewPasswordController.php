<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Verify the token exists and is valid
        $tokenRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->latest('created_at')
            ->first();

        if (!$tokenRecord) {
            return back()->withErrors(['email' => 'This password reset token is invalid or has expired.']);
        }

        // The stored token is hashed by the password broker, so use Hash::check
        if (!Hash::check($request->token, $tokenRecord->token)) {
            return back()->withErrors(['email' => 'This password reset token is invalid or has expired.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the used token
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Fire the password reset event
        event(new PasswordReset($user));

        return redirect()->route('login')->with('status', 'Your password has been reset successfully. Please log in with your new password.');
    }
}
