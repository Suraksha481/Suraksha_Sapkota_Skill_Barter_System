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
    <div class="dashboard-section" style="margin-top: 3rem;">
        <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 2rem;">Skills I Teach</h2>
        <div class="skills-box" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @forelse($teachingSkills as $userSkill)
                <div class="skill-card" style="background: #fff; border: 2px solid #000; padding: 25px; border-radius: 12px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <h4 style="margin: 0 0 10px 0; font-size: 1.2rem; font-weight: 800; text-transform: uppercase;">{{ $userSkill->skill->title ?? 'Untitled Skill' }}</h4>
                    <p style="margin: 0; color: #666; font-size: 14px; line-height: 1.6;">{{ $userSkill->skill->description ?? 'No description provided.' }}</p>
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f0f0f0;">
                         <span style="font-size: 11px; font-weight: bold; background: #000; color: #fff; padding: 4px 10px; border-radius: 4px; text-transform: uppercase;">TEACHING</span>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; padding: 40px; background: #fff; border: 1px dashed #ccc; border-radius: 12px; text-align: center;">
                    <p style="color: #666; font-style: italic;">You haven't added teaching skills yet.</p>
                    <a href="{{ route('my.skills') }}" class="btn primary" style="margin-top: 1rem;">Add skills</a>
                </div>
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
</style>
@endsection
