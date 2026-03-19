<footer id="footer" class="site-footer">
    <style>
        .site-footer {
            background: #000000;
            color: #ffffff;
            padding: 4rem 2rem 2rem;
            border-top: 1px solid #1a1a1a;
        }
        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .footer-brand h3, .footer-links h4, .footer-contact h4 {
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: -0.5px;
        }
        .footer-brand p, .footer-contact p {
            color: #a0a0a0;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        .footer-links a {
            color: #a0a0a0;
            text-decoration: none;
            transition: color 0.3s;
            font-size: 0.95rem;
        }
        .footer-links a:hover {
            color: #ffffff;
        }
        .footer-bottom {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid #1a1a1a;
            text-align: center;
            color: #666666;
            font-size: 0.9rem;
        }
    </style>
    <div class="footer-top">
        <div class="footer-brand">
            <h3>SkillBarter</h3>
            <p>“Connect, share, and grow! Our platform allows individuals to exchange skills 
              instead of money—learn what you need, teach what you know, and build a community of collaboration and mutual growth.”</p>
        </div>
        <div class="footer-brand">
            <h3>Location</h3>
            <p>Pokhara-17, Jyamirkuna</p>
        </div>
        <div class="footer-links">
            <h4>Quick Links</h4>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/about') }}">About</a>
            <a href="{{ url('/find-skill') }}">Find Skills</a>
            <a href="{{ url('/match') }}">Matches</a>
            <a href="{{ url('/rewards') }}">Rewards</a>
            <a href="{{ url('/feedback') }}">Feedback</a>
            <a href="{{ url('/contact') }}">Contact</a>
        </div>
        <div class="footer-contact">
            <h4>Contact</h4>
            <p>Email: support@skillbarter.com</p>
            <p>Phone: 9816681421</p>
            <p>Address: Pokhara-17, Jyamirkuna</p>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2025 SkillBarter. All rights reserved.
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


