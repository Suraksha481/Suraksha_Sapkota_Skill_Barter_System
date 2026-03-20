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

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if($isPremium && $membership)
    <!-- Current Plan -->
    <div class="dashboard-section" style="max-width: 600px; margin-bottom: 2rem;">
        <h2>Your Current Plan</h2>
        <div style="padding: 1.5rem; border: 2px solid var(--primary-teal); border-radius: 12px; background: var(--bg-light-teal);">
            <h3 style="color: var(--primary-teal); margin-bottom: 0.5rem;">{{ ucfirst($membership->plan ?? 'Premium') }} Plan</h3>
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
            <div style="border: 2px solid {{ ($isPremium && $membership && $membership->plan === $key) ? 'var(--primary-teal)' : '#ddd' }}; border-radius: 16px; padding: 2.5rem; text-align: center; position: relative; {{ $key === 'quarterly' && !($isPremium && $membership && $membership->plan === $key) ? 'box-shadow: 0 10px 30px rgba(32, 166, 138, 0.15); border-color: var(--primary-teal-light);' : '' }} background: white; transition: all 0.3s ease;">
                @if(isset($plan['savings']))
                    <span style="background: var(--primary-teal); color: white; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700;">
                        Save {{ $plan['savings'] }}
                    </span>
                @endif

                @if($isPremium && $membership && $membership->plan === $key)
                    <span style="position: absolute; top: 1rem; right: 1rem; background: var(--bg-light-teal); color: var(--primary-teal); padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 800; border: 1px solid var(--primary-teal);">
                        CURRENT
                    </span>
                @endif

                <h3 style="margin-top: 1rem; font-size: 1.25rem;">{{ $plan['name'] }}</h3>

                <div style="margin: 1rem 0;">
                    <span style="font-size: 2.5rem; font-weight: 700;">NPR {{ number_format($plan['price']) }}</span>
                    <span style="color: #666;">/{{ $plan['duration'] }}</span>
                </div>

                <ul style="list-style: none; padding: 0; text-align: left; margin-bottom: 1.5rem;">
                    @foreach($plan['features'] as $feature)
                        <li style="padding: 0.4rem 0; color: #444;">&#10003; {{ $feature }}</li>
                    @endforeach
                </ul>

                @if($isPremium && $membership && $membership->plan === $key)
                    <button disabled style="width: 100%; border-radius: 6px; padding: 12px; font-weight: 600; background-color: #f3f4f6; color: #9ca3af; border: 1px solid #d1d5db; cursor: not-allowed;">
                        Your current plan
                    </button>
                @else
                    <form method="POST" action="{{ route('khalti.initiate') }}">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $key }}">
                        @if(isset($teacher_id))
                            <input type="hidden" name="teacher_id" value="{{ $teacher_id }}">
                        @endif
                        <button type="submit" class="btn-pill primary" style="width: 100%; border: none; padding: 14px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 16px; cursor:pointer;">
                             Pay with Khalti
                        </button>
                    </form>
                @endif
            </div>
            @endforeach
        </div>
    </div>

</section>

@endsection
