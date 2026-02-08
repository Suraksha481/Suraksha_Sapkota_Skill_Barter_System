<footer id="footer" class="site-footer">
    <div class="footer-top">
        <div class="footer-brand">
            <h3>SkillBarter</h3>
            <p>“Connect, share, and grow! Our platform allows individuals to exchange skills 
              instead of money—learn what you need, teach what you know, and build a community of collaboration and mutual growth.”</p>
        </div>
        <div class="footer-brand">
            <h3>Located Us</h3>
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

    if (window.location.pathname === '/signup') {
        document.getElementById('footer').style.display = 'none';
    }
</script>

<script>

    if (window.location.pathname === '/login') {
        document.getElementById('footer').style.display = 'none';
    }
</script>


