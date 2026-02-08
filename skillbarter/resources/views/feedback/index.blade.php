@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Feedback</h1>
        <p>View feedback you've received and given</p>
    </div>

    <!-- Stats -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>{{ $averageRating ? number_format($averageRating, 1) : 'N/A' }}</h3>
            <p>Average Rating</p>
        </div>
        <div class="stat-card">
            <h3>{{ $totalReviews }}</h3>
            <p>Total Reviews</p>
        </div>
    </div>

    <!-- Received Feedback -->
    <div class="dashboard-section">
        <h2>Feedback Received</h2>
        <ul>
            @forelse($receivedFeedback as $feedback)
                <li style="padding: 1rem; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color: {{ $i <= $feedback->rating ? '#f59e0b' : '#d1d5db' }};">&#9733;</span>
                        @endfor
                        <span style="color: #666; font-size: 0.85rem;">
                            by {{ $feedback->author->name ?? 'Anonymous' }}
                        </span>
                    </div>
                    @if($feedback->comment)
                        <p>{{ $feedback->comment }}</p>
                    @endif
                    <small style="color: #999;">{{ $feedback->created_at->diffForHumans() }}</small>
                </li>
            @empty
                <li class="empty">No feedback received yet.</li>
            @endforelse
        </ul>
    </div>

    <!-- Given Feedback -->
    <div class="dashboard-section">
        <h2>Feedback Given</h2>
        <ul>
            @forelse($givenFeedback as $feedback)
                <li style="padding: 1rem; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color: {{ $i <= $feedback->rating ? '#f59e0b' : '#d1d5db' }};">&#9733;</span>
                        @endfor
                    </div>
                    @if($feedback->comment)
                        <p>{{ $feedback->comment }}</p>
                    @endif
                    <small style="color: #999;">{{ $feedback->created_at->diffForHumans() }}</small>
                </li>
            @empty
                <li class="empty">You haven't given any feedback yet.</li>
            @endforelse
        </ul>
    </div>

</section>

@endsection
