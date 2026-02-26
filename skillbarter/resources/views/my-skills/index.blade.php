@extends('layouts.app') {{-- use SAME layout your home page uses --}}

@section('content')

<div class="skill-page">

    <h2 class="section-heading">My Skills</h2>

    <div class="card-dark">
        <h3>Add Skill</h3>

        <form action="{{ route('my.skills.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Select Skill</label>
                <select name="skill_id" required>
                    <option value="">-- Choose Skill --</option>
                    @foreach($allSkills as $skill)
                        <option value="{{ $skill->id }}">{{ $skill->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Type</label>
                <select name="type" required>
                    <option value="offer">I Teach</option>
                    <option value="request">I Want to Learn</option>
                </select>
            </div>

            <div class="form-group">
                <label>Level</label>
                <select name="level">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>

            <button type="submit" class="btn-primary-dark">
                Add Skill
            </button>
        </form>
    </div>

    <div class="card-dark">
        <h3>Skills I Teach</h3>
        @forelse($teachSkills as $skill)
            <div class="skill-row-dark">
                <span>{{ $skill->title }}</span>
            </div>
        @empty
            <p>No teaching skills yet.</p>
        @endforelse
    </div>

    <div class="card-dark">
        <h3>Skills I Want to Learn</h3>
        @forelse($learnSkills as $skill)
            <div class="skill-row-dark">
                <span>{{ $skill->title }}</span>
            </div>
        @empty
            <p>No learning skills yet.</p>
        @endforelse
    </div>

</div>

@endsection
