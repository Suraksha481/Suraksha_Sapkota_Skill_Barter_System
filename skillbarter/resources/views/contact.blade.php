@extends('app')

@section('page_title', 'Contact Us - SkillSwap')

@section('content')

<style>
.contact-hero-v2 {
    background: #75dcc5;
    padding: 100px 4%;
    text-align: center;
}
.contact-hero-v2 h1 { font-size: 3.5rem; margin-bottom: 20px; letter-spacing: -2px; }

.contact-grid-v2 {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 60px;
    margin: 50px 0 100px;
}
.contact-form-v2 {
    background: #fff;
    padding: 60px;
    border-radius: 40px;
    box-shadow: 0 40px 80px rgba(0,0,0,0.06);
}
.contact-form-v2 h2 { font-size: 2rem; margin-bottom: 40px; }
.form-group-v2 { margin-bottom: 25px; }
.form-group-v2 label { display: block; margin-bottom: 10px; font-weight: 700; color: var(--text-slate); }
.form-group-v2 input, .form-group-v2 textarea {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #f0f0f0;
    border-radius: 15px;
    outline: none;
    transition: 0.3s;
}
.form-group-v2 input:focus, .form-group-v2 textarea:focus { border-color: var(--primary-teal); }

.contact-info-v2 { padding: 40px 0; }
.info-box-v2 { margin-bottom: 40px; }
.info-box-v2 h4 { font-size: 1.2rem; color: var(--primary-teal); margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
.info-box-v2 p { font-size: 1.1rem; color: #666; }

.faq-v2 { background: var(--bg-light-teal); padding: 100px 5%; border-radius: 50px; }
.faq-grid-v2 { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 50px; }
.faq-item-v2 { background: #fff; padding: 30px; border-radius: 20px; }
.faq-item-v2 h4 { font-size: 1.1rem; margin-bottom: 10px; color: var(--text-slate); }
.faq-item-v2 p { font-size: 0.95rem; color: #888; }

@media (max-width: 992px) {
    .contact-grid-v2 { grid-template-columns: 1fr; }
    .faq-grid-v2 { grid-template-columns: 1fr; }
}
</style>

<section class="contact-hero-v2">
    <div class="container">
        <span class="badge-teal">GET IN TOUCH</span>
        <h1>We'd love to <span class="text-teal">hear</span> from you.</h1>
        <p>Have questions about our platform or want to partner with us? Reach out anytime.</p>
    </div>
</section>

<div class="container">
    <div class="contact-grid-v2">
        <div class="contact-form-v2">
            <h2>Send us a Message</h2>

            @if(session('success'))
                <div style="background: var(--bg-light-teal); color: var(--primary-teal); padding: 20px; border-radius: 15px; margin-bottom: 30px; font-weight: 600;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="form-group-v2">
                    <label>Your Name</label>
                    <input type="text" name="name" placeholder="Enter your full name" required>
                </div>
                <div class="form-group-v2">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="email@example.com" required>
                </div>
                <div class="form-group-v2">
                    <label>Subject</label>
                    <input type="text" name="subject" placeholder="How can we help?" required>
                </div>
                <div class="form-group-v2">
                    <label>Message</label>
                    <textarea name="message" rows="5" placeholder="Your message here..." required></textarea>
                </div>
                <button type="submit" class="btn-pill primary" style="width: 100%; padding: 20px;">Send Message</button>
            </form>
        </div>

        <div class="contact-info-v2">
            <div class="info-box-v2">
                <h4>Email Us</h4>
                <p>support@skillswap.com<br>info@skillswap.com</p>
            </div>
            <div class="info-box-v2">
                <h4>Call Us</h4>
                <p>+977 9816681421<br>+977 061-554433</p>
            </div>
            <div class="info-box-v2">
                <h4>Our Office</h4>
                <p>Pokhara-17, Jyamirkuna<br>Gandaki, Nepal</p>
            </div>
            <div class="info-box-v2">
                <h4>Support Hours</h4>
                <p>Mon - Fri: 9:00 AM - 6:00 PM<br>Weekend: 10:00 AM - 2:00 PM</p>
            </div>
        </div>
    </div>

    <section class="faq-v2">
        <div style="text-align: center;">
            <span class="badge-teal">FAQS</span>
            <h2>Common Questions</h2>
        </div>

        <div class="faq-grid-v2">
            <div class="faq-item-v2">
                <h4>Is SkillSwap really free?</h4>
                <p>Yes, our core mission is to enable peer-to-peer barter, meaning you teach to learn. No money involved!</p>
            </div>
            <div class="faq-item-v2">
                <h4>How do I trust a mentor?</h4>
                <p>We use a rating and review system. Each mentor has a reputation score based on their past sessions.</p>
            </div>
            <div class="faq-item-v2">
                <h4>Can I learn multiple skills?</h4>
                <p>Absolutely! You can enroll in as many skills as you want as long as you can manage your schedule.</p>
            </div>
            <div class="faq-item-v2">
                <h4>How are sessions conducted?</h4>
                <p>Sessions can be online (via video call) or in-person at campus, depending on your match's preference.</p>
            </div>
        </div>
    </section>
</div>

@endsection
