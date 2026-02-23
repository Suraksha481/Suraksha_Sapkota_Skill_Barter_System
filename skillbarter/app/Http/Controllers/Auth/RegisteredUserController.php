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

        // Create the user with single role (mutually exclusive)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create profile based on selected role
        if ($request->role === 'teacher') {
            \App\Models\TeacherProfile::firstOrCreate(['user_id' => $user->id]);
        } else {
            \App\Models\StudentProfile::firstOrCreate(['user_id' => $user->id]);
        }

        // Generate verification code
        $code = $this->generateVerificationCode();

        // Create verification code record
        EmailVerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send verification code email
        $user->notify(new VerifyEmailCode($code));

        // Redirect to verification code input page
        return redirect()->route('verify-email-code.show', ['user_id' => $user->id])
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
