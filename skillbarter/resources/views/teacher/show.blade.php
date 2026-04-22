@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header" style="display: flex; align-items: center; gap: 20px;">
        @if($teacher->avatar)
            <img src="{{ asset($teacher->avatar) }}" alt="{{ $teacher->name }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 4px solid var(--primary-teal-light); padding: 3px; background: white;">
        @endif
        <div style="flex-grow: 1;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <h1 style="margin: 0; margin-bottom: 0.5rem;">{{ $teacher->name }}</h1>
                    
                    <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1rem;">
                        <div style="color:var(--primary-teal); font-size:1.25rem;">
                            @if(isset($averageRating) && $averageRating > 0)
                                ★ {{ number_format($averageRating, 1) }}
                            @else
                                <span style="color:var(--text-secondary); font-size:1rem;">No ratings yet</span>
                            @endif
                        </div>
                        @if(isset($reviewsCount) && $reviewsCount > 0)
                            <span style="color:var(--text-secondary); font-size:0.95rem; font-weight: 600;">({{ $reviewsCount }} reviews)</span>
                        @endif
                    </div>

                    <p style="margin: 5px 0 0 0;">{{ $teacher->bio ?? '' }}</p>
                    @if($teacher->teacherProfile)
                        <div style="margin-top: 15px; font-size: 0.95rem; color: var(--text-dark); display:flex; gap:1.5rem; background: var(--bg-light-teal); padding: 12px 20px; border-radius: 12px; display:inline-flex; border: 1px solid var(--primary-teal-light);">
                            @if($teacher->teacherProfile->experience_years > 0)
                                <span><strong style="color: var(--primary-teal);"><i class="fas fa-briefcase"></i> Experience:</strong> {{ $teacher->teacherProfile->experience_years }} years</span>
                            @endif
                            @if($teacher->teacherProfile->teaching_style)
                                <span><strong style="color: var(--primary-teal);"><i class="fas fa-chalkboard-teacher"></i> Style:</strong> {{ $teacher->teacherProfile->teaching_style }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-section">
        <h2>{{ $teacher->isTeacher() ? 'Offered Skills (Teaching)' : 'Requested Skills (Learning)' }}</h2>
        <div class="skills-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
            @forelse($teacher->userSkills()->where('type', $teacher->isTeacher() ? 'offer' : 'request')->get() as $us)
                <div class="skill-card" style="padding: 24px; border-radius: 16px; border: 1px solid var(--primary-teal-light); background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: transform 0.3s; cursor: default;">
                    <h4 style="color: var(--primary-teal); margin-top: 0; margin-bottom: 12px; font-size: 1.25rem;">{{ $us->skill->title ?? 'Skill' }}</h4>
                    <p style="color: #64748b; font-size: 0.95rem; line-height: 1.5; margin-bottom: 15px; height: 3em; overflow: hidden;">{{ Str::limit($us->skill->description ?? '', 80) }}</p>
                    <div style="background:var(--bg-light-teal); display:inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; color: var(--primary-teal-dark);">
                        Level: {{ ucfirst($us->level ?? 'N/A') }}
                    </div>
                </div>
            @empty
                <p class="empty" style="grid-column: 1/-1;">This user has not listed any skills for this section.</p>
            @endforelse
        </div>

        @php
            $isViewerTeacher = auth()->check() && auth()->user()->isTeacher();
            $isProfileStudent = $teacher->isStudent();
            $shouldHideInteraction = $isViewerTeacher && $isProfileStudent;
        @endphp

        @if($teacher->userSkills()->where('type', $teacher->isTeacher() ? 'offer' : 'request')->count() > 0 && !$shouldHideInteraction)
            <div style="margin-top: 40px; background: var(--bg-light-teal); padding: 40px; border-radius: 24px; border: 1px solid var(--primary-teal-light); text-align: center; box-shadow: 0 10px 30px rgba(32, 166, 138, 0.05);">
                <h3 style="margin-top: 0; margin-bottom: 25px; color: var(--text-slate); font-size: 1.5rem;">{{ $teacher->isTeacher() ? 'Ready to Learn from ' . $teacher->name . '?' : 'Ready to Teach ' . $teacher->name . '?' }}</h3>
                @auth
                    <form action="#" method="GET" style="display: flex; gap: 15px; max-width: 650px; margin: 0 auto; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 250px; position: relative;">
                            <select id="primarySkillSelect" style="width: 100%; height: 50px; padding: 0 20px; border-radius: 50px; border: 2px solid #e2e8f0; font-size: 1rem; outline: none; background: #fff; cursor: pointer; color: #475569; appearance: none;">
                                <option value="" disabled selected>-- Select a Skill --</option>
                                @foreach($teacher->userSkills()->where('type', $teacher->isTeacher() ? 'offer' : 'request')->get() as $us)
                                    <option value="{{ route('requests.create', $us) }}">{{ $us->skill->title }}</option>
                                @endforeach
                            </select>
                            <span style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #94a3b8;">▼</span>
                        </div>
                        <button type="button" onclick="const url = document.getElementById('primarySkillSelect').value; if(url) { window.location.href = url; } else { alert('Please select a skill from the dropdown first.'); }" class="btn-pill primary" style="padding: 0 40px; white-space: nowrap; height: 50px;">
                            {{ $teacher->isTeacher() ? 'Request Session' : 'Offer Session' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="btn-pill primary">Sign up to Interact</a>
                @endauth
            </div>
        @endif
    </div>

    @if($teacher->isTeacher() && $teacher->userSkills()->where('type', 'request')->exists())
        <div class="dashboard-section">
            <h2>Also Wants to Learn</h2>
            <div class="skills-grid">
                @foreach($teacher->userSkills()->where('type', 'request')->get() as $us)
                    <div class="skill-card">
                        <h4>{{ $us->skill->title ?? 'Skill' }}</h4>
                        <p>{{ Str::limit($us->skill->description ?? '', 100) }}</p>
                        <p><strong>Level:</strong> {{ ucfirst($us->level ?? 'N/A') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($teacher->isStudent() && $teacher->userSkills()->where('type', 'offer')->exists())
        <div class="dashboard-section">
            <h2>Also Offers to Teach</h2>
            <div class="skills-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                @foreach($teacher->userSkills()->where('type', 'offer')->get() as $us)
                    <div class="skill-card" style="padding: 24px; border-radius: 16px; border: 1px solid var(--primary-teal-light); background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <h4 style="color: var(--primary-teal); margin-top: 0; margin-bottom: 12px; font-size: 1.25rem;">{{ $us->skill->title ?? 'Skill' }}</h4>
                        <p style="color: #64748b; font-size: 0.95rem; line-height: 1.5; margin-bottom: 15px; height: 3em; overflow: hidden;">{{ Str::limit($us->skill->description ?? '', 80) }}</p>
                        <div style="background:var(--bg-light-teal); display:inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; color: var(--primary-teal-dark);">
                            Level: {{ ucfirst($us->level ?? 'N/A') }}
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div style="margin-top: 30px; text-align: center;">
                @auth
                    <form action="#" method="GET" style="display: inline-flex; gap: 15px; max-width: 600px; flex-wrap: wrap; justify-content: center;">
                        <div style="flex: 1; min-width: 250px; position: relative;">
                            <select id="secondarySkillSelect" style="width: 100%; height: 46px; padding: 0 20px; border-radius: 50px; border: 2px solid #e2e8f0; font-size: 0.95rem; outline: none; background: #fff; cursor: pointer; color: #475569; appearance: none;">
                                <option value="" disabled selected>-- Select a Skill to Request --</option>
                                @foreach($teacher->userSkills()->where('type', 'offer')->get() as $us)
                                    <option value="{{ route('requests.create', $us) }}">{{ $us->skill->title }}</option>
                                @endforeach
                            </select>
                            <span style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #94a3b8;">▼</span>
                        </div>
                        <button type="button" onclick="const url = document.getElementById('secondarySkillSelect').value; if(url) { window.location.href = url; } else { alert('Please select a skill from the dropdown first.'); }" class="btn-pill secondary" style="padding: 0 30px; height: 46px;">
                            Request Skill
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    @endif

    @if(isset($canViewResources) && $canViewResources === true)
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
    @elseif(isset($canViewResources) && $canViewResources === 'premium_required')
        <div class="dashboard-section">
            <h2>Resources</h2>
            <div style="background: rgba(32,166,138,0.1); padding: 30px; border-radius: 12px; text-align: center; border: 1px dashed var(--primary-teal);">
                <h3 style="color: var(--primary-teal);"><i class="fas fa-crown"></i> Premium Feature</h3>
                <p>This teacher has shared resources with you, but you need a premium subscription to access them.</p>
                <a href="{{ route('premium.index') }}" class="btn-pill primary" style="margin-top: 15px; display: inline-block;">Get Premium</a>
            </div>
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
                    <div class="review-card" style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid var(--primary-teal-light); box-shadow: 0 5px 15px rgba(0,0,0,0.02);">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem;">
                            <div style="display:flex; align-items:center; gap: 1rem;">
                                <img src="{{ $review->author->avatar ?? 'https://via.placeholder.com/40' }}" alt="{{ $review->author->name }}" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-teal-light);">
                                <div>
                                    <h4 style="margin:0; color: var(--text-dark); font-weight: 700;">{{ $review->author->name }}</h4>
                                    <small style="color: var(--text-secondary);">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div style="color:var(--primary-teal); font-size:1.1rem; letter-spacing: 2px;">
                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </div>
                        </div>
                        @if($review->comment)
                            <p style="margin:0; color: var(--text-dark); line-height: 1.6; font-style: italic;">"{{ $review->comment }}"</p>
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
