@extends('app')

@section('content')

<section class="dashboard">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h1>Student Dashboard</h1>
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
            <h3>{{ number_format((float) $stats['average_rating'], 1) }} / 5.0</h3>
            <p>Your Rating</p>
        </div>
    </div>

    <!-- LEARNING SKILLS -->
    <div class="dashboard-section" style="margin-top: 3rem;">
        <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 2rem;">Skills I'm Learning</h2>
        <div class="skills-box" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @forelse($learningSkills as $userSkill)
                <div class="skill-card">
                    <h4>{{ $userSkill->skill->title ?? 'Untitled Skill' }}</h4>
                    <p>{{ $userSkill->skill->description ?? 'No description provided.' }}</p>
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f0f0f0;">
                         <span style="font-size: 11px; font-weight: 700; background: var(--primary-teal-light); color: var(--primary-teal); padding: 6px 12px; border-radius: 6px; text-transform: uppercase;">LEARNING</span>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; padding: 40px; background: #fff; border: 1px dashed #ccc; border-radius: 12px; text-align: center;">
                    <p style="color: #666; font-style: italic;">You haven't selected any skills to learn yet.</p>
                    <a href="{{ route('my.skills') }}" class="btn primary" style="margin-top: 1rem;">Add skills</a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- MY LEARNING REQUESTS -->
    <div class="dashboard-section">
        <h2 style="display:flex; justify-content:space-between; align-items:center;">
            My Learning Requests
        </h2>
        <div class="requests-list" style="display: flex; flex-direction: column; gap: 15px;">
            @forelse($myRequests->take(5) as $request)
                <div class="request-card" style="display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 20px 25px; border-radius: 16px; border: 1px solid var(--primary-teal-light); box-shadow: 0 4px 15px rgba(0,0,0,0.02); flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="{{ $request->responder->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($request->responder->name).'&background=20a68a&color=fff' }}" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <div>
                            <h4 style="margin: 0 0 5px 0; font-size: 1.1rem; color: var(--text-dark);">Learning <strong style="color: var(--primary-teal);">{{ $request->userSkill->skill->title }}</strong></h4>
                            <p style="margin: 0; font-size: 0.9rem; color: #64748b; display: flex; align-items: center; gap: 10px;">
                                <span>Teacher: <strong>{{ $request->responder->name }}</strong></span>
                                <span style="color: #cbd5e1;">|</span>
                                <span>Status:</span>
                                @if($request->status === 'pending')
                                    <span style="background: #fef08a; color: #854d0e; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.8rem;">Pending</span>
                                @elseif($request->status === 'accepted')
                                    <span style="background: #bbf7d0; color: #166534; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.8rem;">Accepted</span>
                                @elseif($request->status === 'scheduled')
                                    <span style="background: #dbeafe; color: #1e3a8a; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.8rem;">Scheduled</span>
                                @else
                                    <span style="background: #e2e8f0; color: #475569; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.8rem;">{{ ucfirst($request->status) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('requests.show', $request) }}" class="btn-pill primary" style="padding: 10px 24px; font-size: 0.95rem; height: auto;">View Details</a>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px; background: #fff; border-radius: 16px; border: 1px dashed var(--primary-teal-light);">
                    <p class="empty" style="margin: 0; color: #64748b;">No learning requests yet. <a href="{{ route('teachers.index') }}" style="color: var(--primary-teal); font-weight: 600;">Find a teacher</a></p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- TEACHER FEEDBACK -->
    <div class="dashboard-section">
        <h2>Feedback from Teachers</h2>
        <div class="feedback-list">
            @forelse($feedbackReceived as $feedback)
                <div class="feedback-card">
                    <div class="feedback-header">
                        <strong>{{ $feedback->author->name }}</strong>
                        <span class="rating" style="color: var(--primary-teal); font-weight: 700;">{{ $feedback->rating ?? 0 }} / 5</span>
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
        <h2>Quick Actions</h2>
        <div class="action-buttons">
            <a href="{{ route('student.learning-path') }}" class="btn-pill primary" style="text-decoration:none;">Learning Path</a>
            <a href="{{ route('student.progress') }}" class="btn-pill primary" style="text-decoration:none;">My Progress</a>
            <a href="{{ route('teachers.index') }}" class="btn-pill secondary" style="text-decoration:none;">Find Teachers</a>
            <a href="{{ route('my.skills') }}" class="btn-pill secondary" style="text-decoration:none;">Add Skills</a>
        </div>
    </div>

</section>


@endsection
