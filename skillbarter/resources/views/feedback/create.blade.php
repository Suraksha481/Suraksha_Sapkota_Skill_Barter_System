@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Leave Feedback</h1>
        @if($targetUser)
            <p>Rate your experience with {{ $targetUser->name }}</p>
        @else
            <p>Share your feedback</p>
        @endif
    </div>

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if($sessionRequest)
    <div class="dashboard-section" style="max-width: 600px;">
        <h2>Session Details</h2>
        <p><strong>Skill:</strong> {{ $sessionRequest->userSkill->skill->title ?? 'N/A' }}</p>
        <p><strong>With:</strong> {{ $targetUser->name ?? 'N/A' }}</p>
    </div>
    @endif

    <div class="skill-form-card" style="max-width: 600px;">
        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf

            <input type="hidden" name="target_type" value="user">
            <input type="hidden" name="target_id" value="{{ $targetUser->id ?? '' }}">

            <div class="form-group">
                <label>Rating</label>
                <div style="display: flex; gap: 0.5rem; font-size: 2rem; cursor: pointer;" id="star-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <label style="cursor: pointer;">
                            <input type="radio" name="rating" value="{{ $i }}" style="display: none;" {{ old('rating') == $i ? 'checked' : '' }}>
                            <span class="star" data-value="{{ $i }}" style="color: {{ old('rating', 0) >= $i ? '#f59e0b' : '#d1d5db' }};">&#9733;</span>
                        </label>
                    @endfor
                </div>
                @error('rating')
                    <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="comment">Comment (optional)</label>
                <textarea name="comment" id="comment" rows="4"
                          placeholder="Share your experience..."
                          style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 8px;">{{ old('comment') }}</textarea>
                @error('comment')
                    <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn primary">Submit Feedback</button>
                <a href="{{ route('dashboard') }}" class="btn ghost">Cancel</a>
            </div>
        </form>
    </div>

</section>

<script>
document.querySelectorAll('#star-rating .star').forEach(function(star) {
    star.addEventListener('click', function() {
        var value = this.getAttribute('data-value');
        this.parentElement.querySelector('input').checked = true;
        document.querySelectorAll('#star-rating .star').forEach(function(s) {
            s.style.color = parseInt(s.getAttribute('data-value')) <= parseInt(value) ? '#f59e0b' : '#d1d5db';
        });
    });
});
</script>

@endsection
