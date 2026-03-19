@extends('app')

@section('page_title', 'Find Skill')

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
            <div class="skill-card-premium">
                <div class="card-image">
                    <img src="https://via.placeholder.com/400x250?text={{ urlencode($skill->title) }}" alt="{{ $skill->title }}">
                    <div class="category-tag">{{ $skill->category }}</div>
                </div>

                <div class="card-body">
                    <h3>{{ $skill->title }}</h3>
                    <p>{{ Str::limit($skill->description, 120) }}</p>
                    
                    <div class="card-footer">
                        <span class="user-count">{{ $skill->users_count ?? 0 }} learners</span>
                        <a href="{{ route('skill.show', $skill) }}" class="btn-details">
                            View Details
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📂</div>
                <h3>No skills found</h3>
                <p>Try a different keyword or category.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-center">
        {{ $skills->appends(request()->query())->links('partials.pagination') }}
    </div>

</section>

<style>
    .find-skill-hero { text-align: center; padding: 5rem 2rem; background: #000; color: #fff; border-radius: 0 0 40px 40px; }
    .find-skill-hero h1 { font-size: 4rem; font-weight: 900; margin-bottom: 1rem; }
    
    .find-skill-container { max-width: 1300px; margin: -3rem auto 4rem; padding: 0 2rem; }
    
    .find-skill-search { background: #fff; padding: 1.5rem; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); display: flex; gap: 1rem; margin-bottom: 4rem; }
    .find-skill-search input { flex: 2; padding: 1rem; border: 2px solid #eee; border-radius: 12px; font-weight: 600; outline: none; }
    .find-skill-search select { flex: 1; padding: 1rem; border: 2px solid #eee; border-radius: 12px; font-weight: 600; outline: none; }
    .find-skill-search button { padding: 1rem 2rem; background: #000; color: #fff; border: none; border-radius: 12px; font-weight: 800; cursor: pointer; transition: transform 0.2s; }
    .find-skill-search button:hover { transform: scale(1.02); }

    .skills-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2.5rem; }
    
    .skill-card-premium { background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #f0f0f0; }
    .skill-card-premium:hover { transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.1); border-color: #000; }
    
    .card-image { position: relative; height: 220px; overflow: hidden; }
    .card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .skill-card-premium:hover .card-image img { transform: scale(1.1); }
    
    .category-tag { position: absolute; top: 1.5rem; left: 1.5rem; background: #000; color: #fff; padding: 6px 14px; border-radius: 8px; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; }
    
    .card-body { padding: 2rem; }
    .card-body h3 { font-size: 1.5rem; font-weight: 900; margin-bottom: 1rem; letter-spacing: -0.5px; }
    .card-body p { color: #666; line-height: 1.7; font-size: 1rem; margin-bottom: 2rem; }
    
    .card-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f0f0; padding-top: 1.5rem; }
    .user-count { font-weight: 700; color: #999; font-size: 0.9rem; }
    .btn-details { display: flex; align-items: center; gap: 8px; font-weight: 800; color: #000; text-decoration: none; border-bottom: 2px solid #000; padding-bottom: 2px; }
    
    .pagination-center { margin-top: 5rem; display: flex; justify-content: center; }
    .empty-state { grid-column: 1 / -1; text-align: center; padding: 5rem; }
    .empty-icon { font-size: 4rem; margin-bottom: 2rem; }
    
    @media (max-width: 768px) {
        .find-skill-search { flex-direction: column; }
        .find-skill-hero h1 { font-size: 2.5rem; }
    }
</style>

@endsection
