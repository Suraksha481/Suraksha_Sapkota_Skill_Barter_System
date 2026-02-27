<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailVerificationCode;
use App\Notifications\VerifyEmailCode;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('auth.register'); // default Blade view
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:teacher,student',
        ]);

        // we no longer persist the user immediately; store pending data in session
        $pending = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        // generate a random verification code and keep it with the pending data
        $code = $this->generateVerificationCode();
        $pending['verification_code'] = $code;
        $pending['expires_at'] = now()->addMinutes(10);

        session(['pending_registration' => $pending]);

        // send code to the address the user supplied; there is no user record yet
        \Illuminate\Support\Facades\Notification::route('mail', $pending['email'])
            ->notify(new VerifyEmailCode($code));

        // ask them to enter the code in order to complete the sign‑up
        return redirect()->route('verify-email-code.show')
            ->with('status', 'Verification code sent! Please check your email.');
    }

    /**
     * Generate a random 6-digit code.
     */
    private function generateVerificationCode(): string
    {
        do {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (EmailVerificationCode::where('code', $code)->where('used', false)->exists());

        return $code;
    }
}
