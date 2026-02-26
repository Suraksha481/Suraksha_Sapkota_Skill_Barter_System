@extends('layouts.app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>My Learning Progress</h1>
        <p>Track how far you've come in your learning journey</p>
    </div>

    <!-- PROGRESS STATS -->
    <div class="progress-stats">
        <div class="stat-card">
            <h3>{{ $stats['total_courses_taken'] }}</h3>
            <p>Total Courses</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['completed_courses'] }}</h3>
            <p>Completed</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['in_progress_courses'] }}</h3>
            <p>In Progress</p>
        </div>

        <div class="stat-card">
            <h3>{{ round($totalHours, 1) }}</h3>
            <p>Learning Hours</p>
        </div>
    </div>

    <!-- SKILLS PROGRESS -->
    <div class="progress-section">
        <h2>Skill Progress</h2>
        <div class="skills-progress">
            @forelse($learningSkills as $skill)
                @php
                    $skillCourses = $allRequests->filter(fn($r) => $r->userSkill->skill_id == $skill->id);
                    $skillCompleted = $skillCourses->where('status', 'completed')->count();
                    $skillTotal = $skillCourses->count();
                    $skillProgress = $skillTotal > 0 ? ($skillCompleted / $skillTotal) * 100 : 0;
                @endphp

                <div class="skill-progress" onclick="location.href='{{ route('student.skill-progress', $skill->id) }}';" style="cursor: pointer;">
                    <div class="skill-header">
                        <h4>{{ $skill->title }}</h4>
                        <span class="progress-text">{{ $skillCompleted }}/{{ $skillTotal }} completed</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $skillProgress }}%"></div>
                    </div>
                    <span class="progress-percentage">{{ round($skillProgress) }}%</span>
                </div>
            @empty
                <p class="empty">No skills selected for learning yet.</p>
            @endforelse
        </div>
    </div>

    <!-- COURSE TIMELINE -->
    <div class="progress-section">
        <h2>Course Timeline</h2>
        <div class="timeline">
            @forelse($allRequests->sortByDesc('updated_at') as $course)
                <div class="timeline-item timeline-{{ $course->status }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4>{{ $course->userSkill->skill->title }}</h4>
                        <p><strong>Teacher:</strong> {{ $course->responder->name }}</p>
                        <p><strong>Status:</strong> <span class="badge badge-{{ $course->status }}">{{ ucfirst($course->status) }}</span></p>
                        <small>{{ $course->updated_at->format('M d, Y') }}</small>
                    </div>
                </div>
            @empty
                <p class="empty">No course history yet.</p>
            @endforelse
        </div>
    </div>

    <!-- TEACHER FEEDBACK -->
    <div class="progress-section">
        <h2>Feedback Received</h2>
        <div class="feedback-list">
            @forelse($feedbackReceived as $feedback)
                <div class="feedback-item">
                    <div class="feedback-header">
                        <strong>{{ $feedback->author->name }}</strong>
                        <span class="rating">{{ str_repeat('⭐', $feedback->rating ?? 0) }}</span>
                    </div>
                    <p>{{ $feedback->comment }}</p>
                    <small>{{ $feedback->created_at->format('M d, Y') }}</small>
                </div>
            @empty
                <p class="empty">No feedback received yet. Complete a course to get feedback!</p>
            @endforelse
        </div>
    </div>

</section>

<style>
    .progress-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .stat-card {
        background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        border: 1px solid #e0e0e0;
    }

    .stat-card h3 {
        margin: 0;
        font-size: 28px;
    }

    .stat-card p {
        margin: 10px 0 0 0;
        font-size: 14px;
    }

    .progress-section {
        background: white;
        padding: 25px;
        margin: 25px 0;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .skills-progress {
        margin-top: 20px;
    }

    .skill-progress {
        background: #f9f9f9;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .skill-progress:hover {
        background: #f0f0f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .skill-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .skill-header h4 {
        margin: 0;
    }

    .progress-text {
        font-size: 12px;
        color: #666;
    }

    .progress-bar {
        background: #ddd;
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .progress-fill {
        background: linear-gradient(90deg, #1a1a1a 0%, #333333 100%);
        height: 100%;
        transition: width 0.3s;
    }

    .progress-percentage {
        font-size: 12px;
        color: #666;
        font-weight: bold;
    }

    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 30px;
        position: relative;
        padding-left: 40px;
    }

    .timeline-marker {
        position: absolute;
        left: 0;
        top: 0;
        width: 16px;
        height: 16px;
        background: #1a1a1a;
        border-radius: 50%;
        border: 3px solid white;
    }

    .timeline-completed .timeline-marker {
        background: #4caf50;
    }

    .timeline-content {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        flex: 1;
    }

    .timeline-content h4 {
        margin: 0 0 10px 0;
    }

    .timeline-content p {
        margin: 5px 0;
        font-size: 13px;
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
        color: white;
    }

    .badge-open { background: #ff9800; }
    .badge-accepted { background: #2196f3; }
    .badge-in_progress { background: #4caf50; }
    .badge-completed { background: #8bc34a; }

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
