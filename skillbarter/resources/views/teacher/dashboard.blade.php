@extends('app')

@section('content')

<section class="dashboard">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h1>Teacher Dashboard</h1>
        <p>Welcome back, {{ $user->name }}! Here's your teaching overview</p>
    </div>

    <!-- STATS -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>{{ $stats['teaching_skills'] }}</h3>
            <p>Skills I Teach</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['active_sessions'] }}</h3>
            <p>Active Teaching Sessions</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['completed_sessions'] }}</h3>
            <p>Students Taught</p>
        </div>

        <div class="stat-card">
            <h3>⭐ {{ $stats['average_rating'] }}</h3>
            <p>Your Rating</p>
        </div>
    </div>

    <!-- TEACHING SKILLS -->
    <div class="dashboard-section">
        <h2>Skills I Teach</h2>
        <div class="skills-box">
            @forelse($teachingSkills as $skill)
                <div class="skill-card">
                    <h4>{{ $skill->title }}</h4>
                    <p>{{ $skill->description }}</p>
                </div>
            @empty
                <p class="empty">You haven't added teaching skills yet. <a href="{{ route('my.skills') }}">Add skills</a></p>
            @endforelse
        </div>
    </div>

    <!-- STUDENT REQUESTS -->
    <div class="dashboard-section">
        <h2>Student Requests</h2>
        <div class="requests-list">
            @forelse($studentRequests->take(5) as $request)
                <div class="request-card">
                    <div>
                        <h4>{{ $request->requester->name }} wants to learn <strong>{{ $request->userSkill->skill->title }}</strong></h4>
                        <p>Status: <span class="badge badge-{{ $request->status }}">{{ ucfirst($request->status) }}</span></p>
                    </div>
                    <div>
                        <a href="{{ route('requests.show', $request) }}" class="btn small">View Request</a>
                    </div>
                </div>
            @empty
                <p class="empty">No student requests yet.</p>
            @endforelse
        </div>
    </div>

    <!-- STUDENT FEEDBACK -->
    <div class="dashboard-section">
        <h2>Student Feedback</h2>
        <div class="feedback-list">
            @forelse($feedbackReceived as $feedback)
                <div class="feedback-card">
                    <div class="feedback-header">
                        <strong>{{ $feedback->author->name }}</strong>
                        <span class="rating">{{ str_repeat('⭐', $feedback->rating ?? 0) }}</span>
                    </div>
                    <p>{{ $feedback->comment }}</p>
                </div>
            @empty
                <p class="empty">No feedback yet. Start teaching to receive feedback!</p>
            @endforelse
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="dashboard-section">
        <h2>Quick Actions</h2>
        <div class="action-buttons">
            <a href="{{ route('teacher.resources.index') }}" class="btn primary">Manage Resources</a>
            <a href="{{ route('teacher.analytics') }}" class="btn primary">View Analytics</a>
            <a href="{{ route('my.skills') }}" class="btn secondary">Add New Skill</a>
        </div>
    </div>

</section>

<style>
    /* make container light with readable text */



    .skill-card {
        background: #fff;
        color: #000;
        padding: 15px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .skill-card h4,
    .skill-card p {
        color: #000;
    }

    .skills-box {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #ddd;
    }

    .request-card,
    .feedback-card {
        background: white;
        border: 1px solid #ddd;
        padding: 15px;
        margin: 10px 0;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-open { background: #fff3cd; color: #856404; }
    .badge-accepted { background: #d1ecf1; color: #0c5460; }
    .badge-in_progress { background: #cfe2ff; color: #084298; }
    .badge-completed { background: #d1e7dd; color: #0f5132; }

    .feedback-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .rating {
        color: #ffc107;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
</style>

@endsection
