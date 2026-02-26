@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex align-items-center mb-4">
                <img
                    src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.$user->name }}"
                    class="rounded-circle me-3"
                    width="80"
                    height="80"
                >
                <div>
                    <h3 class="mb-0">{{ $user->name }}</h3>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                    <span class="badge bg-primary mt-1">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <hr>

            <h5>About</h5>
            <p>{{ $user->bio ?? 'No bio added yet.' }}</p>

            <hr>

            <h5>Skills</h5>
            <ul>
                @foreach($user->skills as $skill)
                    <li>{{ $skill->name }}</li>
                @endforeach
            </ul>

            <hr>

            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                Edit Profile
            </a>

        </div>
    </div>

</div>
@endsection
