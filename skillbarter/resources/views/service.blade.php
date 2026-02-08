@extends('app')

@section('content')

<!-- HERO / BANNER -->
<section class="services-hero">
  <div class="container">
    <div class="hero-inner">
      <div class="hero-text">
        <div class="kicker">Our Services</div>
        <h1>Everything You Need to Master New Skills</h1>
        <p class="muted">Discover a comprehensive suite of services designed to make skill exchange seamless, effective, and enjoyable for everyone — students, tutors, and campus organizers.</p>
        <div class="hero-ctas">
          <a href="{{ url('/find-skill') }}" class="btn primary">Browse Skills</a>
          <a href="{{ url('/signup') }}" class="btn ghost">Join Now</a>
        </div>
      </div>

      <div class="hero-media">
        <img src="{{ asset('https://www.altamira.ai/wp-content/uploads/2022/05/skill-sharing.jpg') }}" alt="Students sharing skills">
      </div>
    </div>
  </div>
</section>

<!-- SERVICE CARDS -->
<section class="services-cards">
  <div class="container">
    <div class="cards-grid">
      <div class="service-card">
        <img src="{{ asset('images/services/icon-lesson.png') }}" alt="One-on-one">
        <h3>One-on-One Sessions</h3>
        <p>Personalized tutoring sessions for focused, hands-on learning with schedule flexibility.</p>
      </div>

      <div class="service-card">
        <img src="{{ asset('images/services/icon-workshop.png') }}" alt="Workshops">
        <h3>Workshops & Events</h3>
        <p>Organize group workshops and campus events to teach practical skills at scale.</p>
      </div>

      <div class="service-card">
        <img src="{{ asset('images/services/icon-match.png') }}" alt="Smart matching">
        <h3>Smart Matching</h3>
        <p>Intelligent matching suggests peers who have complementary skills and availability.</p>
      </div>

      <div class="service-card">
        <img src="{{ asset('images/services/icon-cert.png') }}" alt="Badges">
        <h3>Badges & Rewards</h3>
        <p>Earn badges and points for teaching, hosting events, and contributing to the community.</p>
      </div>

      <div class="service-card">
        <img src="{{ asset('images/services/icon-resources.png') }}" alt="Resources">
        <h3>Learning Resources</h3>
        <p>Access curated materials — slides, templates, starter projects, and recordings.</p>
      </div>

      <div class="service-card">
        <img src="{{ asset('images/services/icon-support.png') }}" alt="Support">
        <h3>Mentor Support</h3>
        <p>Find experienced mentors for longer-term guidance and portfolio reviews.</p>
      </div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="service-categories">
  <div class="container">
    <h2>Explore Skills Across Multiple Categories</h2>
    <p class="muted">From technology to arts, find short sessions and workshops that match your goals.</p>

    <div class="categories-grid">
      <a href="{{ url('/skills/technology') }}" class="category-btn">Technology</a>
      <a href="{{ url('/skills/design') }}" class="category-btn">Design & Figma</a>
      <a href="{{ url('/skills/business') }}" class="category-btn">Business</a>
      <a href="{{ url('/skills/language') }}" class="category-btn">Language</a>
      <a href="{{ url('/skills/writing') }}" class="category-btn">Writing</a>
      <a href="{{ url('/skills/marketing') }}" class="category-btn">Marketing</a>
    </div>
  </div>
</section>

<!-- HOW OUR SERVICE WORKS -->
<section class="service-how">
  <div class="container two-col">
    <div class="how-list">
      <h2>How Our Service Works</h2>
      <ol>
        <li><strong>Profile Creation</strong> — Build a clear profile with skills and availability.</li>
        <li><strong>Smart Matching</strong> — Get matched with peers who share learning goals.</li>
        <li><strong>Schedule & Learn</strong> — Book micro-sessions or join workshops.</li>
        <li><strong>Earn & Share</strong> — Earn badges and share feedback to grow your reputation.</li>
      </ol>
    </div>
    <div class="how-image">
      <img src="{{ asset('https://www.udpglobal.com/wp-content/uploads/2024/09/ENTRADAS_BLOG_1_Main_Image-1-1.png') }}" alt="Team teaching">
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<section class="service-cta">
  <div class="container">
    <h3>Ready to experience our services?</h3>
    <p class="muted">Join thousands of learners who already benefit from our community-driven platform.</p>
    <a class="btn primary large" href="{{ url('/signup') }}">Get Started Today</a>
  </div>
</section>

<p class="muted">
    We currently support {{ $serviceCount }} different skill categories.
</p>


@endsection
