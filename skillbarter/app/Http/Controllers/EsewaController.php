<?php
namespace App\Http\Controllers;

use App\Models\PremiumMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EsewaController extends Controller
{
    // Show a simple payment form that posts to eSewa
    public function initiate(Request $request)
    {
        $request->validate(['plan' => 'required|in:monthly,quarterly,yearly']);

        $plans = [
            'monthly' => 9.99,
            'quarterly' => 24.99,
            'yearly' => 79.99,
        ];

        $plan = $request->plan;
        $amount = $plans[$plan];

        // eSewa parameters - merchant code (scd) should be in .env
        $esewa = [
            'tAmt' => $amount, // total amount
            'amt' => $amount,
            'psc' => 0,
            'pdc' => 0,
            'pid' => uniqid('esewa_'),
            'scd' => config('services.esewa.merchant_code', env('ESEWA_MERCHANT_CODE')),
            'success_url' => route('esewa.callback'),
            'failure_url' => route('esewa.failure'),
        ];

        // Render a small form that auto-submits to eSewa
        return view('payments.esewa_redirect', compact('esewa','plan'));
    }

    // eSewa will call back to this route (or user returns here). Verify payment.
    public function callback(Request $request)
    {
        // eSewa typically returns query params including 'oid' or 'pid' and 'amt'
        $pid = $request->get('pid') ?? $request->get('oid') ?? $request->get('refId');
        $amt = $request->get('amt');

        // If an official verification URL is set, call it
        $verifyUrl = config('services.esewa.verify_url', env('ESEWA_VERIFY_URL'));

        if ($verifyUrl) {
            try {
                $resp = Http::asForm()->post($verifyUrl, [
                    'pid' => $pid,
                    'amt' => $amt,
                    'scd' => config('services.esewa.merchant_code', env('ESEWA_MERCHANT_CODE')),
                ]);

                if ($resp->ok() && strpos($resp->body(), 'Success') !== false) {
                    // Mark premium in DB - this is application-specific
                    // Create membership for current user if logged in
                    if ($request->user()) {
                        PremiumMembership::create([
                            'user_id' => $request->user()->id,
                            'plan' => 'monthly',
                            'started_at' => now(),
                            'expires_at' => now()->addMonth(),
                            'status' => 'active',
                            'price' => $amt,
                            'currency' => 'NPR',
                        ]);
                    }

                    return redirect()->route('premium.index')->with('success', 'Payment verified and membership activated.');
                }
            } catch (\Exception $e) {
                return redirect()->route('premium.index')->with('error', 'Verification failed: ' . $e->getMessage());
            }
        }

        // If no external verification endpoint is configured, just show a message
        return redirect()->route('premium.index')->with('info', 'Payment callback received. Configure ESEWA verification to auto-activate membership.');
    }

    public function failure(Request $request)
    {
        return redirect()->route('premium.index')->with('error', 'Payment failed or cancelled.');
    }
}
