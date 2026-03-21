@extends('app')

@section('content')
<div class="privacy-container">
    <div class="privacy-header">
        <h1>Privacy Policy</h1>
        <p class="muted">Last updated: March 20, 2026</p>
    </div>

    <div class="privacy-content">
        <section>
            <h2>1. Introduction</h2>
            <p>Welcome to SkillSwap!. We value your privacy and are committed to protecting your personal data. This Privacy Policy explains how we collect, use, and safeguard your information when you use nuestro platform.</p>
        </section>

        <section>
            <h2>2. Information We Collect</h2>
            <p>We collect information you provide directly to us, such as when you create an account, update your profile, or communicate with other users. This may include:</p>
            <ul>
                <li>Name, email address, and password</li>
                <li>Profile Information (skills, bio, avatar)</li>
                <li>Communication data (messages sent through the platform)</li>
            </ul>
        </section>

        <section>
            <h2>3. How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul>
                <li>Provide and maintain our services</li>
                <li>Connect you with other users for skill bartering</li>
                <li>Send you technical notices and support messages</li>
                <li>Improve our platform and user experience</li>
            </ul>
        </section>

        <section>
            <h2>4. Data Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, loss, or destruction.</p>
        </section>

        <section>
            <h2>5. Your Rights</h2>
            <p>You have the right to access, update, or delete your personal information. You can manage most of these settings directly through your profile.</p>
        </section>

        <section>
            <h2>6. Contact Us</h2>
            <p>If you have any questions about this Privacy Policy, please contact us at privacy@skillxchange.com.</p>
        </section>
    </div>
</div>

<style>
    .privacy-container { max-width: 800px; margin: 4rem auto; padding: 0 2rem; font-family: 'Inter', sans-serif; }
    .privacy-header { text-align: center; margin-bottom: 3rem; }
    .privacy-header h1 { font-size: 3rem; font-weight: 900; letter-spacing: -1px; }
    .muted { color: #666; font-size: 0.95rem; }
    .privacy-content section { margin-bottom: 2.5rem; }
    .privacy-content h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; border-bottom: 2px solid #eee; padding-bottom: 0.5rem; color: var(--primary-teal); }
    .privacy-content p, .privacy-content ul { color: #444; line-height: 1.8; font-size: 1.1rem; }
    .privacy-content ul { padding-left: 1.5rem; margin-top: 1rem; }
    .privacy-content li { margin-bottom: 0.5rem; }
</style>
@endsection
