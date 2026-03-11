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
    <div class="dashboard-section" style="max-width: 600px;">
        <h2>{{ $userSkill->skill->title ?? 'Skill' }}</h2>
        <p><strong>Teacher:</strong> {{ $userSkill->user->name ?? 'Unknown' }}</p>
        <p><strong>Level:</strong> {{ ucfirst($userSkill->level ?? 'N/A') }}</p>
        @if($userSkill->price)
            <p><strong>Price:</strong> ${{ number_format($userSkill->price, 2) }}/hr</p>
        @endif
    </div>

    <!-- Request Form -->
    <div class="skill-form-card" style="max-width: 600px;">
        <form method="POST" action="{{ route('requests.store') }}" onsubmit="return confirm('Are you sure you want to request this session?');">
            @csrf
            <input type="hidden" name="user_skill_id" value="{{ $userSkill->id }}">

            <div class="form-group">
                <label for="message">Message (optional)</label>
                <textarea name="message" id="message" rows="4"
                          placeholder="Tell the teacher what you'd like to learn..."
                          style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 8px;">{{ old('message') }}</textarea>
                @error('message')
                    <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="scheduled_at">Preferred Date/Time (optional)</label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at"
                       value="{{ old('scheduled_at') }}"
                       style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 8px;">
                @error('scheduled_at')
                    <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn primary">Send Request</button>
                <a href="{{ url()->previous() }}" class="btn ghost">Cancel</a>
            </div>
        </form>
    </div>

</section>

@endsection
