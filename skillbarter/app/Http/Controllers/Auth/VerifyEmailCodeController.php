<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerificationCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifyEmailCodeController extends Controller
{
    /**
     * Show the email verification code form.
     */
    public function show(Request $request): View
    {
        // Get the user ID from session or query parameter
        $userId = $request->query('user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Invalid verification request.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        return view('auth.verify-email-code', ['user' => $user]);
    }

    /**
     * Verify the email code and mark email as verified.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|string|size:6',
        ]);

        $user = User::find($request->user_id);

        // Get valid code for user
        $verificationCode = EmailVerificationCode::where('user_id', $user->id)
            ->where('code', $request->code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verificationCode) {
            return back()->withErrors(['code' => 'The verification code is invalid or has expired.']);
        }

        // Mark email as verified
        $user->markEmailAsVerified();

        // Mark code as used
        $verificationCode->markAsUsed();

        return redirect()->route('login')->with('success', 'Email verified successfully! You can now login.');
    }

    /**
     * Resend verification code.
     */
    public function resend(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        // Mark old codes as expired or invalid
        EmailVerificationCode::where('user_id', $user->id)
            ->where('used', false)
            ->update(['used' => true]);

        // Generate new code
        $code = $this->generateVerificationCode();

        // Create new verification code record
        EmailVerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send email with new code
        $user->notify(new \App\Notifications\VerifyEmailCode($code));

        return back()->with('success', 'A new verification code has been sent to your email.');
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
