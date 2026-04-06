@extends('app')

@section('page_title', 'About Us - SkillSwap')

@section('content')

<style>
.about-hero-v2 {
    background: #75dcc5; /* Solid vibrant teal for better clarity */
    padding: 100px 5%;
    text-align: center;
    color: #fff;
    border-radius: 0 0 50px 50px;
}
.about-hero-v2 h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -2px; }
.about-hero-v2 p { font-size: 1.2rem; opacity: 0.9; max-width: 700px; margin: 0 auto; }

.about-section-v2 { padding: 100px 5%; display: flex; align-items: center; gap: 80px; }
.about-img-v2 { flex: 1; border-radius: 40px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.1); }
.about-img-v2 img { width: 100%; display: block; }
.about-text-v2 { flex: 1.2; }
.about-text-v2 h2 { font-size: 2.8rem; margin-bottom: 30px; line-height: 1.2; }
.about-text-v2 p { font-size: 1.1rem; color: #666; line-height: 1.8; margin-bottom: 25px; }

.values-grid-v2 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    padding: 100px 5%;
    background: var(--bg-light-teal);
}
.value-card-v2 {
    background: #fff;
    padding: 50px 40px;
    border-radius: 30px;
    transition: transform 0.3s;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
}
.value-card-v2:hover { transform: translateY(-10px); }
.value-card-v2 .icon { font-size: 3rem; margin-bottom: 25px; display: block; }
.value-card-v2 h3 { font-size: 1.5rem; margin-bottom: 15px; }
.value-card-v2 p { color: #888; line-height: 1.6; }

@media (max-width: 992px) {
    .about-section-v2 { flex-direction: column; text-align: center; }
    .values-grid-v2 { grid-template-columns: 1fr; }
}
</style>

<section class="about-hero-v2">
    <h1>Our Story</h1>
    <p>We are a community of passionate learners and mentors dedicated to making knowledge accessible to everyone through peer-to-peer exchange.</p>
</section>

<section class="about-section-v2">
    <div class="about-text-v2">
        <span class="badge-teal">WHO WE ARE</span>
        <h2>Connecting people through the power of shared <span class="text-teal">skills</span>.</h2>
        <p>SkillSwap was born out of a simple idea: that everyone has a talent to share and something new they want to learn. We've built a platform that removes the financial barriers to education.</p>
        <p>Whether you're a professional designer looking to learn coding, or a student wanting to master a new language, our community provides the perfect environment for mutual growth.</p>
        <div style="margin-top: 40px;">
            <a href="{{ route('register') }}" class="btn-pill primary">Join Our Community</a>
        </div>
    </div>
    <div class="about-img-v2">
        <img src="{{ asset('images/home_redesign/expert_mentor.png') }}" alt="About our team">
    </div>
</section>

<section class="values-grid-v2">
    <div class="value-card-v2">

        <h3>Community First</h3>
        <p>We believe in the strength of collective knowledge and supporting each other's journeys.</p>
    </div>
    <div class="value-card-v2">

        <h3>Continuous Growth</h3>
        <p>Learning never stops. We provide the tools and connections for lifelong improvement.</p>
    </div>
    <div class="value-card-v2">

        <h3>Quality Exchange</h3>
        <p>We maintain a high standard of peer-to-peer mentoring through verified reviews and badges.</p>
    </div>
</section>

@endsection
