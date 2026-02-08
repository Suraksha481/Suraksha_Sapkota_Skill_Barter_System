<?php

namespace App\Http\Controllers;

use App\Models\PremiumMembership;
use App\Services\GamificationService;
use Illuminate\Http\Request;

class PremiumController extends Controller
{
    protected $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $membership = $user->premiumMembership;
        $isPremium = $user->isPremium();

        $plans = [
            'monthly' => [
                'name' => 'Monthly',
                'price' => 9.99,
                'duration' => '1 month',
                'features' => [
                    'Unlimited skill requests',
                    'Priority matching',
                    'Advanced filters',
                    'Premium badge',
                    'No ads',
                ],
            ],
            'quarterly' => [
                'name' => 'Quarterly',
                'price' => 24.99,
                'duration' => '3 months',
                'savings' => '17%',
                'features' => [
                    'All Monthly features',
                    'Detailed analytics',
                    'Export session history',
                ],
            ],
            'yearly' => [
                'name' => 'Yearly',
                'price' => 79.99,
                'duration' => '12 months',
                'savings' => '33%',
                'features' => [
                    'All Quarterly features',
                    'Early access to new features',
                    'Dedicated support',
                ],
            ],
        ];

        return view('premium.index', compact('user', 'membership', 'isPremium', 'plans'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,quarterly,yearly',
        ]);

        $user = $request->user();
        $plan = $request->plan;

        $durations = [
            'monthly' => 1,
            'quarterly' => 3,
            'yearly' => 12,
        ];

        $existingMembership = $user->premiumMembership;
        
        if ($existingMembership && $existingMembership->status === 'active') {
            $startsAt = $existingMembership->expires_at;
        } else {
            $startsAt = now();
        }

        $expiresAt = $startsAt->copy()->addMonths($durations[$plan]);

        if ($existingMembership) {
            $existingMembership->update([
                'plan' => $plan,
                'started_at' => $startsAt,
                'expires_at' => $expiresAt,
                'status' => 'active',
            ]);
        } else {
            PremiumMembership::create([
                'user_id' => $user->id,
                'plan' => $plan,
                'started_at' => $startsAt,
                'expires_at' => $expiresAt,
                'status' => 'active',
            ]);
        }

        $this->gamificationService->awardBadge($user, 'premium');

        return redirect()->route('premium.index')
            ->with('success', 'Welcome to Premium! Enjoy your enhanced features.');
    }

    public function cancel(Request $request)
    {
        $user = $request->user();
        $membership = $user->premiumMembership;

        if ($membership) {
            $membership->update(['status' => 'cancelled']);
        }

        return redirect()->route('premium.index')
            ->with('success', 'Your premium membership has been cancelled. You can still use premium features until the end of your billing period.');
    }
}
