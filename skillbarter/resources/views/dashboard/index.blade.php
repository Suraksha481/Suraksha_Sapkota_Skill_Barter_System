@extends('app')

@section('content')

<section class="dashboard">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h1>Welcome, {{ $user->name }}</h1>
        <p>Here's an overview of your SkillBarter activity</p>
    </div>

    <!-- STATS -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>{{ $stats['teach_skills'] }}</h3>
            <p>Skills I Teach</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['learn_skills'] }}</h3>
            <p>Skills I Want to Learn</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['pending_requests'] }}</h3>
            <p>Pending Requests</p>
        </div>

        <div class="stat-card">
            <h3>{{ $stats['total_requests'] }}</h3>
            <p>Total Requests</p>
        </div>
    </div>

    <!-- MY SKILLS -->
    <div class="dashboard-section">
        <h2>My Skills</h2>

        <div class="skills-columns">
            <!-- TEACH -->
            <div class="skills-box">
                <h3>Skills I Teach</h3>

                <ul>
                    @forelse($teachSkills as $skill)
                        <li>{{ $skill->title }}</li>
                    @empty
                        <li class="empty">You haven't added teaching skills yet.</li>
                    @endforelse
                </ul>

                <a href="{{ route('my.skills') }}" class="btn primary small">
                    Manage Skills
                </a>
            </div>

            <!-- LEARN -->
            <div class="skills-box">
                <h3>Skills I Want to Learn</h3>

                <ul>
                    @forelse($learnSkills as $skill)
                        <li>{{ $skill->title }}</li>
                    @empty
                        <li class="empty">You haven't added learning skills yet.</li>
                    @endforelse
                </ul>

                <a href="{{ route('my.skills') }}" class="btn ghost small">
                    Manage Skills
                </a>
            </div>
        </div>
    </div>

    <!-- REQUESTS -->
    <div class="dashboard-section">
        <h2>Recent Requests</h2>

        <div class="requests-grid">
            <!-- RECEIVED -->
            <div class="request-box">
                <h3>Requests Received</h3>

                <ul>
                    @forelse($pendingRequests as $request)
                        <li>
                            Request from <strong>{{ $request->requester->name ?? 'User #' . $request->requester_id }}</strong>
                            for <strong>{{ $request->userSkill->skill->title ?? '' }}</strong>
                            <span class="badge pending">Pending</span>
                        </li>
                    @empty
                        <li class="empty">No pending requests.</li>
                    @endforelse
                </ul>
            </div>

            <!-- SENT -->
            <div class="request-box">
                <h3>Requests Sent</h3>

                <ul>
                    @forelse($myRequests as $request)
                        <li>
                            To <strong>{{ $request->responder->name ?? 'User #' . $request->responder_id }}</strong>
                            for <strong>{{ $request->userSkill->skill->title ?? '' }}</strong>
                            <span class="badge {{ $request->status }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </li>
                    @empty
                        <li class="empty">You haven't sent any requests.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="dashboard-actions">
        <a href="{{ route('find-skill') }}" class="btn primary">
            Find New Skills
        </a>

        <a href="{{ route('my.skills') }}" class="btn ghost">
            Add / Manage My Skills
        </a>
    </div>

</section>

@endsection
