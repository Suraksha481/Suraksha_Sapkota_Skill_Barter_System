@extends('layouts.app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Find Teachers</h1>
        <p>Browse registered teachers and their offered skills</p>
    </div>

    <form method="GET" action="{{ route('teachers.index') }}" style="margin-bottom:1rem;">
        <input type="search" name="q" placeholder="Search teachers by name" value="{{ request('q') }}">
        <button type="submit" class="btn">Search</button>
    </form>

    <div class="teacher-list">
        @forelse($teachers as $teacher)
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
        @empty
            <div class="empty">No teachers found.</div>
        @endforelse
    </div>

    <div style="margin-top:1rem;">{{ $teachers->withQueryString()->links() }}</div>

</section>

@endsection
