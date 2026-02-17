@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>📖 My Learning Path</h1>
        <p>Track your enrolled courses and learning journey</p>
    </div>

    <!-- LEARNING SKILLS FILTER -->
    <div class="filter-section">
        <h3>Filter by Skill:</h3>
        <div class="skill-filter">
            @forelse($learningSkills as $skill)
                <a href="?skill={{ $skill->id }}" class="filter-btn">{{ $skill->title }}</a>
            @empty
                <p>No skills selected for learning yet.</p>
            @endforelse
        </div>
    </div>

    <!-- ENROLLED COURSES -->
    <div class="courses-grid">
        @forelse($enrolledCourses as $course)
            <div class="course-card">
                <div class="course-header">
                    <h3>{{ $course->userSkill->skill->title }}</h3>
                    <span class="badge badge-{{ $course->status }}">{{ ucfirst($course->status) }}</span>
                </div>

                <div class="course-body">
                    <p><strong>Teacher:</strong> {{ $course->responder->name }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($course->status) }}</p>
                    <p><strong>Requested:</strong> {{ $course->created_at->format('M d, Y') }}</p>
                    @if($course->status == 'completed')
                        <p><strong>Completed:</strong> {{ $course->updated_at->format('M d, Y') }}</p>
                    @endif
                </div>

                <div class="course-actions">
                    <a href="{{ route('requests.show', $course) }}" class="btn small">View Course</a>
                    @if($course->status == 'completed')
                        <a href="{{ route('feedback.create', ['type' => 'course', 'id' => $course->id]) }}" class="btn small secondary">Leave Feedback</a>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>📭 No enrolled courses yet.</p>
                <a href="{{ route('find-skill') }}" class="btn primary">Find a Teacher</a>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pagination-wrapper">
        {{ $enrolledCourses->links() }}
    </div>

</section>

<style>
    .filter-section {
        background: white;
        padding: 20px;
        margin: 20px 0;
        border-radius: 8px;
    }

    .skill-filter {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .filter-btn {
        background: #f0f0f0;
        padding: 8px 16px;
        border-radius: 20px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s;
    }

    .filter-btn:hover {
        background: #2196f3;
        color: white;
    }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .course-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }

    .course-card:hover {
        transform: translateY(-5px);
    .course-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
        color: white;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: start;
    }
        margin: 0;
    }

    .course-body {
        padding: 15px;
    }

    .course-body p {
        margin: 8px 0;
        font-size: 13px;
    }

    .course-actions {
        padding: 15px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        gap: 10px;
    }

    .btn.small {
        flex: 1;
        padding: 8px 12px;
        font-size: 12px;
        text-align: center;
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

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: #f5f5f5;
        border-radius: 8px;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
</style>

@endsection
