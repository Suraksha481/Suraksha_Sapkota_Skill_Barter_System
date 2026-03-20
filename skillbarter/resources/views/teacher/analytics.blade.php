@extends('app')

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
            <p>Students Taught</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['total_sessions_completed'] }}</h3>
            <p>Sessions Completed</p>
        </div>

        <div class="stat-card">
            <h3>{{ number_format($stats['average_rating'], 1) }}</h3>
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
            @forelse($skillStats as $index => $skill)
                <div class="skill-stat-card">
                    <div class="skill-rank">#{{ $index + 1 }}</div>
                    <div class="skill-info">
                        <span class="skill-name">{{ $skill['skill'] }}</span>
                        <span class="skill-students">Total Students Enrolled</span>
                    </div>
                    <div class="skill-count-badge">
                        {{ $skill['count'] }}
                    </div>
                </div>
            @empty
                <div class="empty">No skills taught yet.</div>
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
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 25px;
        margin: 40px 0;
    }

    .stat-card {
        background: #fff;
        padding: 25px;
        border-radius: 16px;
        text-align: left;
        border: 1px solid var(--primary-teal-light);
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        transition: transform 0.3s ease, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-teal), var(--primary-teal-dark));
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(32, 166, 138, 0.1);
    }

    .stat-card h3 {
        margin: 0 0 5px 0;
        font-size: 32px;
        font-weight: 800;
        color: var(--text-slate);
    }

    .stat-card p {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card small {
        display: block;
        margin-top: 5px;
        color: #94a3b8;
        font-size: 12px;
    }

    .analytics-section {
        background: white;
        padding: 30px;
        margin: 30px 0;
        border-radius: 16px;
        border: 1px solid var(--primary-teal-light);
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    .analytics-section h2 {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--text-slate);
        margin-bottom: 25px;
        border-bottom: 2px solid var(--primary-teal-light);
        padding-bottom: 12px;
    }

    .skills-chart {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 25px;
    }

    .skill-stat-card {
        display: flex;
        align-items: center;
        padding: 20px 25px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--primary-teal);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(32, 166, 138, 0.05);
    }

    .skill-stat-card:hover {
        box-shadow: 0 8px 25px rgba(32, 166, 138, 0.15);
    }

    .skill-rank {
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--primary-teal);
        margin-right: 20px;
        min-width: 40px;
        text-align: center;
    }

    .skill-info {
        flex: 1;
    }

    .skill-name {
        font-weight: 800;
        color: var(--text-slate);
        font-size: 1.1rem;
        margin-bottom: 4px;
        display: block;
    }

    .skill-students {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .skill-count-badge {
        background: var(--bg-light-teal);
        color: var(--primary-teal-dark);
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 1.05rem;
    }

    .sessions-table {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .session-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        padding: 15px 20px;
        border-radius: 12px;
        border-left: 3px solid var(--primary-teal);
        transition: box-shadow 0.2s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .session-row:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }

    .session-row strong {
        color: var(--text-slate);
        font-size: 1rem;
    }

    .session-row p {
        margin: 4px 0 0 0;
        color: var(--primary-teal);
        font-size: 13px;
        font-weight: 600;
    }

    .session-row small {
        background: var(--bg-light-teal);
        color: var(--primary-teal-dark);
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .feedback-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .feedback-item {
        padding: 20px;
        background: white;
        border: 1px solid var(--primary-teal-light);
        border-left: 4px solid var(--primary-teal);
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
    }

    .feedback-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        align-items: center;
    }

    .feedback-header strong {
        font-size: 1.05rem;
        color: var(--text-slate);
    }

    .feedback-item p {
        flex: 1;
        margin: 0 0 15px 0;
        font-style: italic;
        color: #475569;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .feedback-item small {
        color: #94a3b8;
        font-size: 0.8rem;
        font-weight: 600;
        align-self: flex-start;
    }
</style>

@endsection
