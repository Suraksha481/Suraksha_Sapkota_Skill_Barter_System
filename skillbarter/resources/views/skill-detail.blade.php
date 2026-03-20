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

    @media (max-width: 992px) {
        .skill-hero-v2 { grid-template-columns: 1fr; text-align: center; }
        .skill-meta-v2 { justify-content: center; }
        .teacher-grid-v2 { grid-template-columns: 1fr; }
    }
</style>

<div class="skill-detail-v2">
    <section class="skill-hero-v2">
        <div>
            <span class="badge-teal">{{ strtoupper($skill->category) }}</span>
            <h1>{{ $skill->title }}</h1>
            <div class="skill-meta-v2">
                <span>👤 {{ isset($teachers) ? $teachers->count() : 0 }} Experts</span>
                <span class="sep">|</span>
                <span>⭐ 4.9 Rating</span>
                <span class="sep">|</span>
                <span>💎 Quality Verified</span>
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
            ✨
        </div>
    </section>

    <div class="tabs-v2">
        <button class="tab-btn-v2 active" onclick="showTab(event, 'tab-about')">About Skill</button>
        <button class="tab-btn-v2" onclick="showTab(event, 'tab-teachers')">Mentors ({{ isset($teachers) ? $teachers->count() : 0 }})</button>
    </div>

    <div id="tab-about" class="tab-content-v2 active">
        <h2 style="font-size: 2rem; margin-bottom: 30px;">Overview</h2>
        <div style="font-size: 1.2rem; color: #555; line-height: 1.8; max-width: 800px;">
            {{ $skill->description ?? 'No detailed description available for this skill yet. Join the community to learn more!' }}
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
