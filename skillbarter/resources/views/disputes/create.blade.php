@extends('app')

@section('content')
<section class="dashboard" style="max-width: 700px; margin: 0 auto; padding: 60px 20px;">

    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 2rem; font-weight: 900; color: var(--text-slate); margin-bottom: 8px;">Report an Issue</h1>
        <p style="color: #64748b;">Something went wrong with your session? Let us know and our admin team will investigate.</p>
    </div>

    <div style="background: white; border-radius: 20px; padding: 40px; border: 1px solid var(--primary-teal-light); box-shadow: 0 10px 40px rgba(0,0,0,0.03);">

        <div style="background: var(--bg-light-teal); border-radius: 12px; padding: 16px 20px; margin-bottom: 28px; border-left: 4px solid var(--primary-teal);">
            <strong style="color: var(--primary-teal-dark);">Session with:</strong>
            <span style="color: var(--text-slate); margin-left: 8px;">{{ $sessionRequest->responder->name ?? 'Unknown Teacher' }}</span>
        </div>

        @if ($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; color: #dc2626; font-weight: 600;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('disputes.store', $sessionRequest->id) }}">
            @csrf
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; color: var(--text-slate); margin-bottom: 10px; font-size: 0.95rem;">
                    Describe the problem
                </label>
                <textarea
                    name="reason"
                    rows="6"
                    required
                    placeholder="E.g. The teacher never showed up to the scheduled session. I waited for 30 minutes..."
                    style="width: 100%; padding: 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-family: inherit; font-size: 1rem; resize: vertical; outline: none; transition: border 0.3s; box-sizing: border-box;"
                    onfocus="this.style.borderColor='var(--primary-teal)'"
                    onblur="this.style.borderColor='#e2e8f0'"
                >{{ old('reason') }}</textarea>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit"
                    style="background: var(--primary-teal); color: white; border: none; padding: 14px 32px; border-radius: 50px; font-weight: 800; font-size: 0.95rem; cursor: pointer; letter-spacing: 0.5px; transition: background 0.3s;">
                    Submit Dispute
                </button>
                <a href="{{ route('requests.index') }}"
                    style="display: inline-flex; align-items: center; padding: 14px 28px; border-radius: 50px; border: 2px solid #e2e8f0; color: #64748b; font-weight: 700; text-decoration: none; transition: border-color 0.3s;">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</section>
@endsection
