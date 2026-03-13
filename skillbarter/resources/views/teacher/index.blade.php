@extends('app')

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
                    <div style="display:flex; align-items:flex-start; gap:1.5rem; width: 100%;">
                        <img src="{{ $teacher->avatar ?? 'https://via.placeholder.com/80' }}" alt="{{ $teacher->name }}" style="width:80px; height:80px; border-radius:8px; object-fit:cover;">
                        <div style="flex-grow: 1;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                <div>
                                    <h3 style="margin-top:0; margin-bottom:0.25rem;">{{ $teacher->name }}</h3>
                                    <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                                        <div style="color:#f59e0b; font-size:1.1rem;">
                                            @if($teacher->average_rating)
                                                ★ {{ number_format($teacher->average_rating, 1) }}
                                            @else
                                                <span style="color:#cbd5e1; font-size:0.9rem;">No ratings yet</span>
                                            @endif
                                        </div>
                                        @if($teacher->reviews_count > 0)
                                            <span style="color:#64748b; font-size:0.85rem;">({{ $teacher->reviews_count }} reviews)</span>
                                        @endif
                                    </div>
                                    <p style="margin:0; color:#666; line-height:1.4;">{{ Str::limit($teacher->bio ?? 'No bio available.', 120) }}</p>
                                </div>
                                <div>
                                     <a href="{{ route('teachers.show', $teacher) }}" class="btn small">View Profile</a>
                                </div>
                            </div>
                            
                            @if($teacher->userSkills->count() > 0)
                            <div style="margin-top: 1rem; display:flex; flex-wrap:wrap; gap:0.5rem;">
                                @foreach($teacher->userSkills->take(3) as $us)
                                    <span style="background:#eef2ff; color:#4f46e5; padding:0.2rem 0.6rem; border-radius:12px; font-size:0.8rem;">
                                        {{ $us->skill->title }}
                                    </span>
                                @endforeach
                                @if($teacher->userSkills->count() > 3)
                                    <span style="background:#f1f5f9; color:#64748b; padding:0.2rem 0.6rem; border-radius:12px; font-size:0.8rem;">
                                        +{{ $teacher->userSkills->count() - 3 }} more
                                    </span>
                                @endif
                            </div>
                            @endif
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
