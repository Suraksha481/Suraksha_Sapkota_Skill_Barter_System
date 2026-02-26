@extends('layouts.app')

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
                @php $user = auth()->user(); @endphp
                @if($user->isTeacher() && ! $user->isStudent())
                    <button class="btn primary add-skill-btn" data-skill-id="{{ $skill->id }}" data-type="offer">Add to My Skills</button>
                @elseif($user->isStudent() && ! $user->isTeacher())
                    <button class="btn primary add-skill-btn" data-skill-id="{{ $skill->id }}" data-type="request">Add to My Skills</button>
                @else
                    <div class="inline-add">
                        <select class="add-skill-type">
                            <option value="offer">Teach</option>
                            <option value="request">Learn</option>
                        </select>
                        <button class="btn primary add-skill-btn" data-skill-id="{{ $skill->id }}">Add</button>
                    </div>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn primary">
                    Sign up to Learn / Teach
                </a>
            @endauth
        </div>

    </div>

</section>

@endsection
