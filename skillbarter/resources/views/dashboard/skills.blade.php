@extends('app')

@section('content')

<section class="manage-skills">

    <h1>Manage My Skills</h1>
    <p class="subtitle">Add skills you can teach or want to learn</p>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <!-- ADD SKILL FORM -->
    <div class="skill-form-card">
        <form method="POST" action="{{ route('my.skills.store') }}">
            @csrf

            <div class="form-group">
                <label>Select Skill</label>
                <select name="skill_id" required>
                    <option value="">-- Choose a skill --</option>
                    @foreach($allSkills as $skill)
                        <option value="{{ $skill->id }}">
                            {{ $skill->title }} ({{ $skill->category }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>I want to</label>
                <select name="type" required>
                    <option value="offer">Teach this skill</option>
                    <option value="request">Learn this skill</option>
                </select>
            </div>

            <button type="submit" class="btn primary">Add Skill</button>
        </form>
    </div>

    <!-- SKILLS LIST -->
    <div class="skills-columns">

        <!-- TEACH -->
        <div class="skills-box">
            <h2>Skills I Teach</h2>

            <ul>
                @forelse($teachSkills as $userSkill)
                    <li>
                        {{ $userSkill->skill->title ?? 'Unknown Skill' }}
                        <form method="POST" action="{{ route('my.skills.destroy', $userSkill->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-btn">✕</button>
                        </form>
                    </li>
                @empty
                    <li class="empty">You haven't added teaching skills yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- LEARN -->
        <div class="skills-box">
            <h2>Skills I Want to Learn</h2>

            <ul>
                @forelse($learnSkills as $userSkill)
                    <li>
                        {{ $userSkill->skill->title ?? 'Unknown Skill' }}
                        <form method="POST" action="{{ route('my.skills.destroy', $userSkill->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-btn">✕</button>
                        </form>
                    </li>
                @empty
                    <li class="empty">You haven't added learning skills yet.</li>
                @endforelse
            </ul>
        </div>

    </div>

</section>

@endsection
