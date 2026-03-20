@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>My Learning Path</h1>
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
                <p>No enrolled courses yet.</p>
                <a href="{{ route('teachers.index') }}" class="btn primary">Find a Teacher</a>
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
        background: #fff;
        padding: 8px 20px;
        border-radius: 25px;
        text-decoration: none;
        color: var(--primary-teal);
        border: 2px solid var(--primary-teal-light);
        transition: all 0.3s;
        font-weight: 600;
        font-size: 14px;
    }

    .filter-btn:hover {
        background: var(--primary-teal);
        color: #fff;
        border-color: var(--primary-teal);
    }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin: 30px 0;
    }

    .course-card {
        background: white;
        border: 1px solid var(--primary-teal-light);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(32, 166, 138, 0.1);
        border-color: var(--primary-teal);
    }

    .course-header {
        background: #fff;
        color: var(--text-dark);
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f5f5f5;
    }

    .course-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary-teal);
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
