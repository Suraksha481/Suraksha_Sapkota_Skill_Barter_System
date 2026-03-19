@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header" style="text-align: center; margin-bottom: 4rem;">
        <h1 style="font-size: 3rem; font-weight: 800; letter-spacing: -1px;">Find Your Mentor</h1>
        <p style="font-size: 1.1rem; color: #666;">Browse our elite directory of skilled teachers ready to share their expertise.</p>
    </div>

    <!-- PREMIUM SEARCH BAR -->
    <div class="search-container" style="max-width: 600px; margin: 0 auto 4rem auto;">
        <form method="GET" action="{{ route('teachers.index') }}" class="premium-search">
            <input type="search" name="q" placeholder="Search by name or skill..." value="{{ request('q') }}" class="search-input">
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
    .premium-search {
        display: flex;
        gap: 0;
        border: 2px solid #000;
        border-radius: 50px;
        overflow: hidden;
        background: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .premium-search:focus-within {
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .search-input {
        flex-grow: 1;
        border: none;
        padding: 15px 25px;
        font-size: 1rem;
        outline: none;
        background: transparent;
    }

    .search-btn {
        background: #000;
        color: #fff;
        border: none;
        padding: 0 35px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .search-btn:hover {
        background: #333;
    }

    .teacher-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .teacher-premium-card {
        background: #fff;
        border: 2px solid #000;
        border-radius: 16px;
        padding: 2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }



    .card-inner {
        display: flex;
        align-items: center;
        gap: 2.5rem;
    }

    .avatar-wrapper {
        flex-shrink: 0;
    }

    .teacher-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #000;
        padding: 4px;
        object-fit: cover;
        background: #fff;
    }

    .teacher-info {
        flex-grow: 1;
    }

    .info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .teacher-name {
        font-size: 1.75rem;
        font-weight: 900;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .rating-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f9f9f9;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #eee;
    }

    .star { color: #000; font-size: 1.2rem; }
    .score { font-weight: 800; font-size: 1rem; }
    .count { color: #888; font-size: 0.85rem; }
    .no-rating { font-size: 0.85rem; font-weight: 700; color: #aaa; text-transform: uppercase; }

    .teacher-bio {
        color: #555;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        max-width: 700px;
    }

    .skill-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .skill-pill {
        background: #000;
        color: #fff;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid #000;
        transition: all 0.2s;
    }


    .skill-pill-more {
        background: #f1f1f1;
        color: #666;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-profile {
        display: inline-block;
        background: #000;
        color: #fff;
        text-decoration: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        border: 2px solid #000;
        transition: all 0.3s;
        white-space: nowrap;
    }

   

    .empty-state-container {
        text-align: center;
        padding: 6rem 2rem;
        background: #fff;
        border: 2px dashed #000;
        border-radius: 24px;
    }

    .empty-icon { font-size: 4rem; margin-bottom: 1.5rem; }
    .empty-state-container h3 { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; }
    .empty-state-container p { color: #666; margin-bottom: 2rem; }

    .pagination-container {
        margin-top: 4rem;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 900px) {
        .card-inner {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }
        
        .info-header {
            flex-direction: column;
            gap: 1rem;
        }
        
    }
</style>

@endsection
