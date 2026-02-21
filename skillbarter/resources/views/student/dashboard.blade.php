@extends('app')

@section('content')

<section class="dashboard">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h1>🎓 Student Dashboard</h1>
        <p>Welcome, {{ $user->name }}! Track your learning journey</p>
    </div>

    <!-- STATS -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>{{ $stats['learning_skills'] }}</h3>
            <p>Skills Learning</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['active_courses'] }}</h3>
            <p>Active Courses</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['completed_courses'] }}</h3>
            <p>Courses Completed</p>
        </div>

        <div class="stat-card">
            <h3>⭐ {{ $stats['average_rating'] }}</h3>
            <p>Your Rating</p>
        </div>
    </div>

    <!-- LEARNING SKILLS -->
    <div class="dashboard-section">
        <h2>📚 Skills I'm Learning</h2>
        <div class="skills-box">
            @forelse($learningSkills as $skill)
                <div class="skill-card">
                    <h4>{{ $skill->title }}</h4>
                    <p>{{ $skill->description }}</p>
                </div>
            @empty
                <p class="empty">You haven't selected any skills to learn yet. <a href="{{ route('my.skills') }}">Add skills</a></p>
            @endforelse
        </div>
    </div>

    <!-- MY LEARNING REQUESTS -->
    <div class="dashboard-section">
        <h2>📝 My Learning Requests</h2>
        <div class="requests-list">
            @forelse($myRequests->take(5) as $request)
                <div class="request-card">
                    <div>
                        <h4>Learning <strong>{{ $request->userSkill->skill->title }}</strong></h4>
                        <p>Teacher: <strong>{{ $request->responder->name }}</strong></p>
                        <p>Status: <span class="badge badge-{{ $request->status }}">{{ ucfirst($request->status) }}</span></p>
                    </div>
                    <div>
                        <a href="{{ route('requests.show', $request) }}" class="btn small">View Details</a>
                    </div>
                </div>
            @empty
                <p class="empty">No learning requests yet. <a href="{{ route('teachers.index') }}">Find a teacher</a></p>
            @endforelse
        </div>
    </div>

    <!-- TEACHER FEEDBACK -->
    <div class="dashboard-section">
        <h2>📣 Feedback from Teachers</h2>
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
                <p class="empty">No feedback yet. Complete a course to receive feedback!</p>
            @endforelse
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="dashboard-section">
        <h2>⚡ Quick Actions</h2>
        <div class="action-buttons">
            <a href="{{ route('student.learning-path') }}" class="btn primary">📖 Learning Path</a>
            <a href="{{ route('student.progress') }}" class="btn primary">📈 My Progress</a>
            <a href="{{ route('teachers.index') }}" class="btn secondary">🔍 Find Teachers</a>
            <a href="{{ route('my.skills') }}" class="btn secondary">➕ Add Skills</a>
        </div>
    </div>

</section>

<style>
    .skill-card {
        background: #f5f5f5;
        padding: 15px;
        margin: 10px 0;
        border-radius: 8px;
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
