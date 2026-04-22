@extends('app')

@section('page_title', 'Help Center - SkillSwap')

@section('content')

<style>
.help-hero {
    background: #aad9d0;
    padding: 80px 5%;
    text-align: center;
    border-radius: 0 0 50px 50px;
}
.help-content {
    max-width: 900px;
    margin: 60px auto;
    padding: 0 5%;
}
.help-section { margin-bottom: 40px; }
.help-section h2 { color: var(--primary-teal); margin-bottom: 20px; }
.help-section p { line-height: 1.8; color: #666; }
</style>

<section class="help-hero">
    <span class="badge-teal">SUPPORT</span>
    <h1>How can we help you?</h1>
    <p>Find answers to common questions and learn how to use SkillSwap effectively.</p>
</section>

<div class="help-content">
    <div class="help-section">
        <h2>Getting Started</h2>
        <p>Welcome to SkillSwap! To start bartering skills, first create your profile and list the skills you want to teach and the skills you want to learn. Our smart matching system will then suggest potential partners for you.</p>
    </div>

    <div class="help-section">
        <h2>How Bartering Works</h2>
        <p>Skill bartering is a reciprocal exchange of knowledge. You spend time teaching someone a skill you master, and in return, you receive lessons in a skill you wish to acquire. No money is exchanged—only time and expertise.</p>
    </div>

    <div class="help-section">
        <h2>Safety & Trust</h2>
        <p>We prioritize the safety of our community. Always review your potential match's profile and ratings before starting a session. We recommend conducting first sessions in public places or through our integrated video classroom.</p>
    </div>

    <div style="text-align: center; margin-top: 60px; padding: 40px; background: var(--bg-light-teal); border-radius: 30px;">
        <h3>Still have questions?</h3>
        <p>Our support team is always here for you.</p>
        <a href="{{ route('contact') }}" class="btn-pill primary" style="margin-top: 20px;">Contact Support</a>
    </div>
</div>

@endsection
