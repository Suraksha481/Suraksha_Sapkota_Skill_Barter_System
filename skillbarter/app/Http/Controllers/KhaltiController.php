<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PremiumMembership;
use App\Services\GamificationService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KhaltiController extends Controller
{
    protected $gamificationService;
    
    // Using Khalti Sandbox endpoint by default. For production, change to: https://khalti.com/api/v2/
    protected $khaltiBaseUrl = 'https://a.khalti.com/api/v2/';

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Initiate the Khalti payment process.
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,quarterly,yearly',
        ]);

        $user = $request->user();
        $plan = $request->plan;

        // Define plan prices in USD/NPR equivalent. Khalti expects amount in Paisa (cents).
        // 1 NPR = 100 Paisa. Assuming these prices are in USD and roughly converting 1 USD = 130 NPR for demo.
        // E.g., $9.99 * 130 = ~1298 NPR -> 129800 Paisa.
        $prices = [
            'monthly' => 1298,
            'quarterly' => 3248,
            'yearly' => 10398,
        ];

        $amountInPaisa = $prices[$plan] * 100;
        $purchaseOrderId = 'PREM_' . $user->id . '_' . time();

        $payload = [
            'return_url' => route('khalti.callback'),
            'website_url' => url('/'),
            'amount' => $amountInPaisa,
            'purchase_order_id' => $purchaseOrderId,
            'purchase_order_name' => ucfirst($plan) . ' Premium Subscription',
            'customer_info' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => '9800000000', // Mock data, usually from user profile
            ],
            // Pass the selected plan along so we can use it on the callback
            'amount_breakdown' => [
                [
                    'label' => 'Subscription Fee',
                    'amount' => $amountInPaisa
                ]
            ],
            'product_details' => [
                [
                    'identity' => $plan, // storing the plan type here as identity to retrieve later
                    'name' => ucfirst($plan) . ' Premium',
                    'total_price' => $amountInPaisa,
                    'quantity' => 1,
                    'unit_price' => $amountInPaisa
                ]
            ]
        ];

        // Send Request to Khalti EPAY Endpoint
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . config('services.khalti.secret_key'),
            'Content-Type' => 'application/json',
        ])->post($this->khaltiBaseUrl . 'epayment/initiate/', $payload);

        if ($response->successful()) {
            $data = $response->json();
            // Redirect user to Khalti payment page
            return redirect()->away($data['payment_url']);
        }

        Log::error('Khalti Initiate Failed: ' . $response->body());
        return redirect()->route('premium.index')->with('error', 'Failed to initiate Khalti payment. Please try again.');
    }

    /**
     * Handle the callback from Khalti after payment.
     */
    public function callback(Request $request)
    {
        $pidx = $request->query('pidx');
        $transactionId = $request->query('transaction_id');
        $amountPaisa = $request->query('amount');
        $purchaseOrderId = $request->query('purchase_order_id');

        if (!$pidx) {
            return redirect()->route('premium.index')->with('error', 'Invalid payment response.');
        }

        // Verify the payment with Khalti
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . config('services.khalti.secret_key'),
            'Content-Type' => 'application/json',
        ])->post($this->khaltiBaseUrl . 'epayment/lookup/', [
            'pidx' => $pidx
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if ($data['status'] === 'Completed') {
                $user = $request->user();
                
                // We extract the plan name either from the custom purchase order ID, or product details. 
                // In our initiate method, we prefixed purchase_order_name with the plan. 
                // As a fallback, assuming it's monthly if we can't parse it precisely.
                $plan = 'monthly';
                if(strpos(strtolower(basename($purchaseOrderId)), 'yearly') !== false || $amountPaisa == 1039800) $plan = 'yearly';
                elseif(strpos(strtolower(basename($purchaseOrderId)), 'quarterly') !== false || $amountPaisa == 324800) $plan = 'quarterly';

                $priceInDollars = match($plan) {
                    'monthly' => 9.99,
                    'quarterly' => 24.99,
                    'yearly' => 79.99,
                    default => 9.99
                };

                $durations = [
                    'monthly' => 1,
                    'quarterly' => 3,
                    'yearly' => 12,
                ];

                $existingMembership = $user->premiumMembership;
                
                $startsAt = now();
                if ($existingMembership && $existingMembership->status === 'active') {
                    $startsAt = $existingMembership->expires_at;
                }

                $expiresAt = $startsAt->copy()->addMonths($durations[$plan]);

                if ($existingMembership) {
                    $existingMembership->update([
                        'plan' => $plan,
                        'started_at' => $startsAt,
                        'expires_at' => $expiresAt,
                        'status' => 'active',
                        'price' => $priceInDollars,
                        'transaction_id' => $data['transaction_id'] ?? $transactionId,
                        'payment_method' => 'khalti'
                    ]);
                } else {
                    PremiumMembership::create([
                        'user_id' => $user->id,
                        'plan' => $plan,
                        'started_at' => $startsAt,
                        'expires_at' => $expiresAt,
                        'status' => 'active',
                        'price' => $priceInDollars,
                        'transaction_id' => $data['transaction_id'] ?? $transactionId,
                        'payment_method' => 'khalti'
                    ]);
                }

                $this->gamificationService->awardBadge($user, 'premium');

                return redirect()->route('premium.index')->with('success', 'Payment successful! Welcome to Premium.');
            } else {
                return redirect()->route('premium.index')->with('error', 'Payment was not completed. Status: ' . $data['status']);
            }
        }

        Log::error('Khalti Lookup Failed: ' . $response->body());
        return redirect()->route('premium.index')->with('error', 'An error occurred while verifying the payment.');
    }
}
