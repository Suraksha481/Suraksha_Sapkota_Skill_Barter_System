@extends('layouts.app')

@section('content')

<section class="dashboard">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h1>Teaching Analytics</h1>
        <p>Track your teaching performance and student engagement</p>
    </div>

    <!-- KEY METRICS -->
    <div class="analytics-stats">
        <div class="stat-card">
            <h3>{{ $stats['total_students_taught'] }}</h3>
            <p>👥 Students Taught</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['total_sessions_completed'] }}</h3>
            <p>Sessions Completed</p>
        </div>

        <div class="stat-card">
            <h3>⭐ {{ number_format($stats['average_rating'], 1) }}</h3>
            <p>Average Rating</p>
            <small>({{ $stats['rating_count'] }} ratings)</small>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['total_feedback_received'] }}</h3>
            <p>Feedback Received</p>
        </div>
    </div>

    <!-- TOP SKILLS TAUGHT -->
    <div class="analytics-section">
        <h2>Top Skills You Teach</h2>
        <div class="skills-chart">
            @forelse($skillStats as $skill)
                <div class="skill-stat">
                    <div class="skill-name">{{ $skill->first()['skill'] }}</div>
                    <div class="skill-bar">
                        <div class="progress-bar" style="width: {{ ($skill->first()['count'] / $skillStats->sum(fn($s) => $s->first()['count']) * 100) }}%">
                            {{ $skill->first()['count'] }} students
                        </div>
                    </div>
                </div>
            @empty
                <p class="empty">No teaching analytics yet.</p>
            @endforelse
        </div>
    </div>

    <!-- RECENT COMPLETED SESSIONS -->
    <div class="analytics-section">
        <h2>Recent Completed Sessions</h2>
        <div class="sessions-table">
            @forelse($completedSessions->take(10) as $session)
                <div class="session-row">
                    <div>
                        <strong>{{ $session->requester->name }}</strong>
                        <p>Learned: {{ $session->userSkill->skill->title }}</p>
                    </div>
                    <div>
                        <small>{{ $session->completed_at ? $session->completed_at->format('M d, Y') : 'Pending' }}</small>
                    </div>
                </div>
            @empty
                <p class="empty">No completed sessions yet.</p>
            @endforelse
        </div>
    </div>

    <!-- ALL FEEDBACK -->
    <div class="analytics-section">
        <h2>Student Feedback</h2>
        <div class="feedback-list">
            @forelse($allFeedback as $feedback)
                <div class="feedback-item">
                    <div class="feedback-header">
                        <strong>{{ $feedback->author->name }}</strong>
                        <span class="rating">{{ str_repeat('⭐', $feedback->rating ?? 0) }}</span>
                    </div>
                    <p>{{ $feedback->comment }}</p>
                    <small>{{ $feedback->created_at->format('M d, Y') }}</small>
                </div>
            @empty
                <p class="empty">No feedback received yet.</p>
            @endforelse
        </div>
    </div>

</section>

<style>
    .analytics-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .stat-card {
        background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }

    .stat-card h3 {
        margin: 0;
        font-size: 28px;
    }

    .stat-card p {
        margin: 10px 0 0 0;
        font-size: 14px;
    }

    .analytics-section {
        background: white;
        padding: 25px;
        margin: 25px 0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .skills-chart {
        margin-top: 20px;
    }

    .skill-stat {
        margin-bottom: 20px;
    }

    .skill-name {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .skill-bar {
        background: #f0f0f0;
        border-radius: 4px;
        overflow: hidden;
        height: 30px;
    }

    .progress-bar {
        background: linear-gradient(90deg, #1a1a1a 0%, #333333 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        font-size: 12px;
        font-weight: bold;
    }

    .session-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .session-row:last-child {
        border-bottom: none;
    }

    .session-row p {
        margin: 5px 0 0 0;
        color: #666;
        font-size: 13px;
    }

    .feedback-item {
        padding: 15px;
        background: #f9f9f9;
        border-left: 4px solid #1a1a1a;
        margin-bottom: 15px;
        border-radius: 4px;
    }

    .feedback-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .rating {
        color: #ffc107;
        font-weight: bold;
    }

    .empty {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }
</style>

@endsection
