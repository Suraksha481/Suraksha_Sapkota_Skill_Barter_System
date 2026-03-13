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
            'bank_account' => 'required_if:role,teacher|nullable|string|max:255',
            'cv' => 'required_if:role,teacher|nullable|file|mimes:pdf,doc,docx|max:5120',
            'certificate' => 'required_if:role,teacher|nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'citizenship' => 'required_if:role,teacher|nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // we no longer persist the user immediately; store pending data in session
        $pending = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        if ($request->role === 'teacher') {
            $pending['bank_account'] = $request->bank_account;
            if ($request->hasFile('cv')) {
                $pending['cv_path'] = $request->file('cv')->store('pending_documents', 'public');
            }
            if ($request->hasFile('certificate')) {
                $pending['certificate_path'] = $request->file('certificate')->store('pending_documents', 'public');
            }
            if ($request->hasFile('citizenship')) {
                $pending['citizenship_path'] = $request->file('citizenship')->store('pending_documents', 'public');
            }
        }

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

            // the table may not exist yet if migrations haven't been run;
            // skip uniqueness check in that case so registration still works
            $duplicate = false;
            if (\Illuminate\Support\Facades\Schema::hasTable('email_verification_codes')) {
                $duplicate = EmailVerificationCode::where('code', $code)
                                ->where('used', false)
                                ->exists();
            }
        } while ($duplicate);

        return $code;
    }
}
