@extends('app')

@section('page_title', 'Our Services - SkillSwap')

@section('content')

<style>
.services-hero-v2 {
    padding: 120px 5% 80px;
    background: #fff;
}
.services-hero-v2 .container { display: flex; align-items: center; gap: 80px; }
.srv-hero-text { flex: 1.2; }
.srv-hero-text h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 25px; line-height: 1.1; letter-spacing: -2px; }
.srv-hero-text p { font-size: 1.2rem; color: #666; margin-bottom: 40px; }
.srv-hero-img { flex: 1; border-radius: 40% 60% 30% 70% / 60% 30% 70% 40%; overflow: hidden; box-shadow: 0 40px 80px rgba(0,0,0,0.1); }
.srv-hero-img img { width: 100%; display: block; }

.services-grid-v2 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
    margin: 80px 0;
    box-shadow: 0 20px 60px rgba(0,0,0,0.05);
}
.srv-card-v2 {
    background: #fff;
    padding: 60px 40px;
    border-right: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
    text-align: center;
    transition: all 0.3s;
}
.srv-card-v2:hover { background: var(--bg-light-teal); transform: scale(1.02); z-index: 2; border-color: transparent; box-shadow: 0 20px 40px rgba(32, 166, 138, 0.1); }
.srv-card-v2 .icon { font-size: 3rem; margin-bottom: 25px; display: block; }
.srv-card-v2 h3 { font-size: 1.4rem; margin-bottom: 15px; }
.srv-card-v2 p { color: #888; font-size: 0.95rem; line-height: 1.6; }

.categories-v2 { background: var(--bg-light-teal); padding: 100px 5%; text-align: center; }
.cat-list-v2 { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; margin-top: 40px; }
.cat-tag-v2 {
    background: var(--primary-teal);
    padding: 12px 30px;
    border-radius: 50px;
    color: #fff;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
    box-shadow: 0 5px 15px rgba(32,166,138,0.2);
}
.cat-tag-v2:hover { background: var(--primary-teal-dark); color: #fff; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(32,166,138,0.3); }

@media (max-width: 992px) {
    .services-hero-v2 .container { flex-direction: column; text-align: center; }
    .services-grid-v2 { grid-template-columns: 1fr; }
}
</style>

<section class="services-hero-v2">
    <div class="container">
        <div class="srv-hero-text">
            <span class="badge-teal">OUR SERVICES</span>
            <h1>Everything you need to <span class="text-teal">master</span> new skills.</h1>
            <p>Discover a comprehensive suite of services designed to make skill exchange seamless, effective, and enjoyable for everyone.</p>
            <div class="hero-btns">
                <a href="{{ url('/find-skill') }}" class="btn-pill primary">Browse All Skills</a>
            </div>
        </div>
        <div class="srv-hero-img">
            <img src="{{ asset('images/home_redesign/hero_students.png') }}" alt="Services Hero">
        </div>
    </div>
</section>

<section class="container">
    <div class="services-grid-v2">
        <div class="srv-card-v2">
            <span class="icon">👤</span>
            <h3>1-on-1 Sessions</h3>
            <p>Personalized tutoring sessions for focused, hands-on learning with schedule flexibility.</p>
        </div>
        <div class="srv-card-v2">
            <span class="icon">🏛️</span>
            <h3>Campus Workshops</h3>
            <p>Organize group workshops and campus events to teach practical skills at scale.</p>
        </div>
        <div class="srv-card-v2">
            <span class="icon">🧠</span>
            <h3>Smart Matching</h3>
            <p>Intelligent matching suggests peers who have complementary skills and availability.</p>
        </div>
        <div class="srv-card-v2">
            <span class="icon">🏅</span>
            <h3>Badges & Rewards</h3>
            <p>Earn badges and points for teaching and contributing to the community.</p>
        </div>
        <div class="srv-card-v2">
            <span class="icon">📚</span>
            <h3>Learning Resources</h3>
            <p>Access curated materials — slides, templates, and starter projects.</p>
        </div>
        <div class="srv-card-v2">
            <span class="icon">👨‍🏫</span>
            <h3>Mentor Support</h3>
            <p>Find experienced mentors for longer-term guidance and portfolio reviews.</p>
        </div>
    </div>
</section>

<section class="categories-v2">
    <span class="badge-teal">CATEGORIES</span>
    <h2>Explore skills across many fields</h2>
    <div class="cat-list-v2">
        @foreach(['Technology', 'Design', 'Business', 'Language', 'Soft Skills', 'Marketing', 'Data'] as $cat)
            <a href="{{ route('find-skill', ['category' => $cat]) }}" class="cat-tag-v2">{{ $cat }}</a>
        @endforeach
    </div>
</section>

<div class="cta-box container">
    <div>
        <span class="text-teal">Ready?</span>
        <h2>Start your own learning journey</h2>
    </div>
    <a href="{{ route('register') }}" class="btn-pill primary" style="padding: 15px 40px;">Get Started Now</a>
</div>

@endsection
