@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>{{ $teacher->name }}</h1>
        <p>{{ $teacher->bio ?? '' }}</p>
    </div>

    <div class="dashboard-section">
        <h2>Offered Skills</h2>
        <div class="skills-grid">
            @forelse($teacher->userSkills as $us)
                <div class="skill-card">
                    <h4>{{ $us->skill->title ?? 'Skill' }}</h4>
                    <p>{{ Str::limit($us->skill->description ?? '', 100) }}</p>
                    <p><strong>Level:</strong> {{ ucfirst($us->level ?? 'N/A') }}</p>
                    @auth
                        <a href="{{ route('requests.create', $us) }}" class="btn primary">Request this Teacher</a>
                    @else
                        <a href="{{ route('register') }}" class="btn primary">Sign up to Request</a>
                    @endauth
                </div>
            @empty
                <p class="empty">This teacher has not listed any skills.</p>
            @endforelse
        </div>
    </div>

</section>

@endsection
