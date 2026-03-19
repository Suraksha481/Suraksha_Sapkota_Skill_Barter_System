@extends('app')

@section('page_title', 'Home')

@section('content')

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <h1>Exchange Knowledge. Empower Students.</h1>
        <p>
            Teach what you know, learn what you want, and grow together.
            Micro-sessions, badges, and campus communities — no money required.
        </p>

        <div class="hero-buttons">
            <a href="{{ url('/find-skill') }}" class="btn ghost large">Browse Skills</a>
            <a href="{{ route('register') }}" class="btn primary large">Get Started Free</a>
        </div>
    </div>

    <div class="hero-image">
        <img src="https://securitydelta.nl/media/com_hsd/newsitem/2544/image/signal-2024-04-26-102854.jpeg"
             alt="Students sharing skills">
    </div>
</section>

@auth
    @if(auth()->user()->isStudent())
        <!-- STUDENT PREMIUM DASHBOARD -->
        <section class="role-dashboard student-dashboard premium-theme">
            <div class="container">
                <div class="row align-items-center mb-5">
                    <div class="col-md-8">
                        <h2 class="display-5 fw-bold">Welcome back, <span class="text-primary">{{ auth()->user()->name }}</span>!</h2>
                        <p class="lead text-muted">Continue mastering your skills and unlocking your potential.</p>
                    </div>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="dashboard-card main-card">
                            <div class="card-header-premium">
                                <h3>📚 Enrolled Skills</h3>
                                <a href="{{ route('find-skill') }}" class="btn-link">Browse more</a>
                            </div>
                            <div class="card-list">
                                @forelse($enrolledSkills as $skill)
                                    <div class="list-item-premium">
                                        <div class="skill-main">
                                            <div class="skill-icon">✨</div>
                                            <div class="skill-text">
                                                <span class="skill-title-text">{{ $skill->title }}</span>
                                                <small class="text-muted">{{ $skill->category }}</small>
                                            </div>
                                        </div>
                                        <a href="{{ route('student.skill-progress', $skill->id) }}" class="btn btn-outline-dark btn-sm rounded-pill">View Path</a>
                                    </div>
                                @empty
                                    <div class="empty-state-card">
                                        <p>You haven't enrolled in any skills yet.</p>
                                        <a href="{{ route('find-skill') }}" class="btn btn-primary px-4 rounded-pill">Explore Skills</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="dashboard-card side-card">
                            <div class="card-header-premium">
                                <h3>🔔 Recent Status</h3>
                            </div>
                            <div class="card-list">
                                @forelse($recentRequests as $req)
                                    <div class="list-item-premium">
                                        <div class="skill-text">
                                            <span class="skill-title-text">{{ $req->skill->title ?? 'Deleted Skill' }}</span>
                                            <span class="status-badge-premium {{ $req->status }}">{{ ucfirst($req->status) }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center py-4 text-muted">No recent requests.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @elseif(auth()->user()->isTeacher())
        <!-- TEACHER PREMIUM DASHBOARD -->
        <section class="role-dashboard teacher-dashboard premium-theme">
            <div class="container">
                <div class="row align-items-center mb-5">
                    <div class="col-md-8">
                        <h2 class="display-5 fw-bold">Hello, <span class="text-success">Mentor {{ auth()->user()->name }}</span></h2>
                        <p class="lead text-muted">Your expertise is making a difference today.</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="dashboard-card main-card">
                            <div class="card-header-premium">
                                <h3>🎓 My Expertise</h3>
                                <a href="{{ route('my.skills') }}" class="btn-link">Manage Skills</a>
                            </div>
                            <div class="card-list">
                                @forelse($teachingSkills as $skill)
                                    <div class="list-item-premium">
                                        <div class="skill-main">
                                            <div class="skill-icon text-success">✔</div>
                                            <div class="skill-text">
                                                <span class="skill-title-text">{{ $skill->title }}</span>
                                                <small class="text-muted">Currently teaching</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Active</span>
                                    </div>
                                @empty
                                    <div class="empty-state-card">
                                        <p>You haven't listed any skills to teach yet.</p>
                                        <a href="{{ route('my.skills') }}" class="btn btn-success px-4 rounded-pill">Start Teaching</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="dashboard-card side-card">
                            <div class="card-header-premium">
                                <h3>📥 Interaction Requests</h3>
                            </div>
                            <div class="card-list">
                                @forelse($pendingRequests as $req)
                                    <div class="list-item-premium">
                                        <div class="skill-text">
                                            <span class="skill-title-text">From: {{ $req->requester->name ?? 'User' }}</span>
                                            <small class="d-block text-muted">For: {{ $req->skill->title ?? 'Skill' }}</small>
                                        </div>
                                        <a href="{{ route('requests.index') }}" class="btn btn-primary btn-sm rounded-pill">Review</a>
                                    </div>
                                @empty
                                    <p class="text-center py-4 text-muted">No pending requests.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endauth

<style>
    .premium-theme { padding: 5rem 0; background: #fff; }
    .dashboard-card { 
        background: #fff; 
        border: 1px solid #f0f0f0; 
        border-radius: 24px; 
        padding: 2rem; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.02); 
        height: 100%;
        transition: transform 0.3s;
    }
    .dashboard-card:hover { transform: translateY(-5px); }
    
    .card-header-premium { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .card-header-premium h3 { font-weight: 900; font-size: 1.5rem; margin: 0; letter-spacing: -0.5px; }
    
    .list-item-premium { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        padding: 1.5rem 0; 
        border-bottom: 1px solid #f8f8f8; 
    }
    .list-item-premium:last-child { border-bottom: none; }
    
    .skill-main { display: flex; align-items: center; gap: 1rem; }
    .skill-icon { width: 45px; height: 45px; background: #f0f7ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .skill-title-text { font-weight: 800; color: #1a1a1a; display: block; font-size: 1.1rem; }
    
    .status-badge-premium { padding: 6px 14px; border-radius: 100px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; }
    .status-badge-premium.pending { background: #fff4e6; color: #d9480f; }
    .status-badge-premium.accepted { background: #ebfbee; color: #2b8a3e; }
    .status-badge-premium.completed { background: #e7f5ff; color: #1971c2; }
    
    .empty-state-card { text-align: center; padding: 3rem 0; }
    .empty-state-card p { color: #666; margin-bottom: 1.5rem; }
    
    .btn-link { color: #000; font-weight: 800; text-decoration: underline; font-size: 0.9rem; }
</style>

<section class="how-it-works">
    <h2>How it Works</h2>

    <div class="steps-grid">

        <a href="{{ route('register') }}" class="step clickable">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f">
            <h3>1. Register</h3>
            <p>Create your account and profile.</p>
        </a>

        <a href="{{ route('my.skills') }}" class="step clickable">
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d">
            <h3>2. Add Skills</h3>
            <p>Add skills you want to teach or learn.</p>
        </a>

        <a href="{{ route('find-skill') }}" class="step clickable">
            <img src="https://images.unsplash.com/photo-1542744173-05336fcc7ad4">
            <h3>3. Match & Connect</h3>
            <p>Find people who match your skills.</p>
        </a>

        <a href="{{ route('dashboard') }}" class="step clickable">
            <img src="https://www.teachaway.com/wp-content/uploads/2020/12/teachkidsenglishonline28.jpg">
            <h3>4. Teach & Rate</h3>
            <p>Teach, learn, and give feedback.</p>
        </a>

    </div>
</section>

<!-- PLATFORM STATS (DYNAMIC) -->
<section class="platform-stats">
    <div class="steps-grid">
        <div class="step">
            <h3>{{ $totalUsers }}+</h3>
            <p>Active Users</p>
        </div>

        <div class="step">
            <h3>{{ $totalSkills }}+</h3>
            <p>Skills Shared</p>
        </div>

        <div class="step">
            <h3>100%</h3>
            <p>Free Learning</p>
        </div>
    </div>
</section>

<!-- TRENDING SKILLS (STATIC – EDITOR PICKS) -->
<section class="popular-skills">
    <h2>Trending Skills</h2>

    <div class="skills-layout">

        <a href="{{ route('skill.show', 1) }}" class="skill">
            <img src="https://blog.udemy.com/wp-content/uploads/2022/01/GettyImages-1221204861_w1-scaled.jpg"
                 alt="Python">
            <h3>Python</h3>
            <p>Learn the world’s most popular programming language with practical micro-lessons.</p>
        </a>

        <a href="{{ route('skill.show', 2) }}" class="skill">
            <img src="https://generalassemb.ly/wp-content/uploads/2024/10/AdobeStock_334624196-1-scaled.jpeg"
                 alt="Figma">
            <h3>Figma</h3>
            <p>Design like a pro and collaborate with peers through hands-on projects.</p>
        </a>

        <a href="{{ route('skill.show', 3) }}" class="skill">
            <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=400"
                 alt="Public Speaking">
            <h3>Public Speaking</h3>
            <p>Improve communication skills with live practice sessions and feedback.</p>
        </a>

    </div>
</section>


<!-- POPULAR SKILLS (DYNAMIC FROM DATABASE) -->
<section class="popular-skills">
    <h2>Popular Skills</h2>

    <div class="skills-layout">
        @forelse($popularSkills as $skill)
            <a href="{{ route('skill.show', $skill->id) }}" class="skill">
                <img src="https://via.placeholder.com/300x200?text={{ urlencode($skill->title) }}"
                     alt="{{ $skill->title }}">
                <h3>{{ $skill->title }}</h3>
                <p>{{ Str::limit($skill->description, 80) }}</p>
            </a>
        @empty
            <p>No skills available yet.</p>
        @endforelse
    </div>
</section>


<!-- TESTIMONIALS -->
<section class="testimonials">
    <h2>What Students Say</h2>

    <div class="testimonial-grid">
        <div class="testimonial-card">
            <img src="https://i.pravatar.cc/100?img=12" alt="User">
            <p>“SkillBarter helped me learn Figma quickly — practical, short lessons with helpful teachers.”</p>
            <h4>Bishal, University</h4>
        </div>

        <div class="testimonial-card">
            <img src="https://i.pravatar.cc/100?img=5" alt="User">
            <p>“I earned my first star after teaching 5 sessions — motivates me to keep helping others.”</p>
            <h4>Suru, MIT</h4>
        </div>

        <div class="testimonial-card">
            <img src="https://i.pravatar.cc/100?img=8" alt="User">
            <p>“Perfect for busy students. No payment, just genuine peer learning.”</p>
            <h4>Ganesh, Stanford</h4>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="service-cta">
    <div class="container">
        <h3>Ready to experience our services?</h3>
        <p class="muted">
            Join thousands of learners who already benefit from our community-driven platform.
        </p>
        <a class="btn primary large" href="{{ route('register') }}">
            Get Started Today
        </a>
    </div>
</section>

@endsection
