@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Request a Session</h1>
        <p>Send a learning request to {{ $userSkill->user->name ?? 'this user' }}</p>
    </div>

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <!-- Skill Info -->
    <div class="dashboard-section" style="max-width: 600px; background: #fff; padding: 2rem; border-radius: 12px; border: 1px solid #eee; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
        <h2 style="color: #000; margin-bottom: 1rem;">{{ $userSkill->skill->title ?? 'Skill' }}</h2>
        <div style="display: grid; gap: 0.5rem; color: #444;">
            <p style="margin: 0;"><strong>Teacher:</strong> {{ $userSkill->user->name ?? 'Unknown' }}</p>
            <p style="margin: 0;"><strong>Level:</strong> {{ ucfirst($userSkill->level ?? 'N/A') }}</p>
            @if($userSkill->price)
                <p style="margin: 0;"><strong>Price:</strong> <span style="color: #000; font-weight: 700;">${{ number_format($userSkill->price, 2) }}/hr</span></p>
            @endif
        </div>
    </div>

    <!-- Request Form -->
    <div class="skill-form-card" style="max-width: 600px; background: #fff; padding: 2.5rem; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <form method="POST" action="{{ route('requests.store') }}" onsubmit="return confirm('Are you sure you want to request this session?');">
            @csrf
            <input type="hidden" name="user_skill_id" value="{{ $userSkill->id }}">

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="message" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #000;">Message (optional)</label>
                <textarea name="message" id="message" rows="4"
                          placeholder="Tell the teacher what you'd like to learn..."
                          style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; transition: border-color 0.3s ease;">{{ old('message') }}</textarea>
                @error('message')
                    <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="scheduled_at" style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #000;">Preferred Date/Time (optional)</label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at"
                       value="{{ old('scheduled_at') }}"
                       style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;">
                @error('scheduled_at')
                    <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn primary" style="padding: 0.75rem 2.5rem; background: #000; color: #fff; border: 1px solid #000; cursor: pointer; font-weight: 700;">Send Request</button>
                <a href="{{ url()->previous() }}" class="btn ghost" style="padding: 0.75rem 2.5rem; background: #fff; color: #000; border: 1px solid #000; text-decoration: none; display: inline-block; text-align: center; font-weight: 700;">Cancel</a>
            </div>
        </form>
    </div>

</section>

@endsection
