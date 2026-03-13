@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header" style="display: flex; align-items: center; gap: 20px;">
        @if($teacher->avatar)
            <img src="{{ asset($teacher->avatar) }}" alt="{{ $teacher->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
        @endif
        <div style="flex-grow: 1;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <h1 style="margin: 0; margin-bottom: 0.5rem;">{{ $teacher->name }}</h1>
                    
                    <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1rem;">
                        <div style="color:#f59e0b; font-size:1.25rem;">
                            @if(isset($averageRating) && $averageRating > 0)
                                ★ {{ number_format($averageRating, 1) }}
                            @else
                                <span style="color:#cbd5e1; font-size:1rem;">No ratings yet</span>
                            @endif
                        </div>
                        @if(isset($reviewsCount) && $reviewsCount > 0)
                            <span style="color:#e2e8f0; font-size:0.95rem;">({{ $reviewsCount }} reviews)</span>
                        @endif
                    </div>

                    <p style="margin: 5px 0 0 0;">{{ $teacher->bio ?? '' }}</p>
                    @if($teacher->teacherProfile)
                        <div style="margin-top: 15px; font-size: 0.95rem; color: #e2e8f0; display:flex; gap:1.5rem; background: rgba(255,255,255,0.1); padding: 10px 15px; border-radius: 8px; display:inline-flex;">
                            @if($teacher->teacherProfile->experience_years > 0)
                                <span><strong><i class="fas fa-briefcase"></i> Experience:</strong> {{ $teacher->teacherProfile->experience_years }} years</span>
                            @endif
                            @if($teacher->teacherProfile->teaching_style)
                                <span><strong><i class="fas fa-chalkboard-teacher"></i> Style:</strong> {{ $teacher->teacherProfile->teaching_style }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
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

    <div class="dashboard-section" style="margin-top: 2rem;">
        <h2>Reviews & Feedback</h2>
        @if(isset($reviews) && $reviews->count() > 0)
            <div class="reviews-list" style="display:flex; flex-direction:column; gap:1.5rem;">
                @foreach($reviews as $review)
                    <div class="review-card" style="background: rgba(255,255,255,0.05); border-radius: 8px; padding: 1.5rem;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem;">
                            <div style="display:flex; align-items:center; gap: 1rem;">
                                <img src="{{ $review->author->avatar ?? 'https://via.placeholder.com/40' }}" alt="{{ $review->author->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                <div>
                                    <h4 style="margin:0;">{{ $review->author->name }}</h4>
                                    <small style="color: #94a3b8;">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div style="color:#f59e0b; font-size:1.1rem; letter-spacing: 2px;">
                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </div>
                        </div>
                        @if($review->comment)
                            <p style="margin:0; color:#e2e8f0; line-height: 1.6; font-style: italic;">"{{ $review->comment }}"</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="empty">This teacher hasn't received any reviews yet.</p>
        @endif
    </div>

</section>

@endsection
