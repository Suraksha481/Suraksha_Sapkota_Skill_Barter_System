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
        // if we're in the middle of a pending registration we don't have a user yet
        $pending = session('pending_registration');
        $user = null;

        if ($pending) {
            // create a dummy user object just so the view can display the email
            $user = new User();
            $user->email = $pending['email'];
        } else {
            $userId = $request->query('user_id');
            if (!$userId) {
                return redirect()->route('login')->with('error', 'Invalid verification request.');
            }
            $user = User::find($userId);
            if (!$user) {
                return redirect()->route('login')->with('error', 'User not found.');
            }
        }

        return view('auth.verify-email-code', ['user' => $user]);
    }

    /**
     * Verify the email code and mark email as verified.
     */
    public function verify(Request $request)
    {
        // if we have pending registration details, handle them first
        $pending = session('pending_registration');
        if ($pending) {
            $request->validate([
                'code' => 'required|string|size:6',
            ]);

            if ($request->code !== $pending['verification_code'] || now()->gt($pending['expires_at'])) {
                return back()->withErrors(['code' => 'The verification code is invalid or has expired.']);
            }

            // create user record now
            $user = User::create([
                'name' => $pending['name'],
                'email' => $pending['email'],
                'password' => $pending['password'],
                'role' => $pending['role'],
            ]);

            if ($user->role === 'teacher') {
                \App\Models\TeacherProfile::firstOrCreate(['user_id' => $user->id]);
            } else {
                \App\Models\StudentProfile::firstOrCreate(['user_id' => $user->id]);
            }

            $user->markEmailAsVerified();

            session()->forget('pending_registration');

            return redirect()->route('login')->with('success', 'Registration complete. You may now login.');
        }

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

        // if the new account is a teacher, let them know approval is pending
        if ($user->role === 'teacher') {
            $user->notify(new \App\Notifications\TeacherPendingApproval());
        }

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
