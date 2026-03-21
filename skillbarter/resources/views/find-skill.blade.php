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
    display: flex;
    align-items: stretch;
    border: 2.5px solid var(--primary-teal);
    border-radius: 50px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 8px 30px rgba(32, 166, 138, 0.12);
    height: 58px;
}
.search-container-v2:focus-within {
    box-shadow: 0 10px 40px rgba(32, 166, 138, 0.22);
    border-color: var(--primary-teal-dark);
}
.search-container-v2 input {
    flex: 2.2;
    border: none;
    padding: 0 28px;
    outline: none;
    font-size: 1rem;
    font-family: inherit;
    background: transparent;
    color: var(--text-slate);
    line-height: 58px;
    height: 58px;
    vertical-align: middle;
}
.search-container-v2 input::placeholder { color: #a0aec0; }
.search-container-v2 select {
    flex: 1;
    border: none;
    border-left: 1.5px solid var(--primary-teal-light);
    padding: 0 22px;
    outline: none;
    font-weight: 600;
    color: #64748b;
    background: transparent;
    font-family: inherit;
    font-size: 0.95rem;
    cursor: pointer;
    height: 58px;
}
.search-container-v2 button {
    background: var(--primary-teal);
    color: #fff;
    border: none;
    padding: 0 40px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.88rem;
    cursor: pointer;
    flex-shrink: 0;
    transition: none;
}

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
    display: flex;
    flex-direction: column;
    height: 100%;
}
.skill-card-v2:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); }
.skill-img-v2 { height: 260px; position: relative; flex-shrink: 0; }
.skill-img-v2 img { width: 100%; height: 100%; object-fit: cover; }
.cat-badge-v2 { position: absolute; top: 20px; left: 20px; background: rgba(255,255,255,0.95); padding: 6px 18px; border-radius: 20px; font-size: 0.8rem; font-weight: 800; color: var(--primary-teal); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

.skill-info-v2 { padding: 30px; display: flex; flex-direction: column; flex-grow: 1; }
.skill-info-v2 h3 { font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 12px; }
.skill-info-v2 p { font-size: 0.95rem; color: #64748b; line-height: 1.6; margin-bottom: 25px; flex-grow: 1; }

.skill-footer-v2 { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 20px; margin-top: auto; }
.learner-count-v2 { font-size: 0.9rem; color: #64748b; font-weight: 700; display: flex; align-items: center; gap: 6px; }
.btn-view-v2 { 
    background: var(--primary-teal);
    color: #fff !important;
    font-weight: 700;
    text-decoration: none;
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(32, 166, 138, 0.2);
}
.btn-view-v2:hover {
    background: var(--primary-teal-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(32, 166, 138, 0.3);
}

@media (max-width: 992px) {
    .skills-grid-v2 { grid-template-columns: 1fr; }
    .search-container-v2 { flex-direction: column; border-radius: 20px; height: auto; padding: 14px 16px; margin-top: 20px; gap: 10px; }
    .search-container-v2 input  { height: 44px; line-height: 44px; padding: 0 16px; }
    .search-container-v2 select { border-left: none; border-top: 1.5px solid var(--primary-teal-light); padding: 10px 16px; height: 44px; }
    .search-container-v2 button { height: 44px; border-radius: 12px; }
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
                    @if($skill->image)
                        <img src="{{ asset($skill->image) }}"
                             alt="{{ $skill->title }}"
                             onerror="this.src='{{ asset('images/skills/web_development.png') }}'">
                    @else
                        <img src="{{ asset('images/skills/web_development.png') }}" alt="{{ $skill->title }}">
                    @endif
                    <div class="cat-badge-v2">{{ $skill->category }}</div>
                </div>
                <div class="skill-info-v2">
                    <h3>{{ $skill->title }}</h3>
                    <p>{{ Str::limit($skill->description, 100) }}</p>
                    <div class="skill-footer-v2">
                        <span class="learner-count-v2">
                            <svg style="width:16px;" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                            {{ rand(5, 50) }} learners
                        </span>
                        <a href="{{ route('skill.show', $skill) }}" class="btn-view-v2">Details</a>
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
