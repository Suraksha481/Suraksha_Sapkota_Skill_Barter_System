@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Smart Skill Matches</h1>
        <p>We've analyzed your skills and found the best potential matches for you to learn and teach! Matches are scored based on mutual needs, high ratings, and activity levels.</p>
    </div>

    @if($matches->isEmpty())
        <div class="dashboard-section" style="text-align: center; padding: 3rem 1rem;">
            <h2>No Matches Found Yet</h2>
            <p style="color: #64748b; margin-bottom: 2rem;">We couldn't find any perfect matches right now. Try adding more skills to your profile or check back later as new users join!</p>
            <a href="{{ route('my.skills') }}" class="btn primary">Update My Skills</a>
        </div>
    @else
        <div class="teacher-list">
            @foreach($matches as $match)
                <div class="teacher-card" style="position: relative; overflow: hidden; {{ $match->match_score >= 100 ? 'border: 2px solid #f59e0b; background: rgba(245, 158, 11, 0.05);' : '' }}">
                    
                    @if($match->match_score >= 100)
                        <div style="position: absolute; top: 10px; right: -30px; background: #f59e0b; color: white; padding: 5px 35px; transform: rotate(45deg); font-weight: bold; font-size: 0.8rem; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            TOP MATCH
                        </div>
                    @endif

                    <div style="display:flex; align-items:flex-start; gap:1.5rem; width: 100%;">
                        <img src="{{ $match->avatar ?? 'https://via.placeholder.com/80' }}" alt="{{ $match->name }}" style="width:80px; height:80px; border-radius:8px; object-fit:cover;">
                        
                        <div style="flex-grow: 1;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                <div>
                                    <h3 style="margin-top:0; margin-bottom:0.25rem;">{{ $match->name }}</h3>
                                    
                                    <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                                        <div style="color:#f59e0b; font-size:1rem;">
                                            @if($match->avg_rating > 0)
                                                ★ {{ number_format($match->avg_rating, 1) }}
                                            @else
                                                <span style="color:#cbd5e1; font-size:0.9rem;">No ratings yet</span>
                                            @endif
                                        </div>
                                    </div>
                                    <p style="margin:0; color:#666; line-height:1.4;">{{ Str::limit($match->bio ?? 'No bio available.', 80) }}</p>
                                </div>
                                <div style="text-align: right;">
                                    <div style="background: #1e293b; color: #38bdf8; padding: 5px 10px; border-radius: 8px; font-weight: bold; font-size: 1.2rem; margin-bottom: 5px; border: 1px solid #38bdf8;">
                                        {{ $match->match_score }} <span style="font-size: 0.8rem; color: #94a3b8;">pts</span>
                                    </div>
                                    <a href="{{ route('teachers.show', $match) }}" class="btn small">View Profile</a>
                                </div>
                            </div>
                            
                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                                <strong style="font-size: 0.85rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">Why it's a match:</strong>
                                <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem; color: #e2e8f0; font-size: 0.9rem;">
                                    @foreach($match->match_reasons as $reason)
                                        <li>{{ $reason }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</section>

@endsection
