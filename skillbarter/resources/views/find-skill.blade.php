@extends('app')

@section('page_title', 'Find Skills - SkillSwap')

@section('content')

<style>
.find-hero-v2 {
    background: var(--bg-light-teal);
    padding: 80px 5%;
    text-align: center;
}
.find-hero-v2 h1 { font-size: 3rem; margin-bottom: 20px; letter-spacing: -1.5px; }

.search-container-v2 {
    max-width: 1000px;
    margin: -40px auto 60px;
    background: #fff;
    padding: 8px;
    border-radius: 100px;
    display: flex;
    align-items: stretch;
    box-shadow: 0 20px 50px rgba(0,0,0,0.08);
}
.search-container-v2 input { flex: 2.2; border: none; padding: 18px 30px; border-radius: 100px 0 0 100px; outline: none; font-size: 1.05rem; background: transparent; }
.search-container-v2 select { flex: 1; border: none; border-left: 1px solid #eee; padding: 0 25px; outline: none; font-weight: 600; color: #666; background: transparent; }
.search-container-v2 button { background: var(--primary-teal); color: #fff; border: none; padding: 0 45px; border-radius: 100px; font-weight: 700; cursor: pointer; transition: background 0.3s ease; display: flex; align-items: center; justify-content: center; }
.search-container-v2 button:hover { background: var(--primary-teal-dark); }

.skills-grid-v2 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    padding-bottom: 80px;
}
.skill-card-v2 {
    background: #fff;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    border: 1px solid #f0f0f0;
    transition: transform 0.3s;
}
.skill-card-v2:hover { transform: translateY(-10px); }
.skill-img-v2 { height: 200px; position: relative; }
.skill-img-v2 img { width: 100%; height: 100%; object-fit: cover; }
.cat-badge-v2 { position: absolute; top: 20px; left: 20px; background: rgba(255,255,255,0.9); padding: 5px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; color: var(--primary-teal); }

.skill-info-v2 { padding: 30px; }
.skill-info-v2 h3 { font-size: 1.3rem; margin-bottom: 15px; }
.skill-info-v2 p { font-size: 0.9rem; color: #777; line-height: 1.6; margin-bottom: 25px; height: 4.8em; overflow: hidden; }

.skill-footer-v2 { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f8f8f8; padding-top: 20px; }
.learner-count-v2 { font-size: 0.85rem; color: #999; font-weight: 600; }
.btn-view-v2 { color: var(--primary-teal); font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 5px; }

@media (max-width: 992px) {
    .skills-grid-v2 { grid-template-columns: 1fr; }
    .search-container-v2 { flex-direction: column; border-radius: 20px; padding: 20px; margin-top: 20px; }
    .search-container-v2 select { border-left: none; border-top: 1px solid #eee; margin: 10px 0; padding: 10px 0; }
}
</style>

<section class="find-hero-v2">
    <div class="container">
        <span class="badge-teal">EXPLORE KNOWLEDGE</span>
        <h1>What do you want to <span class="text-teal">learn</span> today?</h1>
        <p>Discover expert mentors and fellow students ready to share their expertise.</p>
    </div>
</section>

<div class="container">
    <form class="search-container-v2" method="GET" action="{{ route('find-skill') }}">
        <input type="search" name="q" placeholder="Search skills (e.g. Photoshop, Marketing...)" value="{{ request('q') }}">
        <select name="category">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
        </select>
        <button type="submit">Search Skill</button>
    </form>

    @if(request('q'))
        <p style="margin-bottom: 30px; color: #777;">Showing results for: <strong class="text-teal">{{ request('q') }}</strong></p>
    @endif

    <div class="skills-grid-v2">
        @forelse($skills as $skill)
            <div class="skill-card-v2">
                <div class="skill-img-v2">
                    <img src="https://via.placeholder.com/400x250?text={{ urlencode($skill->title) }}" alt="{{ $skill->title }}">
                    <div class="cat-badge-v2">{{ $skill->category }}</div>
                </div>
                <div class="skill-info-v2">
                    <h3>{{ $skill->title }}</h3>
                    <p>{{ Str::limit($skill->description, 100) }}</p>
                    <div class="skill-footer-v2">
                        <span class="learner-count-v2">👥 {{ $skill->users_count ?? 0 }} learners</span>
                        <a href="{{ route('skill.show', $skill) }}" class="btn-view-v2">Details →</a>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 100px 0;">
                <div style="font-size: 4rem; margin-bottom: 20px;">📂</div>
                <h3>No skills found</h3>
                <p>Try searching for a different keyword or category.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-center" style="margin-bottom: 80px; display: flex; justify-content: center;">
        {{ $skills->appends(request()->query())->links('partials.pagination') }}
    </div>
</div>

@endsection
