@extends('app')

@section('page_title', $skill->title . ' - Skill Details')

@section('content')

@php $isAdded = auth()->check() ? auth()->user()->skills->contains($skill->id) : false; @endphp

<style>
    .skill-detail-v2 {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 5%;
    }

    .skill-hero-v2 {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 80px;
        align-items: center;
        margin-bottom: 80px;
    }

    .skill-hero-v2 h1 { font-size: 4rem; font-weight: 800; margin-bottom: 20px; line-height: 1.1; letter-spacing: -2px; }
    .skill-meta-v2 { display: flex; align-items: center; gap: 20px; color: #666; font-weight: 600; margin-bottom: 40px; }
    .skill-meta-v2 .sep { color: #eee; }

    .skill-visual-v2 {
        background: var(--bg-light-teal);
        aspect-ratio: 16/10;
        border-radius: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        box-shadow: 0 30px 60px rgba(32, 166, 138, 0.1);
    }

    .tabs-v2 { border-bottom: 2px solid #f0f0f0; display: flex; gap: 40px; margin-bottom: 50px; }
    .tab-btn-v2 { background: none; border: none; padding: 20px 0; font-size: 1.1rem; font-weight: 700; color: #999; cursor: pointer; position: relative; }
    .tab-btn-v2.active { color: var(--text-slate); }
    .tab-btn-v2.active::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 3px; background: var(--primary-teal); }

    .tab-content-v2 { display: none; animation: fadeIn 0.5s ease; }
    .tab-content-v2.active { display: block; }

    .teacher-grid-v2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; }
    .teacher-card-v2 {
        display: flex;
        gap: 25px;
        padding: 30px;
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 30px;
        transition: 0.3s;
    }
    .teacher-card-v2:hover { border-color: var(--primary-teal); box-shadow: 0 15px 30px rgba(32, 166, 138, 0.05); }
    .teacher-avatar-v2 { width: 80px; height: 80px; border-radius: 20px; object-fit: cover; }
    .teacher-info-v2 h4 { font-size: 1.2rem; margin-bottom: 10px; }
    .teacher-info-v2 p { color: #888; font-size: 0.9rem; line-height: 1.5; margin-bottom: 15px; }
    .teacher-link-v2 { color: var(--primary-teal); font-weight: 700; text-decoration: none; font-size: 0.9rem; }

    /* Premium Platform Details CSS */
    .about-grid-v2 { display: grid; grid-template-columns: 1.5fr 1fr; gap: 60px; }
    .about-main-v2 h2 { font-size: 2rem; margin-bottom: 25px; font-weight: 800; letter-spacing: -0.5px; }
    .about-desc-v2 { font-size: 1.1rem; color: #555; line-height: 1.8; margin-bottom: 40px; }

    .learn-box-v2 { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 24px; padding: 35px; margin-bottom: 40px; }
    .learn-box-v2 h3 { font-size: 1.4rem; font-weight: 800; margin-bottom: 20px; }
    .learn-list-v2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; list-style: none; padding: 0; margin: 0; }
    .learn-list-v2 li { display: flex; gap: 12px; font-size: 1.05rem; color: #475569; align-items: flex-start; }
    .learn-list-v2 li svg { width: 22px; height: 22px; color: var(--primary-teal); flex-shrink: 0; margin-top: 2px; }

    .syllabus-v2 { margin-bottom: 40px; }
    .syllabus-item-v2 { border: 1px solid #f0f0f0; border-radius: 16px; margin-bottom: 15px; padding: 25px; transition: 0.3s; }
    .syllabus-item-v2:hover { border-color: var(--primary-teal-light); box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
    .syllabus-item-v2 h4 { font-size: 1.15rem; font-weight: 700; margin: 0 0 8px 0; color: var(--text-slate); }
    .syllabus-item-v2 p { margin: 0; color: #64748b; font-size: 0.95rem; line-height: 1.6; }
    .syllabus-meta { display: flex; gap: 20px; margin-top: 15px; font-size: 0.85rem; color: #94a3b8; font-weight: 600; }

    .sidebar-card-v2 { background: #fff; border: 1px solid #f0f0f0; border-radius: 20px; padding: 40px 40px; box-shadow: 0 20px 50px rgba(0,0,0,0.04); position: sticky; top: 100px;}
    .sidebar-card-v2 h3 { font-size: 1.6rem; font-weight: 900; color: #111827; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f0; letter-spacing: -0.5px; }
    .skill-info-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0; }
    .skill-info-list li { display: flex; justify-content: space-between; align-items:flex-start; padding: 20px 0; border-bottom: 1.5px dotted #e2e8f0; }
    .skill-info-list li:last-child { border-bottom: none; }
    .info-label { color: #64748b; font-weight: 600; font-size: 1rem; width: 45%; }
    .info-val { font-weight: 900; color: #1e293b; font-size: 1.05rem; text-align: left; width: 55%; line-height: 1.4; }

    .guarantee-box { margin-top: 30px; padding: 25px; background: #fff5f5; border: 1.5px dotted #fecaca; border-radius: 16px; text-align: center; }
    .guarantee-box h4 { color: #ef4444; margin: 0 0 12px 0; font-size: 1.15rem; font-weight: 900; letter-spacing: -0.5px; }
    .guarantee-box p { margin: 0; color: #b91c1c; font-size: 0.95rem; line-height: 1.6; }

    @media (max-width: 992px) {
        .skill-hero-v2 { grid-template-columns: 1fr; text-align: center; }
        .skill-meta-v2 { justify-content: center; }
        .teacher-grid-v2 { grid-template-columns: 1fr; }
        .about-grid-v2 { grid-template-columns: 1fr; }
        .learn-list-v2 { grid-template-columns: 1fr; }
    }
</style>

<div class="skill-detail-v2">
    <section class="skill-hero-v2">
        <div>
            <span class="badge-teal">{{ strtoupper($skill->category) }}</span>
            <h1>{{ $skill->title }}</h1>
            <div class="skill-meta-v2">
                <span>{{ isset($teachers) ? $teachers->count() : 0 }} Experts</span>
                <span class="sep">|</span>
                <span>4.9 Rating</span>
                <span class="sep">|</span>
                <span>Quality Verified</span>
            </div>

            <div class="hero-actions">
                @auth
                    @if($isAdded)
                        <button class="btn-pill" disabled style="background: var(--bg-light-teal); color: var(--primary-teal); border: none; cursor: not-allowed;">Already in My Skills</button>
                    @else
                        <div style="display: flex; gap: 15px; align-items: center;">
                            @php $user = auth()->user(); @endphp
                            @if($user->isTeacher() && $user->isStudent())
                                <select class="add-skill-type" style="padding: 15px; border-radius: 15px; border: 2px solid #f0f0f0; font-weight: 700; outline: none;">
                                    <option value="offer">I want to teach this</option>
                                    <option value="request">I want to learn this</option>
                                </select>
                            @endif
                            <button class="btn-pill primary add-skill-btn" data-skill-id="{{ $skill->id }}"
                                data-type="{{ ($user->isTeacher() && ! $user->isStudent()) ? 'offer' : (($user->isStudent() && ! $user->isTeacher()) ? 'request' : 'offer') }}">
                                Add to My Profile
                            </button>
                        </div>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn-pill primary">Join to Start Learning</a>
                @endauth
            </div>
        </div>
        <div class="skill-visual-v2">
            @if($skill->image)
                <img src="{{ asset($skill->image) }}"
                     alt="{{ $skill->title }}"
                     style="width:100%; height:100%; object-fit:cover; border-radius:36px;"
                     onerror="this.style.display='none'; this.parentElement.querySelector('.skill-img-fallback').style.display='flex'">
                <div class="skill-img-fallback" style="display:none; font-size:5rem; width:100%; height:100%; align-items:center; justify-content:center;">✨</div>
            @else
                <div style="display:flex; flex-direction:column; align-items:center; gap:15px;">
                    <img src="{{ asset('images/skills/web_development.png') }}"
                         alt="{{ $skill->title }}"
                         style="width:100%; height:100%; object-fit:cover; border-radius:36px;">
                </div>
            @endif
        </div>
    </section>

    <div class="tabs-v2">
        <button class="tab-btn-v2 active" onclick="showTab(event, 'tab-about')">About Skill</button>
        <button class="tab-btn-v2" onclick="showTab(event, 'tab-teachers')">Mentors ({{ isset($teachers) ? $teachers->count() : 0 }})</button>
    </div>

    <div id="tab-about" class="tab-content-v2 active">
        <div class="about-grid-v2">

            <div class="about-main-v2">
                <h2>Skill Overview</h2>
                <div class="about-desc-v2">
                    {{ $skill->description ?? 'Master the fundamentals and advanced techniques of ' . $skill->title . '. This comprehensive skill path is designed to take you from beginner to proficient, guided by top-rated mentors in our community. Whether you are looking to pivot your career or upskill, our peer-to-peer exchange ensures you get real-world, practical experience.' }}
                </div>

                <div class="learn-box-v2">
                    <h3>What you'll achieve</h3>
                    <ul class="learn-list-v2">
                        <li><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Solidify core concepts of {{ $skill->title }}</li>
                        <li><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Build real-world portfolio projects</li>
                        <li><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Learn industry-standard best practices</li>
                        <li><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> 1-on-1 personalized feedback</li>
                        <li><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Master advanced optimization techniques</li>
                        <li><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Prepare for technical interviews</li>
                    </ul>
                </div>

                <div class="syllabus-v2">
                    <h2>Learning Path Syllabus</h2>
                    <p style="color: #64748b; margin-bottom: 25px; font-size: 1.05rem;">A structured breakdown of what you can expect to cover with your mentor.</p>

                    <div class="syllabus-item-v2">
                        <h4>Phase 1: Fundamentals & Core Concepts</h4>
                        <p>Establish a strong foundation by understanding the basic terminology, tools, and theoretical principles required for {{ $skill->title }}. You will set up your environment and complete your first guided exercise.</p>
                        <div class="syllabus-meta">
                            <span>3 Modules</span>
                            <span>Est. 2 Weeks</span>
                        </div>
                    </div>

                    <div class="syllabus-item-v2">
                        <h4>Phase 2: Intermediate Techniques & Workflows</h4>
                        <p>Move beyond the basics into standard industry workflows. Learn how professionals structure their projects, handle common problems, and utilize advanced tools efficiently.</p>
                        <div class="syllabus-meta">
                            <span>4 Modules</span>
                            <span>Est. 3 Weeks</span>
                        </div>
                    </div>

                    <div class="syllabus-item-v2">
                        <h4>Phase 3: Advanced Projects & Optimization</h4>
                        <p>Apply everything you've learned to build a complex, capstone-level project. Receive intensive code/design reviews from your mentor to optimize performance, clean up architecture, and polish the final result.</p>
                        <div class="syllabus-meta">
                            <span>2 Modules</span>
                            <span>Est. 3 Weeks</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about-sidebar-v2">
                <div class="sidebar-card-v2">
                    <h3>Skill Profile</h3>
                    <ul class="skill-info-list">
                        <li>
                            <span class="info-label">Category</span>
                            <span class="info-val" style="color: var(--primary-teal)">{{ $skill->category }}</span>
                        </li>
                        <li>
                            <span class="info-label">Experience Level</span>
                            <span class="info-val">Beginner -<br>Advanced</span>
                        </li>
                        <li>
                            <span class="info-label">Prerequisites</span>
                            <span class="info-val">None Required</span>
                        </li>
                        <li>
                            <span class="info-label">Format</span>
                            <span class="info-val">1-on-1 Mentorship</span>
                        </li>
                        <li>
                            <span class="info-label">Language</span>
                            <span class="info-val">English</span>
                        </li>
                        <li>
                            <span class="info-label">Avg. Response</span>
                            <span class="info-val">&lt; 24 Hours</span>
                        </li>
                    </ul>

                    <div class="guarantee-box">
                        <h4>Satisfaction Guarantee</h4>
                        <p>Not satisfied with your mentor match? Our dispute resolution team will easily refund your Skill Tokens.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="tab-teachers" class="tab-content-v2">
        <h2 style="font-size: 2rem; margin-bottom: 30px;">Available Mentors</h2>
        @if(isset($teachers) && $teachers->isNotEmpty())
            <div class="teacher-grid-v2">
                @foreach($teachers as $teacher)
                    <div class="teacher-card-v2">
                        <img src="{{ $teacher->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($teacher->name).'&background=20a68a&color=fff' }}" alt="{{ $teacher->name }}" class="teacher-avatar-v2">
                        <div class="teacher-info-v2">
                            <h4>{{ $teacher->name }}</h4>
                            <p>{{ \Illuminate\Support\Str::limit($teacher->bio, 80) }}</p>
                            <a href="{{ route('teachers.show', $teacher) }}" class="teacher-link-v2">View Full Profile →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 0; background: var(--bg-light-teal); border-radius: 30px;">
                <p style="color: var(--primary-teal); font-weight: 700;">No mentors available for this skill yet.</p>
                <p style="color: #888;">Be the first one to teach this skill!</p>
            </div>
        @endif
    </div>
</div>

<script>
    function showTab(evt, tabId) {
        let contents = document.getElementsByClassName("tab-content-v2");
        for (let i = 0; i < contents.length; i++) {
            contents[i].classList.remove("active");
        }
        let buttons = document.getElementsByClassName("tab-btn-v2");
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("active");
        }
        document.getElementById(tabId).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>

@endsection
