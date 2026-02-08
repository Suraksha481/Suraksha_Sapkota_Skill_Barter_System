@extends('app')

@section('content')

<section class="find-skill-hero">
    <h1>Find Skills</h1>
    <p>Discover skills you can learn or teach from the community</p>
</section>

<section class="find-skill-container">

    <!-- SEARCH & FILTER -->
    <form class="find-skill-search" method="GET" action="{{ route('find-skill') }}">
        <input
            type="search"
            name="q"
            placeholder="Search skills like Python, Design, Marketing..."
            value="{{ request('q') }}"
        >

        <select name="category">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                    {{ $category }}
                </option>
            @endforeach
        </select>

        <button type="submit">Search</button>
    </form>

    <!-- SKILLS GRID -->
    @if(request('q'))
    <p class="search-info">
        Showing results for: <strong>{{ request('q') }}</strong>
    </p>
    @endif

    <div class="skills-grid">

        @forelse($skills as $skill)
            <div class="skill-card">
                <div class="skill-badge">{{ $skill->category }}</div>

                <h3>{{ $skill->title }}</h3>
                <p>{{ Str::limit($skill->description, 100) }}</p>

                <a href="{{ route('skill.show', $skill) }}" class="skill-link">
                    View Details
                </a>
            </div>
        @empty
            <div class="empty-state">
                <h3>No skills found</h3>
                <p>Try a different keyword or category.</p>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pagination-wrapper">
        {{ $skills->withQueryString()->links() }}
    </div>


</section>

@endsection
