@extends('app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/rewards.css') }}">

<div class="rewards-container">
    <!-- Header -->
    <div class="rewards-header">
        <h1>Welcome, {{ $user->name }}</h1>
        <p>Your gamification dashboard</p>

        <div class="header-stats">
            <div class="stat-badge">
                <span class="number">{{ $user->total_sessions }}</span>
                <span class="label">Sessions</span>
            </div>
            <div class="stat-badge">
                <span class="number">{{ $user->userSkills()->where('type', 'offer')->count() }}</span>
                <span class="label">Skills</span>
            </div>
            <div class="stat-badge">
                <span class="number">{{ $user->averageRating() ? number_format($user->averageRating(), 1) : 'No' }}</span>
                <span class="label">Feedback</span>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="rewards-grid">
        <!-- Level Card -->
        <div class="card level-card">
            <h3 class="card-title">Your Level</h3>
            <div class="level-display">
                <p class="level-number">{{ $level }}</p>
                <p class="level-label">@switch($level)
                    @case(1)
                        Newcomer
                    @break
                    @case(2)
                    @case(3)
                        Learner
                    @break
                    @case(4)
                    @case(5)
                        Contributor
                    @break
                    @case(6)
                    @case(7)
                        Helper
                    @break
                    @case(8)
                    @case(9)
                        Expert
                    @break
                    @default
                        Master
                @endswitch</p>
            </div>

            <div class="progress-container">
                <div class="progress-label">
                    <span>Next Level Progress</span>
                    <span>{{ round($levelProgress['current_points']) }} / {{ $levelProgress['level_points'] }}</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $levelProgress['percentage'] }}%"></div>
                </div>
            </div>

            <div class="stats-mini">
                <div class="stat-mini">
                    <span class="value">{{ $points }}</span>
                    <span class="label">Total Points</span>
                </div>
                <div class="stat-mini">
                    <span class="value">{{ $pointsToNext }}</span>
                    <span class="label">To Next</span>
                </div>
            </div>
        </div>

        <!-- User Earned Badges -->
        <div class="card">
            <h3 class="card-title">Badges Earned</h3>
            @if(count($userBadges) > 0)
                <div class="badges-grid">
                    @foreach($userBadges as $badge)
                        <div class="badge-item earned tooltip">
                            <span class="badge-icon">{{ $badge['icon'] }}</span>
                            <span class="badge-name">{{ $badge['name'] }}</span>
                            <span class="tooltip-text">{{ $badge['description'] }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon"></div>
                    <p>Start earning badges by being active in the community!</p>
                </div>
            @endif

            <p style="font-size: 0.85rem; color: #666; margin-top: 1rem; margin-bottom: 0;">
                You have earned {{ count($userBadges) }} out of {{ count($allBadges) }} badges
            </p>
        </div>

        <!-- Leaderboard -->
        <div class="card leaderboard-card">
            <h3 class="card-title">Top 10 Leaderboard</h3>

            @if($userRank)
                <div class="user-rank-display">
                    <div class="rank-number">#{{ $userRank }}</div>
                    <div class="rank-label">Your Current Rank</div>
                </div>
            @endif

            @if(count($leaderboard) > 0)
                <ul class="leaderboard-list">
                    @foreach($leaderboard as $index => $entry)
                        <li class="leaderboard-item {{ $entry->user_id === $user->id ? 'user-rank' : '' }}">
                            <div class="leaderboard-rank">
                                {{ $index + 1 }}
                            </div>
                            <div class="leaderboard-info">
                                <p class="leaderboard-name">{{ $entry->user->name }}</p>
                                <p class="leaderboard-role">
                                    @if($entry->user->teacher_profile)
                                        Teacher
                                    @elseif($entry->user->student_profile)
                                        Student
                                    @else
                                        Member
                                    @endif
                                </p>
                            </div>
                            <div class="leaderboard-points">{{ $entry->points }} pts</div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <p>Leaderboard coming soon...</p>
                </div>
            @endif
        </div>
    </div>

    <!-- All Badges Section -->
    <div class="card">
        <h3 class="card-title">All Available Badges</h3>
        <div class="badges-grid">
            @php
                $earnedBadgeKeys = collect($userBadges)->pluck('key')->toArray();
            @endphp
            @foreach($allBadges as $badge)
                <div class="badge-item {{ in_array($badge['key'], $earnedBadgeKeys) ? 'earned' : 'locked' }} tooltip">
                    <span class="badge-icon">{{ $badge['icon'] }}</span>
                    <span class="badge-name">{{ $badge['name'] }}</span>
                    @if(!in_array($badge['key'], $earnedBadgeKeys))
                        <span class="badge-lock">🔒</span>
                    @endif
                    <span class="tooltip-text">{{ $badge['description'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- User Stats -->
    <div class="card">
        <h3 class="card-title">Your Activity</h3>
        <div class="achievement-list">
            <div class="achievement-item">
                <p class="achievement-title">📚 Sessions Taught</p>
                <p class="achievement-desc">{{ $stats['sessions_taught'] }} completed sessions</p>
            </div>
            <div class="achievement-item">
                <p class="achievement-title">👨‍🎓 Sessions Learned</p>
                <p class="achievement-desc">{{ $stats['sessions_learned'] }} completed sessions</p>
            </div>
            <div class="achievement-item">
                <p class="achievement-title">🎯 Skills Shared</p>
                <p class="achievement-desc">{{ $stats['skills_count'] }} skills offered</p>
            </div>
            <div class="achievement-item">
                <p class="achievement-title">⭐ Feedback Given</p>
                <p class="achievement-desc">{{ $stats['feedback_given'] }} feedback submitted</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="button-section">
        <a href="{{ url('/') }}" class="btn-pill secondary" style="text-decoration:none;">Back to Home</a>
        <a href="{{ route('dashboard') }}" class="btn-pill primary" style="text-decoration:none;">Back to Dashboard</a>
    </div>
</div>

@endsection
