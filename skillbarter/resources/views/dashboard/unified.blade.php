@extends('app')

@section('content')

<section class="dashboard">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h1>🎓 Welcome Back, {{ $user->name }}!</h1>
        <p>You are registered as both Teacher and Student. Here's your unified overview</p>
    </div>

    <!-- ROLE TABS -->
    <div class="role-tabs">
        <a href="{{ route('teacher.dashboard') }}" class="tab-btn">👨‍🏫 Teacher Dashboard</a>
        <a href="{{ route('student.dashboard') }}" class="tab-btn">🎓 Student Dashboard</a>
    </div>

    <!-- TWO COLUMN LAYOUT -->
    <div class="unified-grid">

        <!-- TEACHING SECTION -->
        <div class="dashboard-section">
            <h2>👨‍🏫 Teaching Overview</h2>

            <div class="mini-stats">
                <div class="mini-stat">
                    <h4>Teaching Skills</h4>
                    <p class="number">{{ $user->skillsOffered()->count() }}</p>
                </div>
                <div class="mini-stat">
                    <h4>Student Requests</h4>
                    <p class="number">{{ \App\Models\RequestModel::where('responder_id', $user->id)->count() }}</p>
                </div>
            </div>

            <div class="quick-actions-section">
                <a href="{{ route('teacher.dashboard') }}" class="btn primary">View Teaching Dashboard</a>
                <a href="{{ route('teacher.resources.index') }}" class="btn secondary">📚 Manage Resources</a>
            </div>
        </div>

        <!-- LEARNING SECTION -->
        <div class="dashboard-section">
            <h2>🎓 Learning Overview</h2>

            <div class="mini-stats">
                <div class="mini-stat">
                    <h4>Learning Skills</h4>
                    <p class="number">{{ $user->skillsWanted()->count() }}</p>
                </div>
                <div class="mini-stat">
                    <h4>Active Courses</h4>
                    <p class="number">{{ \App\Models\RequestModel::where('requester_id', $user->id)->whereIn('status', ['accepted', 'in_progress'])->count() }}</p>
                </div>
            </div>

            <div class="quick-actions-section">
                <a href="{{ route('student.dashboard') }}" class="btn primary">View Learning Dashboard</a>
                <a href="{{ route('student.learning-path') }}" class="btn secondary">📖 My Learning Path</a>
            </div>
        </div>

    </div>

    <!-- SHARED ACTIONS -->
    <div class="dashboard-section">
        <h2>⚡ Quick Actions</h2>
        <div class="action-grid">
            <a href="{{ route('find-skill') }}" class="action-card">
                <h3>🔍 Find Skills</h3>
                <p>Browse and discover new skills to learn</p>
            </a>
            <a href="{{ route('my.skills') }}" class="action-card">
                <h3>⭐ Manage Skills</h3>
                <p>Add or update your teaching and learning skills</p>
            </a>
            <a href="{{ route('requests.index') }}" class="action-card">
                <h3>📝 Requests</h3>
                <p>View all teaching and learning requests</p>
            </a>
            <a href="{{ route('profile.edit') }}" class="action-card">
                <h3>👤 Profile</h3>
                <p>Update your profile and preferences</p>
            </a>
            <a href="{{ route('rewards.index') }}" class="action-card">
                <h3>🏆 Rewards</h3>
                <p>Check your points and badges</p>
            </a>
            <a href="{{ route('premium.index') }}" class="action-card">
                <h3>💎 Premium</h3>
                <p>Upgrade to premium for more features</p>
            </a>
        </div>
    </div>

</section>

<style>
    .role-tabs {
        display: flex;
        gap: 10px;
        margin: 20px 0;
        flex-wrap: wrap;
    }

    .tab-btn {
        padding: 12px 20px;
        background: white;
        border: 2px solid #ddd;
        border-radius: 8px;
        text-decoration: none;
        color: #333;
        font-weight: 600;
        transition: all 0.3s;
    }

    .tab-btn:hover {
        background: #1a1a1a;
        color: white;
        border-color: #1a1a1a;
    }

    .unified-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin: 30px 0;
    }

    @media (max-width: 768px) {
        .unified-grid {
            grid-template-columns: 1fr;
        }
    }

    .mini-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin: 20px 0;
    }

    .mini-stat {
        background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
        color: white;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }

    .mini-stat h4 {
        margin: 0 0 10px 0;
        font-size: 13px;
    }

    .mini-stat .number {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
    }

    .quick-actions-section {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin: 20px 0;
    }

    .action-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        border: 2px solid #f0f0f0;
        text-decoration: none;
        color: #333;
        transition: all 0.3s;
    }

    .action-card:hover {
        border-color: #1a1a1a;
        box-shadow: 0 4px 12px rgba(26, 26, 26, 0.2);
    }

    .action-card h3 {
        margin: 0 0 10px 0;
    }

    .action-card p {
        margin: 0;
        font-size: 13px;
        color: #666;
    }
</style>

@endsection
