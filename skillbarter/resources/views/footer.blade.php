<footer id="footer" class="site-footer">
    <style>
        .site-footer {
            background: #fff;
            color: var(--text-slate);
            padding: 80px 5% 40px;
            border-top: 1px solid #eee;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }
        .footer-brand .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-slate);
            margin-bottom: 20px;
        }
        .footer-brand .logo svg { color: var(--primary-teal); width: 32px; }
        .footer-brand p {
            color: #777;
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 25px;
        }
        .social-links {
            display: flex;
            gap: 12px;
        }
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-light-teal);
            color: var(--primary-teal);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .social-icon:hover {
            background: var(--primary-teal);
            color: #fff;
            transform: translateY(-3px);
        }
        .social-icon svg { width: 18px; height: 18px; }
        .footer-col h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--text-slate);
        }
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a {
            color: #777;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s;
        }
        .footer-links a:hover { color: var(--primary-teal); }

        .footer-bottom {
            padding-top: 30px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #aaa;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="footer-grid">
        <div class="footer-brand">
            <div class="logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                SkillSwap
            </div>
            <p>Empowering the community through knowledge exchange. Learn, teach, and grow together without borders.</p>
            <div class="social-links">
                <a href="https://facebook.com" class="social-icon" target="_blank">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
                </a>
                <a href="https://twitter.com" class="social-icon" target="_blank">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="https://instagram.com" class="social-icon" target="_blank">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.245 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.063 1.366-.333 2.633-1.308 3.608-.975.975-2.242 1.245-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.063-2.633-.333-3.608-1.308-.975-.975-1.245-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.332-2.633 1.308-3.608.975-.975 2.242-1.245 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.272 2.69.072 7.053.014 8.333 0 8.741 0 12s.014 3.667.072 4.947c.2 4.353 2.618 6.77 6.98 6.97 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.351-.2 6.77-2.618 6.97-6.98.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.2-4.353-2.618-6.77-6.98-6.97C15.667.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
                <a href="https://linkedin.com" class="social-icon" target="_blank">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.238 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
            </div>
        </div>

        <div class="footer-col">
            <h4>Company</h4>
            <ul class="footer-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Services</h4>
            <ul class="footer-links">
                <li><a href="{{ route('find-skill') }}">Find Skills</a></li>
                <li><a href="{{ route('service') }}">Services</a></li>
                <li><a href="{{ route('premium.index') }}">Premium Membership</a></li>
                <li><a href="{{ auth()->check() ? route('match') : route('login') }}">Skill Matching</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Support</h4>
            <ul class="footer-links">
                <li><a href="{{ route('help-center') }}">Help Center</a></li>
                <li><a href="{{ route('feedback.index') }}">Feedback</a></li>
                <li><a href="{{ route('terms-of-use') }}">Terms of Use</a></li>
                <li><a href="{{ route('rewards.index') }}">Rewards Program</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <div>&copy; {{ date('Y') }} SkillSwap. Built with passion.</div>
        <div>All Rights Reserved.</div>
    </div>
</footer>


<script>

    if (window.location.pathname === '/register') {
        document.getElementById('footer').style.display = 'none';
    }
</script>

<script>

    if (window.location.pathname === '/login') {
        document.getElementById('footer').style.display = 'none';
    }
</script>


