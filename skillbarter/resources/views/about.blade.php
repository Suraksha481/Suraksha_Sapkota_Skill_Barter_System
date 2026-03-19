@extends('app')

@section('page_title', 'About')

@section('content')



<section class="about-hero">
    <h1>About Skill Barter</h1>
    <p>Connecting people through the power of shared skills and learning.</p>
</section>


<section class="about-section">
    <div class="about-content">
        <h2>Who We Are</h2>
        <p>
            Skill Barter is a modern platform designed to help people learn, teach,
            and exchange skills without limitations. We believe learning should be
            accessible, collaborative, and community-driven.
        </p>
    </div>

    <img src="https://images.unsplash.com/photo-1551836022-4c4c79ecde51?q=80&w=1200" alt="About Image">
</section>


<section class="mission-section">
    <h2>Our Mission</h2>
    <p>
        To create an inclusive skill-sharing community where people grow together
        through meaningful knowledge exchange.
    </p>
</section>


<section class="values-section">
    <h2>Our Core Values</h2>

    <div class="values-grid">

        <div class="value-card">
            <h3>Community</h3>
            <p>We believe in learning together and supporting each other.</p>
        </div>

        <div class="value-card">
            <h3>Growth</h3>
            <p>We help individuals unlock their potential and improve continuously.</p>
        </div>

        <div class="value-card">
            <h3>Equality</h3>
            <p>Everyone deserves access to knowledge—no barriers.</p>
        </div>

        <div class="value-card">
            <h3>Innovation</h3>
            <p>We introduce modern solutions to skill learning and exchange.</p>
        </div>

    </div>

</section>

@endsection
