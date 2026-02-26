@extends('layouts.app') {{-- or your real layout --}}

@section('content')

<div class="container-dark">

    <h2 class="section-title">Edit Profile</h2>

    @if(session('status'))
        <div class="alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="dark-form">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label>Bio</label>
            <textarea name="bio">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <button type="submit" class="btn-dark">
            Update Profile
        </button>

    </form>

</div>

@endsection
