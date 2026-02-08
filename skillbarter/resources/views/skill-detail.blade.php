@extends('app')

@section('content')

<section class="skill-detail-hero">
    <h1>{{ $skill->title }}</h1>
    <p class="skill-category">{{ $skill->category }}</p>
</section>

<section class="skill-detail-container">

    <div class="skill-detail-card">

        <div class="skill-detail-image">
            <img
                src="https://via.placeholder.com/600x350?text={{ urlencode($skill->title) }}"
                alt="{{ $skill->title }}"
            >
        </div>

        <div class="skill-detail-info">
            <h2>About this Skill</h2>
            <p>{{ $skill->description }}</p>

            <div class="skill-meta">
                <span><strong>Category:</strong> {{ $skill->category }}</span>
            </div>

            @auth
                <a href="{{ route('my.skills') }}" class="btn primary">
                    Add to My Skills
                </a>
            @else
                <a href="{{ route('register') }}" class="btn primary">
                    Sign up to Learn / Teach
                </a>
            @endauth
        </div>

    </div>

</section>

@endsection
