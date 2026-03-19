@extends('app')

@section('content')
<section class="dashboard">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1>Your Sessions</h1>
        <p>Active teaching and learning sessions.</p>
    </div>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <div style="display: flex; flex-direction: column; gap: 3rem;">
        
        <!-- LEARNING SECTION (Prioritized for Students) -->
        @if(count($learningSessions) > 0 || !auth()->user()->isTeacher())
        <div class="dashboard-section">
            <h2 style="border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px;">📘 MY LEARNING SESSIONS</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
                @forelse($learningSessions as $session)
                    <div style="padding: 24px; background: #fff; border: 2px solid #000; border-radius: 12px; color: #000; position: relative; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        @if($session->is_live)
                            <span style="position: absolute; top: -10px; right: 10px; background: #000; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; border: 2px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">LIVE NOW</span>
                        @endif
                        
                        <h3 style="margin: 0 0 10px 0; font-size: 1.4rem; font-weight: 800; text-transform: uppercase; letter-spacing: -0.5px;">{{ $session->skill->title ?? 'Skill' }}</h3>
                        <p style="margin: 5px 0; color: #666;">Teacher: <strong style="color: #000;">{{ $session->teacher->name }}</strong></p>
                        
                        @if($session->start_time)
                            <p style="margin: 15px 0; font-size: 13px; color: #000; background: #f5f5f5; padding: 10px 15px; border-radius: 8px; font-weight: 600;">
                                📅 Scheduled: {{ \Carbon\Carbon::parse($session->start_time)->format('M d, Y @ h:i A') }}
                            </p>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                            <span class="badge {{ $session->status }}" style="padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: 900; text-transform: uppercase; border: 2px solid #000;">{{ $session->status }}</span>
                            <a href="{{ route('session.classroom', $session->id) }}" style="background: #000; color: #fff; border: 2px solid #000; padding: 10px 25px; text-decoration: none; font-weight: 800; font-size: 12px; text-transform: uppercase; transition: 0.3s; display: inline-block;">
                                {{ $session->is_live ? '⚡ JOIN LIVE' : 'ENTER CLASSROOM' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; padding: 40px; background: #fdfdfd; border: 1px dashed #ccc; text-align: center; border-radius: 12px;">
                        <p style="color: #888; margin-bottom: 15px;">You haven't requested any sessions yet.</p>
                        <a href="{{ route('find-skill') }}" class="btn primary">FIND A SKILL TO LEARN</a>
                    </div>
                @endforelse
            </div>
        </div>
        @endif

        <!-- TEACHING SECTION (Prioritized for Teachers) -->
        @if(auth()->user()->isTeacher() || count($teachingSessions) > 0)
        <div class="dashboard-section">
            <h2 style="border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; color: #666; font-size: 1.5rem; font-weight: 700;">🎓 MY TEACHING SESSIONS</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
                @forelse($teachingSessions as $session)
                    <div style="padding: 24px; background: #fff; border: 1px solid #000; border-radius: 12px; color: #000; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.03); position: relative;">
                        @if($session->is_live)
                            <span style="position: absolute; top: -10px; right: 10px; background: #000; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; border: 2px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">LIVE NOW</span>
                        @endif
                        
                        <h3 style="margin: 0 0 10px 0; font-size: 1.25rem; font-weight: 700;">{{ $session->skill->title ?? 'Skill' }}</h3>
                        <p style="margin: 5px 0; color: #666;">Student: <strong style="color: #000;">{{ $session->student->name }}</strong></p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #eee;">
                            <span class="badge {{ $session->status }}" style="padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: 900; text-transform: uppercase; border: 2px solid #000;">{{ $session->status }}</span>
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('session.classroom', $session->id) }}" style="background: #000; color: #fff; border: 2px solid #000; padding: 8px 18px; text-decoration: none; font-weight: 800; font-size: 12px; text-transform: uppercase; transition: 0.3s;">MANAGE CLASS</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; padding: 40px; background: #fdfdfd; border: 1px dashed #eee; text-align: center; border-radius: 12px; color: #aaa;">
                        <p>You aren't teaching any sessions at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
        @endif
    </div>
</section>

<style>
    .badge.scheduled { background: #eee; color: #333; }
    .badge.live { background: #e8f5e9; color: #2e7d32; }
    .badge.completed { background: #000; color: #fff; }
</style>
@endsection
