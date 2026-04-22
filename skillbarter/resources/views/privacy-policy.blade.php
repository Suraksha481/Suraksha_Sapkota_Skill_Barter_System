@extends('app')

@section('page_title', 'Privacy Policy - SkillSwap')

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
.help-section p,
.help-section ul { line-height: 1.8; color: #666; }
.help-section ul { padding-left: 1.5rem; margin-top: 1rem; }
.help-section li { margin-bottom: 0.5rem; }
</style>

<section class="help-hero">
    <span class="badge-teal">SUPPORT</span>
    <h1>Privacy Policy</h1>
    <p>Last updated: March 20, 2026</p>
</section>

<div class="help-content">
    <div class="help-section">
        <h2>1. Introduction</h2>
        <p>Welcome to SkillSwap!. We value your privacy and are committed to protecting your personal data. This Privacy Policy explains how we collect, use, and safeguard your information when you use nuestro platform.</p>
    </div>

    <div class="help-section">
        <h2>2. Information We Collect</h2>
        <p>We collect information you provide directly to us, such as when you create an account, update your profile, or communicate with other users. This may include:</p>
        <ul>
            <li>Name, email address, and password</li>
            <li>Profile Information (skills, bio, avatar)</li>
            <li>Communication data (messages sent through the platform)</li>
        </ul>
    </div>

    <div class="help-section">
        <h2>3. How We Use Your Information</h2>
        <p>We use the information we collect to:</p>
        <ul>
            <li>Provide and maintain our services</li>
            <li>Connect you with other users for skill bartering</li>
            <li>Send you technical notices and support messages</li>
            <li>Improve our platform and user experience</li>
        </ul>
    </div>

    <div class="help-section">
        <h2>4. Data Security</h2>
        <p>We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, loss, or destruction.</p>
    </div>

    <div class="help-section">
        <h2>5. Your Rights</h2>
        <p>You have the right to access, update, or delete your personal information. You can manage most of these settings directly through your profile.</p>
    </div>

    <div class="help-section">
        <h2>6. Contact Us</h2>
        <p>If you have any questions about this Privacy Policy, please contact us at privacy@skillxchange.com.</p>
    </div>
</div>

@endsection
