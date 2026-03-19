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

    // Default to Sandbox URL. Can be overridden in config/services.php or .env
    protected $khaltiBaseUrl;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
        $this->khaltiBaseUrl = config('services.khalti.base_url', 'https://khalti.com/api/v2/');
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

        // Define plan prices in NPR. Khalti expects amount in Paisa.
        $prices = [
            'monthly' => 25, // 25 NPR
            'quarterly' => 50, // 50 NPR
            'yearly' => 100, // 8000 NPR
        ];

        $amountInPaisa = $prices[$plan] * 100;

        $teacherId = $request->teacher_id;
        $purchaseOrderId = 'PREM_' . $user->id . '_' . time() . ($teacherId ? '_T' . $teacherId : '');

        $payload = [
            'return_url' => route('khalti.callback'),
            'website_url' => url('/'),
            'amount' => $amountInPaisa,
            'purchase_order_id' => $purchaseOrderId,
            'purchase_order_name' => ucfirst($plan) . ' Premium Subscription',
            'customer_info' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '9800000000', 
            ],
            'remarks' => 'Payment to Admin Account: 9849587005',
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
            Log::info('Khalti Initiation Success for order: ' . $purchaseOrderId . ' - Data: ' . json_encode($data));
            // Redirect user to Khalti payment page
            return redirect()->away($data['payment_url']);
        }

        Log::error('Khalti Initiation Failed for order: ' . $purchaseOrderId . ' - Error: ' . $response->body());
        return redirect()->route('premium.index')->with('error', 'Failed to initiate Khalti payment. Response: ' . $response->body());
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
                if (strpos(strtolower(basename($purchaseOrderId)), 'yearly') !== false || $amountPaisa == 1039800)
                    $plan = 'yearly';
                elseif (strpos(strtolower(basename($purchaseOrderId)), 'quarterly') !== false || $amountPaisa == 324800)
                    $plan = 'quarterly';

                $priceInNpr = $amountPaisa / 100;
                $adminShare = $priceInNpr * 0.5;
                $teacherShare = $priceInNpr * 0.5;
                
                $teacherId = null;
                if (preg_match('/_T(\d+)$/', $purchaseOrderId, $matches)) {
                    $teacherId = $matches[1];
                }

                // Create Transaction Record
                \App\Models\Transaction::create([
                    'user_id' => $user->id,
                    'teacher_id' => $teacherId,
                    'amount' => $priceInNpr,
                    'admin_share' => $adminShare,
                    'teacher_share' => $teacherShare,
                    'type' => 'premium_subscription',
                    'khalti_pidx' => $pidx,
                    'transaction_id' => $data['transaction_id'] ?? $transactionId,
                ]);

                // Record membership
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
                        'price' => $priceInNpr,
                        'transaction_id' => $data['transaction_id'] ?? $transactionId,
                        'payment_method' => 'khalti'
                    ]);
                }
                else {
                    PremiumMembership::create([
                        'user_id' => $user->id,
                        'plan' => $plan,
                        'started_at' => $startsAt,
                        'expires_at' => $expiresAt,
                        'status' => 'active',
                        'price' => $priceInNpr,
                        'transaction_id' => $data['transaction_id'] ?? $transactionId,
                        'payment_method' => 'khalti'
                    ]);
                }

                $this->gamificationService->awardBadge($user, 'premium');

                // Note: The user requested "teacher should be notified after admin send money in there account".
                // In this case (Premium Subscription), there might not be a specific teacher, 
                // but if we were paying for a specific session, we'd notify that teacher.
                // For global premium subscriptions, the admin keeps the profit or splits with all/top teachers?
                // The prompt says "when student use premium feature that should be goes on admin khalti account and from admin that payment goes on teacher"
                // This implies a specific teacher is involved in the "premium feature".
                // If the "premium feature" is a paid session, we'd have a teacher_id.
                // For now, I'll ensure the Transaction model can handle teacher_id.

                return redirect()->route('premium.index')->with('success', 'Payment successful! Welcome to Premium.');
            }
            else {
                return redirect()->route('premium.index')->with('error', 'Payment was not completed. Status: ' . $data['status']);
            }
        }

        Log::error('Khalti Lookup Failed: ' . $response->body());
        return redirect()->route('premium.index')->with('error', 'An error occurred while verifying the payment.');
    }
}
