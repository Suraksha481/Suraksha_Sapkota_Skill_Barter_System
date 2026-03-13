@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Premium Membership</h1>
        <p>Unlock enhanced features and take your learning to the next level</p>
    </div>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if($isPremium && $membership)
    <!-- Current Plan -->
    <div class="dashboard-section" style="max-width: 600px; margin-bottom: 2rem;">
        <h2>Your Current Plan</h2>
        <div style="padding: 1.5rem; border: 2px solid #6366f1; border-radius: 12px; background: #f5f3ff;">
            <h3 style="color: #6366f1; margin-bottom: 0.5rem;">{{ ucfirst($membership->plan ?? 'Premium') }} Plan</h3>
            <p><strong>Status:</strong> <span style="color: green;">Active</span></p>
            <p><strong>Expires:</strong> {{ $membership->expires_at ? $membership->expires_at->format('M d, Y') : 'N/A' }}</p>

            <form method="POST" action="{{ route('premium.cancel') }}" style="margin-top: 1rem;">
                @csrf
                <button type="submit" class="btn ghost" onclick="return confirm('Are you sure you want to cancel?')">
                    Cancel Membership
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Plans -->
    <div class="dashboard-section">
        <h2>{{ $isPremium ? 'Upgrade Your Plan' : 'Choose a Plan' }}</h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 1rem;">
            @foreach($plans as $key => $plan)
            <div style="border: 1px solid #ddd; border-radius: 12px; padding: 2rem; text-align: center; {{ $key === 'quarterly' ? 'border-color: #6366f1; box-shadow: 0 4px 12px rgba(99,102,241,0.15);' : '' }}">
                @if(isset($plan['savings']))
                    <span style="background: #6366f1; color: white; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">
                        Save {{ $plan['savings'] }}
                    </span>
                @endif

                <h3 style="margin-top: 1rem; font-size: 1.25rem;">{{ $plan['name'] }}</h3>

                <div style="margin: 1rem 0;">
                    <span style="font-size: 2.5rem; font-weight: 700;">${{ $plan['price'] }}</span>
                    <span style="color: #666;">/{{ $plan['duration'] }}</span>
                </div>

                <ul style="list-style: none; padding: 0; text-align: left; margin-bottom: 1.5rem;">
                    @foreach($plan['features'] as $feature)
                        <li style="padding: 0.4rem 0; color: #444;">&#10003; {{ $feature }}</li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ route('khalti.initiate') }}">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $key }}">
                    <button type="submit" class="btn primary" style="width: 100%; border-radius: 6px; padding: 12px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; background-color: #5C2D91; color: white; border: none; cursor: pointer;">
                        Pay with Khalti
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

</section>

@endsection
