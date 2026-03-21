@extends('app')

@section('page_title', 'Home - SkillSwap')

@section('content')

<style>
/* ============================================
   GLOBAL UTILITIES FOR HOME
   ============================================ */
:root {
    --primary-teal: #20a68a;
    --primary-teal-dark: #157e6a;
    --primary-teal-light: #e9f7f4;
    --text-slate: #2d3e50;
    --bg-light-teal: #f4fbf9;
}

.home-section { padding: 80px 5%; overflow: hidden; }
.container { max-width: 1200px; margin: 0 auto; }
.text-teal { color: var(--primary-teal); }
.badge-teal { background: var(--primary-teal-light); color: var(--primary-teal); padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-block; margin-bottom: 20px; }

/* ============================================
   HERO SECTION
   ============================================ */
.hero-v2 {
    display: flex;
    align-items: center;
    min-height: 80vh;
    gap: 40px;
    background: #fff;
    padding: 40px 5% 100px;
}

.hero-text { flex: 1; text-align: left !important; display: flex; flex-direction: column; align-items: flex-start; justify-content: center; }
.hero-text h1 { font-size: 4rem; line-height: 1.15; margin-bottom: 25px; font-weight: 800; color: var(--text-slate); letter-spacing: -2px; text-align: left !important; margin-left: 0; padding-left: 0; width: 100%; }
.hero-text p { font-size: 1.1rem; color: #666; margin-bottom: 40px; max-width: 500px; text-align: left !important; margin-left: 0; padding-left: 0; }
.hero-btns { display: flex; align-items: center; justify-content: flex-start; width: 100%; }

.hero-images { flex: 1; position: relative; height: 500px; }
.hero-img-top {
    position: absolute;
    top: 0;
    right: 0;
    width: 80%;
    height: 350px;
    border-radius: 40% 60% 70% 30% / 40% 50% 60% 40%;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.1);
}
.hero-img-bottom {
    position: absolute;
    bottom: -20px;
    left: 0;
    width: 70%;
    height: 300px;
    border-radius: 60% 40% 30% 70% / 50% 40% 70% 60%;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.1);
    border: 15px solid #fff;
}
.hero-images img { width: 100%; height: 100%; object-fit: cover; }

