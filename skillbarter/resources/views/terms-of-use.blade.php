@extends('app')

@section('page_title', 'Terms of Use - SkillSwap')

@section('content')

<style>
.terms-hero {
    background: var(--bg-light-teal);
    padding: 80px 5%;
    text-align: center;
    border-radius: 0 0 50px 50px;
}
.terms-content {
    max-width: 900px;
    margin: 60px auto;
    padding: 0 5%;
}
.terms-section { margin-bottom: 40px; }
.terms-section h2 { color: var(--primary-teal); margin-bottom: 20px; }
.terms-section p { line-height: 1.8; color: #666; }
</style>

<section class="terms-hero">
    <span class="badge-teal">LEGAL</span>
    <h1>Terms of Use</h1>
    <p>Please read these terms carefully before using our platform.</p>
</section>

<div class="terms-content">
    <div class="terms-section">
        <h2>1. Acceptance of Terms</h2>
        <p>By accessing and using SkillSwap, you agree to comply with and be bound by these Terms of Use. If you do not agree to these terms, please do not use the platform.</p>
    </div>

    <div class="terms-section">
        <h2>2. User Conduct</h2>
        <p>Users are expected to interact with respect and integrity. Any form of harassment, discrimination, or fraudulent activity is strictly prohibited and will lead to immediate account termination.</p>
    </div>

    <div class="terms-section">
        <h2>3. Skill Exchange Disclaimer</h2>
        <p>SkillSwap provides the platform for connections but is not responsible for the quality or accuracy of the skills taught by users. Users engage in exchanges at their own discretion.</p>
    </div>

    <div class="terms-section">
        <h2>4. Privacy</h2>
        <p>Your use of the platform is also governed by our Privacy Policy. We are committed to protecting your personal data and ensuring a secure environment.</p>
    </div>
</div>

@endsection
