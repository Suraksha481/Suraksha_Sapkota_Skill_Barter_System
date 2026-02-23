@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>{{ $skill->title ?? 'Skill Progress' }}</h1>
        <p>Track your progress in this skill</p>
    </div>

    @if($skill)
        <!-- SKILL INFO -->
        <div class="skill-info">
            <h2>{{ $skill->title }}</h2>
            <p>{{ $skill->description }}</p>
        </div>

        <!-- PROGRESS SUMMARY -->
        <div class="progress-summary">
            <div class="summary-card">
                <h4>Total Courses</h4>
                <p class="big-number">{{ $coursesForSkill->count() }}</p>
            </div>
            <div class="summary-card">
                <h4>Completed</h4>
                <p class="big-number">{{ $completedCount }}</p>
            </div>
            <div class="summary-card">
                <h4>In Progress</h4>
                <p class="big-number">{{ $inProgressCount }}</p>
            </div>
            <div class="summary-card">
                <h4>Progress</h4>
                <p class="big-number">{{ $coursesForSkill->count() > 0 ? round(($completedCount / $coursesForSkill->count()) * 100) : 0 }}%</p>
            </div>
        </div>

        <!-- COURSES FOR THIS SKILL -->
        <div class="courses-section">
            <h3>My Courses in {{ $skill->title }}</h3>

            <div class="courses-list">
                @forelse($coursesForSkill as $course)
                    <div class="course-item">
                        <div class="course-info">
                            <h4>Teacher: {{ $course->responder->name }}</h4>
                            <p>Status: <span class="badge badge-{{ $course->status }}">{{ ucfirst($course->status) }}</span></p>
                            <p>Requested: {{ $course->created_at->format('M d, Y') }}</p>
                            @if($course->status == 'completed')
                                <p>Completed: {{ $course->updated_at->format('M d, Y') }}</p>
                            @endif
                        </div>
                        <div class="course-actions">
                            <a href="{{ route('requests.show', $course) }}" class="btn small">View Details</a>
                        </div>
                    </div>
                @empty
                    <p class="empty">No courses yet for this skill.</p>
                @endforelse
            </div>
        </div>
    @else
        <p class="empty">Skill not found.</p>
    @endif

    <div class="back-button">
        <a href="{{ route('student.learning-path') }}" class="btn secondary">← Back to Learning Path</a>
    </div>

</section>

<style>
    .skill-info {
        background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
        color: white;
        padding: 30px;
        border-radius: 8px;
        margin: 20px 0;
    }

    .skill-info h2 {
        margin: 0 0 10px 0;
    }

    .progress-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .summary-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .summary-card h4 {
        margin: 0 0 10px 0;
        color: #666;
    }

    .big-number {
        margin: 0;
        font-size: 32px;
        font-weight: bold;
        color: #1a1a1a;
    }

    .courses-section {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .courses-list {
        margin-top: 20px;
    }

    .course-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        border-radius: 8px;
    }

    .course-info p {
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

    .course-actions {
        display: flex;
        gap: 10px;
    }

    .btn.small {
        padding: 8px 16px;
        font-size: 12px;
    }

    .back-button {
        margin-top: 30px;
        text-align: center;
    }

    .empty {
        text-align: center;
        padding: 40px;
        color: #999;
    }
</style>

@endsection
