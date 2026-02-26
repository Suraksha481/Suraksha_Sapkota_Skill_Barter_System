@extends('layouts.app')

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
