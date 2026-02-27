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

@if(isset($teachers) && $teachers->isNotEmpty())
<section class="skill-teachers">
    <h2>Teachers offering this skill</h2>
    <div class="teacher-list">
        @foreach($teachers as $teacher)
            <div class="teacher-card">
                <div style="display:flex; align-items:center; gap:1rem;">
                    <img src="{{ $teacher->avatar ?? 'https://via.placeholder.com/80' }}" alt="{{ $teacher->name }}" style="width:80px; height:80px; border-radius:8px; object-fit:cover;">
                    <div>
                        <h3>{{ $teacher->name }}</h3>
                        <p style="margin:0; color:#666;">{{ Str::limit($teacher->bio ?? '', 120) }}</p>
                        <div style="margin-top:0.5rem;">
                            <a href="{{ route('teachers.show', $teacher) }}" class="btn small">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <p class="view-more">
        <a href="{{ route('teachers.index', ['q' => $skill->title]) }}">See all teachers for “{{ $skill->title }}”</a>
    </p>
</section>
@endif

@endsection        </div>

    </div>

</section>

@endsection