/* = = = FEATURE CARDS (Overlapping Hero) = = = */
.features-overlap {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    margin-top: -80px;
    position: relative;
    z-index: 10;
    box-shadow: 0 20px 50px rgba(0,0,0,0.05);
}
.feat-card {
    background: #fff;
    padding: 40px;
    border-right: 1px solid #f0f0f0;
}
.feat-card:first-child { background: linear-gradient(135deg, var(--primary-teal), var(--primary-teal-dark)); color: #fff; border:none; }
.feat-card h3 { font-size: 1.4rem; margin-bottom: 15px; color: inherit; }
.feat-card p { font-size: 0.9rem; color: inherit; opacity: 0.8; }
.feat-card .icon { font-size: 2rem; margin-bottom: 20px; color: var(--primary-teal); }
.feat-card:first-child .icon { color: #fff; }

/* ============================================
   ABOUT SECTION
   ============================================ */
.about-v2 { display: flex; align-items: center; gap: 80px; background: var(--bg-light-teal); }
.about-image { flex: 1; border-radius: 30px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
.about-image img { width: 100%; display: block; }
.about-content { flex: 1; }
.about-content h2 { font-size: 2.8rem; line-height: 1.2; margin-bottom: 25px; letter-spacing: -1px; }

.about-icons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-top: 40px;
}
.about-icon-item { display: flex; align-items: center; gap: 15px; }
.icon-circle { width: 45px; height: 45px; border-radius: 50%; background: var(--primary-teal); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }

/* ============================================
   PROCESS SECTION
   ============================================ */
.process-grid { display: flex; align-items: center; gap: 60px; }
.process-steps { flex: 1; }
.process-step { display: flex; gap: 30px; margin-bottom: 40px; }
.step-num { font-size: 3rem; font-weight: 800; color: rgba(32, 166, 138, 0.15); line-height: 1; }
.step-info h4 { font-size: 1.3rem; margin-bottom: 10px; }
.process-img { flex: 1; border-radius: 50% 50% 50% 70% / 50% 50% 50% 30%; overflow: hidden; }

/* ============================================
   PROJECTS (SKILLS) SECTION
   ============================================ */
.projects-header { text-align: center; margin-bottom: 60px; }
.projects-header h2 { font-size: 2.5rem; }
.projects-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}
.project-card { border-radius: 20px; overflow: hidden; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s; }
.project-card:hover { transform: translateY(-10px); }
.project-img { height: 350px; overflow: hidden; }
.project-img img { width: 100%; height: 100%; object-fit: cover; }
.project-info { padding: 30px; text-align: center; }

/* ============================================
   TESTIMONIALS
   ============================================ */
.testimonials-v2 { background: var(--bg-light-teal); text-align: center; }
.testimonial-box {
    max-width: 800px;
    margin: 0 auto;
    background: #fff;
    padding: 60px;
    border-radius: 30px;
    position: relative;
    box-shadow: 0 20px 50px rgba(0,0,0,0.05);
}
.testimonial-box .quote-icon { font-size: 4rem; color: var(--primary-teal); opacity: 0.2; position: absolute; top: 20px; left: 40px; }
.testimonial-box p { font-size: 1.5rem; font-style: italic; color: var(--text-slate); margin-bottom: 30px; }
.tester-info { display: flex; align-items: center; justify-content: center; gap: 15px; }
.tester-img { width: 50px; height: 50px; border-radius: 50%; overflow: hidden; }

/* ============================================
   CTA BOX
   ============================================ */
.cta-box {
    background: #fff;
    margin: 80px 5%;
    padding: 60px;
    border-radius: 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 30px 70px rgba(0,0,0,0.08);
}
.cta-box h2 { margin: 0; font-size: 2rem; }

@media (max-width: 992px) {
    .hero-v2, .about-v2, .process-grid { flex-direction: column; }
    .features-overlap, .projects-grid { grid-template-columns: 1fr; }
    .hero-text { text-align: left !important; align-items: flex-start; }
    .hero-images { width: 100%; height: 400px; margin-top: 40px; }
    .cta-box { flex-direction: column; text-align: center; gap: 30px; border-radius: 30px; }
}
</style>

<!-- HERO -->
@guest
<section class="hero-v2">
    <div class="hero-text">
        <span class="badge-teal" style="align-self: flex-start;">SKILL EXCHANGE PLATFORM</span>
        <h1>We help learners <br> expand their <span class="text-teal">skills</span> & grow.</h1>
        <p>Connect with mentors, share your knowledge, and build your portfolio through a community-driven barter system. No money, just pure learning.</p>
        <div class="hero-btns">
            <a href="{{ route('register') }}" class="btn-pill primary" style="padding: 16px 35px; font-size: 1.05rem;">Get started now</a>
            <a href="{{ url('/find-skill') }}" class="btn-pill secondary" style="margin-left: 15px; padding: 16px 35px; font-size: 1.05rem; border: 2px solid var(--primary-teal);">View all skills</a>
        </div>
    </div>
    <div class="hero-images">
        <div class="hero-img-top">
            <img src="{{ asset('images/home_redesign/hero_students.png') }}" alt="Students collaborating">
        </div>
        <div class="hero-img-bottom">
            <img src="{{ asset('images/home_redesign/sharing_skills.png') }}" alt="Sharing skills">
        </div>
    </div>
</section>
@endguest

@auth
    @if(auth()->user()->role === 'teacher')
        <section class="hero-v2" style="min-height: 50vh; padding-bottom: 50px;">
            <div class="hero-text">
                <span class="badge-teal" style="align-self: flex-start;">TEACHER PORTAL</span>
                <h1>Welcome Back, <span class="text-teal">{{ auth()->user()->name }}</span>!</h1>
                <p style="font-size: 1.15rem; color: #555;">Ready to shape minds today? Review your latest student requests and manage your active classes directly from your dashboard.</p>
                <div class="hero-btns">
                    <a href="{{ route('dashboard') }}" class="btn-pill primary" style="padding: 16px 35px; font-size: 1.05rem; box-shadow: 0 10px 20px rgba(32, 166, 138, 0.2);">Go to Dashboard</a>
                </div>
            </div>
            <div class="hero-images">
                 <img src="{{ asset('images/home_redesign/expert_mentor.png') }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 40px; border: 12px solid #fff; box-shadow: 0 20px 50px rgba(0,0,0,0.1);" alt="Teacher Portal">
            </div>
        </section>
    @else
        <section class="hero-v2" style="min-height: 50vh; padding-bottom: 50px;">
            <div class="hero-text">
                <span class="badge-teal" style="align-self: flex-start;">STUDENT PORTAL</span>
                <h1>Ready to learn, <span class="text-teal">{{ auth()->user()->name }}</span>?</h1>
                <p style="font-size: 1.15rem; color: #555;">Continue your learning journey! Discover new skills or dive back into your active matching sessions below.</p>
                <div class="hero-btns">
                    <a href="{{ route('dashboard') }}" class="btn-pill primary" style="padding: 16px 35px; font-size: 1.05rem; box-shadow: 0 10px 20px rgba(32, 166, 138, 0.2);">Learning Dashboard</a>
                    <a href="{{ url('/find-skill') }}" class="btn-pill secondary" style="margin-left: 15px; padding: 16px 35px; font-size: 1.05rem; border: 2px solid var(--primary-teal);">Explore Skills</a>
                </div>
            </div>
            <div class="hero-images">
                 <img src="{{ asset('images/home_redesign/hero_students.png') }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 40px; border: 12px solid #fff; box-shadow: 0 20px 50px rgba(0,0,0,0.1);" alt="Student Portal">
            </div>
        </section>
    @endif
@endauth

<!-- FEATURES -->
@guest
<section class="container">
    <div class="features-overlap">
        <div class="feat-card">
            <h3>Barter Your <br> Skills Today</h3>
            <p>Exchange what you know for what you want to learn.</p>
        </div>
        <div class="feat-card">
            <h3>Skill Matching</h3>
            <p>Our algorithm finds the perfect peer mentors for you.</p>
        </div>
        <div class="feat-card">
            <h3>Track Progress</h3>
            <p>Earn badges and track your learning milestones.</p>
        </div>
        <div class="feat-card" style="border-right: none;">
            <h3>Community</h3>
            <p>Join a global network of passionate lifelong learners.</p>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="home-section about-v2">
    <div class="about-image">
        <img src="{{ asset('images/home_redesign/expert_mentor.png') }}" alt="Expert Mentor">
    </div>
    <div class="about-content">
        <span class="badge-teal">ABOUT OUR COMMUNITY</span>
        <h2>We are a team of expert people with <span class="text-teal">creativity</span> ideas.</h2>
        <p>SkillSwap was founded on the belief that everyone has something valuable to teach. Our mission is to democratize education by enabling peer-to-peer knowledge exchange.</p>
        
        <div class="about-icons">
            <div class="about-icon-item">
                <div class="icon-circle">✓</div>
                <div><strong>Verified Mentors</strong><br><small>Quality learning sessions</small></div>
            </div>
            <div class="about-icon-item">
                <div class="icon-circle">✓</div>
                <div><strong>Flexible Schedule</strong><br><small>Learn at your own pace</small></div>
            </div>
            <div class="about-icon-item">
                <div class="icon-circle">✓</div>
                <div><strong>Global Reach</strong><br><small>Connect with the world</small></div>
            </div>
            <div class="about-icon-item">
                <div class="icon-circle">✓</div>
                <div><strong>Free Forever</strong><br><small>No hidden costs</small></div>
            </div>
        </div>
    </div>
</section>

<!-- PROCESS -->
<section class="home-section container">
    <div class="process-grid">
        <div class="process-steps">
            <span class="badge-teal">OUR PROCESS</span>
            <h2>Our barter process road</h2>
            
            <div class="process-step">
                <div class="step-num">01.</div>
                <div class="step-info">
                    <h4>Register & List Skills</h4>
                    <p>Create your profile and tell us what you can teach and what you want to learn.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-num">02.</div>
                <div class="step-info">
                    <h4>Find Your Match</h4>
                    <p>Browse the directory or let our system suggest partners with complementary skills.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-num">03.</div>
                <div class="step-info">
                    <h4>Barter & Learn</h4>
                    <p>Connect via chat, schedule a session, and start your mutual learning journey.</p>
                </div>
            </div>
        </div>
        <div class="process-img">
            <img src="{{ asset('images/home_redesign/hero_students.png') }}" style="width: 100%; height: 500px; object-fit: cover;" alt="Process">
        </div>
    </div>
</section>
@endguest

<!-- TRENDING SKILLS -->
<section class="home-section">
    <div class="projects-header">
        <span class="badge-teal">TRENDING SKILLS</span>
        <h2>Our recent creative projects</h2>
    </div>
    
    <div class="container projects-grid">
        @foreach($popularSkills->take(3) as $skill)
        <a href="{{ route('skill.show', $skill->id) }}" class="project-card">
            <div class="project-img">
                @if($skill->image)
                    <img src="{{ asset($skill->image) }}"
                         alt="{{ $skill->title }}"
                         onerror="this.src='https://via.placeholder.com/400x500/e9f7f4/20a68a?text={{ urlencode($skill->title) }}'">
                @else
                    <img src="{{ asset('images/skills/web_development.png') }}" alt="{{ $skill->title }}">
                @endif
            </div>
            <div class="project-info">
                <h3>{{ $skill->title }}</h3>
                <p>{{ $skill->category }}</p>
            </div>
        </a>
        @endforeach
    </div>
    
    <div style="text-align: center; margin-top: 50px;">
        <a href="{{ url('/find-skill') }}" class="btn-pill primary">More creative skills</a>
    </div>
</section>

<!-- TESTIMONIALS -->
@guest
<section class="home-section testimonials-v2">
    <div class="testimonial-box">
        <div class="quote-icon">"</div>
        <p>“SkillSwap helped me learn Figma quickly — practical, short lessons with helpful teachers. I earned my first star after teaching 5 sessions!”</p>
        <div class="tester-info">
            <div class="tester-img">
                <img src="https://i.pravatar.cc/100?img=12" style="width:100%;" alt="User">
            </div>
            <div style="text-align: left;">
                <strong style="display:block;">Bishal Sharma</strong>
                <small style="color:var(--primary-teal);">UI/UX Student</small>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<div class="cta-box">
    <div>
        <span class="text-teal" style="font-weight:700;">Ready?</span>
        <h2>Start your own learning journey</h2>
    </div>
    <a href="{{ route('register') }}" class="btn-pill primary" style="padding: 15px 40px;">Get Started Now</a>
</div>
@endguest

@endsection
