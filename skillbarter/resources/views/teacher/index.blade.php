@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header" style="text-align: center; margin-bottom: 4rem;">
        <h1 style="font-size: 3rem; font-weight: 800; letter-spacing: -1px;">Find Your Mentor</h1>
        <p style="font-size: 1.1rem; color: #666;">Browse our elite directory of skilled teachers ready to share their expertise.</p>
    </div>

    <!-- PREMIUM SEARCH BAR -->
    <div class="search-container" style="max-width: 1000px; margin: 0 auto 4rem auto;">
        <form method="GET" action="{{ route('teachers.index') }}" class="premium-search">
            <input type="search" name="q" placeholder="Search by name or skill..." value="{{ request('q') }}" class="search-input">
            <select name="category" class="search-select">
                <option value="">All Categories</option>
                @if(isset($categories))
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                @endif
            </select>
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <div class=" teacher-grid">
        @forelse ($teachers as $teacher)
            <div class="teacher-premium-card">
                <div class="card-inner">
                    <div class="avatar-wrapper">
                        <img src="{{ $teacher->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($teacher->name).'&background=000&color=fff' }}" alt="{{ $teacher->name }}" class="teacher-avatar">
                    </div>
                    
                    <div class="teacher-info">
                        <div class="info-header">
                            <h3 class="teacher-name">{{ $teacher->name }}</h3>
                            <div class="rating-badge">
                                @if($teacher->average_rating)
                                    <span class="star">★</span> <span class="score">{{ number_format($teacher->average_rating, 1) }}</span>
                                    <span class="count">({{ $teacher->reviews_count }})</span>
                                @else
                                    <span class="no-rating">New Teacher</span>
                                @endif
                            </div>
                        </div>
                        
                        <p class="teacher-bio">{{ Str::limit($teacher->bio ?? 'Ready to share my knowledge and help you grow in your chosen skill path.', 140) }}</p>
                        
                        <div class="skill-tags">
                            @foreach ($teacher->userSkills->take(4) as $us)
                                <span class="skill-pill">{{ $us->skill->title }}</span>
                            @endforeach
                            @if($teacher->userSkills->count() > 4)
                                <span class="skill-pill-more">+{{ $teacher->userSkills->count() - 4 }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('teachers.show', $teacher) }}" class="btn-profile">View Profile</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state-container">
                <div class="empty-icon">🔍</div>
                <h3>No teachers matching your search</h3>
                <p>Try different keywords or browse all teachers.</p>
                <a href="{{ route('teachers.index') }}" class="btn primary">Show All Teachers</a>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pagination-container">
        {{ $teachers->withQueryString()->links() }}
    </div>

</section>

<style>
    /* ── PAGE HERO ─────────────────────────────────────────────────── */
    .dashboard-header h1 {
        font-size: 3rem;
        font-weight: 900;
        letter-spacing: -1.5px;
        color: var(--text-slate);
        margin-bottom: 0.75rem;
    }
    .dashboard-header p {
        font-size: 1.1rem;
        color: #64748b;
        font-weight: 500;
    }

    /* ── SEARCH BAR (text centering fix) ───────────────────────────── */
    .premium-search {
        display: flex;
        align-items: stretch;
        border: 2.5px solid var(--primary-teal);
        border-radius: 50px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 8px 30px rgba(32, 166, 138, 0.12);
        height: 58px;           /* fixed height so the button fills it */
    }

    .premium-search:focus-within {
        box-shadow: 0 10px 40px rgba(32, 166, 138, 0.22);
        border-color: var(--primary-teal-dark);
    }

    .search-input {
        flex: 1;
        border: none;
        padding: 0 28px;
        font-size: 1rem;
        font-family: inherit;
        outline: none;
        background: transparent;
        color: var(--text-slate);
        /* vertical centering for <input> elements */
        line-height: 58px;
        height: 58px;
        vertical-align: middle;
    }

    .search-input::placeholder {
        color: #a0aec0;
    }

    .search-btn {
        background: var(--primary-teal);
        color: #fff;
        border: none;
        padding: 0 36px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.88rem;
        cursor: pointer;
        /* no hover transform / color shift */
        transition: none;
        flex-shrink: 0;
    }

    .search-select {
        flex: none;
        width: 170px;
        border: none;
        border-left: 1.5px solid var(--primary-teal-light);
        padding: 0 15px 0 20px;
        outline: none;
        font-weight: 600;
        color: #64748b;
        background: transparent;
        font-family: inherit;
        font-size: 0.95rem;
        cursor: pointer;
        height: 58px;
        text-overflow: ellipsis;
    }


    /* ── TEACHER CARDS ─────────────────────────────────────────────── */
    .teacher-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .teacher-premium-card {
        background: #fff;
        border: 1.5px solid var(--primary-teal-light);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .card-inner {
        display: flex;
        align-items: center;
        gap: 2.5rem;
    }

    .avatar-wrapper { flex-shrink: 0; }

    .teacher-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 3px solid var(--primary-teal-light);
        object-fit: cover;
        background: #f8fafc;
    }

    .teacher-info { flex-grow: 1; }

    .info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .teacher-name {
        font-size: 1.6rem;
        font-weight: 900;
        margin: 0;
        color: var(--text-slate);
        letter-spacing: -0.5px;
    }

    .rating-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: var(--bg-light-teal);
        border: 1px solid var(--primary-teal-light);
        padding: 5px 14px;
        border-radius: 50px;
    }

    .star   { color: var(--primary-teal); font-size: 1.1rem; }
    .score  { font-weight: 800; font-size: 0.9rem; color: var(--text-slate); }
    .count  { color: #64748b; font-size: 0.82rem; }
    .no-rating {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--primary-teal);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .teacher-bio {
        color: #64748b;
        line-height: 1.65;
        margin-bottom: 1.25rem;
        font-size: 0.97rem;
        max-width: 680px;
    }

    /* skill pills — NO hover */
    .skill-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .skill-pill {
        background: var(--bg-light-teal);
        color: var(--primary-teal);
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid var(--primary-teal-light);
    }

    .skill-pill-more {
        background: #f1f5f9;
        color: #64748b;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
    }

    /* View Profile button — NO hover / NO transform */
    .btn-profile,
    .btn-profile:hover,
    .btn-profile:focus,
    .btn-profile:active,
    .btn-profile:visited {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-teal);
        color: #fff !important;
        text-decoration: none !important;
        padding: 13px 30px;
        border-radius: 50px;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
        white-space: nowrap;
        box-shadow: 0 4px 14px rgba(32, 166, 138, 0.22);
        transition: none;
        cursor: pointer;
    }

    /* ── EMPTY STATE ───────────────────────────────────────────────── */
    .empty-state-container {
        text-align: center;
        padding: 5rem 2rem;
        background: #fff;
        border: 2px dashed var(--primary-teal-light);
        border-radius: 24px;
    }
    .empty-icon { font-size: 3.5rem; margin-bottom: 1.5rem; }
    .empty-state-container h3 { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--text-slate); }
    .empty-state-container p  { color: #64748b; margin-bottom: 2rem; }

    /* ── PAGINATION ────────────────────────────────────────────────── */
    .pagination-container {
        margin-top: 3.5rem;
        display: flex;
        justify-content: center;
    }

    /* ── RESPONSIVE ────────────────────────────────────────────────── */
    @media (max-width: 900px) {
        .card-inner    { flex-direction: column; text-align: center; gap: 1.5rem; }
        .info-header   { flex-direction: column; gap: 0.75rem; }
        .skill-tags    { justify-content: center; }
        .card-actions  { margin-top: 1.2rem; }
    }
</style>

@endsection
