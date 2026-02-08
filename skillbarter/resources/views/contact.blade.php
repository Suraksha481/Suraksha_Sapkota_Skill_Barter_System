@extends('app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/contact.css') }}">

<section class="contact-hero">
    <h1>Get in Touch</h1>
    <p>Have questions? We'd love to hear from you. Send us a message anytime.</p>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-wrapper">
            <!-- Contact Form -->
            <div class="contact-form-container">
                <h2>Send us a Message</h2>

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                    @csrf

                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="John Doe"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            placeholder="How can we help?"
                            value="{{ old('subject') }}"
                            required
                        >
                        @error('subject')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea
                            id="message"
                            name="message"
                            placeholder="Tell us what's on your mind..."
                            rows="6"
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn">Send Message</button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="contact-info-container">
                <h2>Contact Information</h2>

                <div class="info-item">
                    <h4>📧 Email</h4>
                    <p>
                        <a href="mailto:support@skillbarter.com">support@skillbarter.com</a>
                    </p>
                </div>

                <div class="info-item">
                    <h4>📞 Phone</h4>
                    <p>
                        <a href="tel:+9816681421">+977 9816681421</a>
                    </p>
                </div>

                <div class="info-item">
                    <h4>📍 Address</h4>
                    <p>
                        Pokhara-17, Jyamirkuna<br>
                        Pokhara, Nepal
                    </p>
                </div>

                <div class="info-item">
                    <h4>🕒 Business Hours</h4>
                    <p>
                        Monday - Friday: 9:00 AM - 6:00 PM<br>
                        Saturday: 10:00 AM - 4:00 PM<br>
                        Sunday: Closed
                    </p>
                </div>

                <div class="info-item">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="https://facebook.com" target="_blank">Facebook</a>
                        <a href="https://twitter.com" target="_blank">Twitter</a>
                        <a href="https://instagram.com" target="_blank">Instagram</a>
                        <a href="https://linkedin.com" target="_blank">LinkedIn</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="contact-faq">
    <div class="container">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-grid">
            <div class="faq-item">
                <h4>How quickly will I receive a response?</h4>
                <p>We aim to respond to all inquiries within 24 business hours. For urgent matters, please call us directly.</p>
            </div>

            <div class="faq-item">
                <h4>Can I change my subscription plan?</h4>
                <p>Yes! You can upgrade or downgrade your plan anytime from your account settings without penalty.</p>
            </div>

            <div class="faq-item">
                <h4>How do I reset my password?</h4>
                <p>Click "Forgot Password" on the login page and follow the instructions sent to your email.</p>
            </div>

            <div class="faq-item">
                <h4>Do you offer refunds?</h4>
                <p>We offer a 7-day money-back guarantee for all premium subscriptions. Contact support for details.</p>
            </div>

            <div class="faq-item">
                <h4>How can I report abuse or unsafe behavior?</h4>
                <p>Use the "Report" button on any user profile or contact us directly with details and evidence.</p>
            </div>

            <div class="faq-item">
                <h4>Is my data secure?</h4>
                <p>Yes, we use industry-standard encryption (SSL/TLS) to protect your data. Learn more in our Privacy Policy.</p>
            </div>
        </div>
    </div>
</section>

@endsection
