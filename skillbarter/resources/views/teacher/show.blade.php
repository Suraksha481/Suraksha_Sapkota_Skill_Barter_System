@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header" style="display: flex; align-items: center; gap: 20px;">
        @if($teacher->avatar)
            <img src="{{ asset($teacher->avatar) }}" alt="{{ $teacher->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=000&color=fff" alt="{{ $teacher->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
        @endif
        <div>
            <h1 style="margin: 0;">{{ $teacher->name }}</h1>
            <p style="margin: 5px 0 0 0;">{{ $teacher->bio ?? '' }}</p>
            @if($teacher->teacherProfile)
                <div style="margin-top: 10px; font-size: 0.9rem; color: #ddd;">
                    @if($teacher->teacherProfile->experience_years > 0)
                        <span style="margin-right: 15px;"><strong>Experience:</strong> {{ $teacher->teacherProfile->experience_years }} years</span>
                    @endif
                    @if($teacher->teacherProfile->teaching_style)
                        <span><strong>Style:</strong> {{ $teacher->teacherProfile->teaching_style }}</span>
                    @endif
                </div>
            @endif
        </div>
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

    @if(isset($canViewResources) && $canViewResources)
        <div class="dashboard-section">
            <h2>Resources</h2>
            @if($resources->isEmpty())
                <p class="empty">No resources have been uploaded by this teacher yet.</p>
            @else
                <div class="resources-grid">
                    @foreach($resources as $resource)
                        <div class="resource-card">
                            <div class="resource-header">
                                <h3>📄 {{ $resource->title }}</h3>
                                @if($resource->category)
                                    <span class="category-badge">{{ $resource->category }}</span>
                                @endif
                            </div>

                            <p>{{ $resource->description }}</p>

                            <div class="resource-meta">
                                <small>Uploaded: {{ $resource->created_at->format('M d, Y') }}</small>
                            </div>

                            <div class="resource-actions">
                                <a href="{{ route('teacher.resources.download', $resource) }}" class="btn small">⬇Download</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @elseif(auth()->check() && auth()->user()->isStudent())
        <div class="dashboard-section">
            <h2>Resources</h2>
            <p class="empty">You need to be accepted by this teacher to view their resources.</p>
        </div>
    @elseif(! auth()->check())
        <div class="dashboard-section">
            <h2>Resources</h2>
            <p class="empty">Log in as a student and be accepted by this teacher to access their resources.</p>
        </div>
    @endif

</section>

@endsection
