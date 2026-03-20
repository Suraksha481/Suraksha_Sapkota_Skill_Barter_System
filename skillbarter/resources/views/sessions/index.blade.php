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
            <h2 style="border-bottom: 2px solid var(--primary-teal); padding-bottom: 12px; margin-bottom: 25px; color: var(--text-dark); font-weight: 800;">📘 MY LEARNING SESSIONS</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
                @forelse($learningSessions as $session)
                    <div style="padding: 24px; background: #fff; border: 1px solid var(--primary-teal-light); border-radius: 16px; color: var(--text-dark); position: relative; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                        @if($session->is_live)
                            <span style="position: absolute; top: -10px; right: 10px; background: var(--primary-teal); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(32, 166, 138, 0.2);">LIVE NOW</span>
                        @endif
                        
                        <h3 style="margin: 0 0 10px 0; font-size: 1.4rem; font-weight: 800; text-transform: uppercase; letter-spacing: -0.5px;">{{ $session->skill->title ?? 'Skill' }}</h3>
                        <p style="margin: 5px 0; color: #666;">Teacher: <strong style="color: #000;">{{ $session->teacher->name }}</strong></p>
                        
                        @if($session->start_time)
                            <p style="margin: 15px 0; font-size: 13px; color: #000; background: #f5f5f5; padding: 10px 15px; border-radius: 8px; font-weight: 600;">
                                📅 Scheduled: {{ \Carbon\Carbon::parse($session->start_time)->format('M d, Y @ h:i A') }}
                            </p>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                            <span class="badge {{ $session->status }}" style="padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 800; text-transform: uppercase; border: 1px solid var(--primary-teal-light); background: var(--bg-light-teal); color: var(--primary-teal);">{{ $session->status }}</span>
                            <a href="{{ route('session.classroom', $session->id) }}" class="btn primary" style="padding: 10px 20px; font-size: 12px;">
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
            <h2 style="border-bottom: 2px solid var(--primary-teal); padding-bottom: 12px; margin-bottom: 25px; color: var(--text-dark); font-weight: 800;">🎓 MY TEACHING SESSIONS</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
                @forelse($teachingSessions as $session)
                    <div style="padding: 24px; background: #fff; border: 1px solid var(--primary-teal-light); border-radius: 16px; color: var(--text-dark); position: relative; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                        @if($session->is_live)
                            <span style="position: absolute; top: -10px; right: 10px; background: var(--primary-teal); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(32, 166, 138, 0.2);">LIVE NOW</span>
                        @endif
                        
                        <h3 style="margin: 0 0 10px 0; font-size: 1.25rem; font-weight: 700;">{{ $session->skill->title ?? 'Skill' }}</h3>
                        <p style="margin: 5px 0; color: #666;">Student: <strong style="color: #000;">{{ $session->student->name }}</strong></p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f5f5f5;">
                            <span class="badge {{ $session->status }}" style="padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 800; text-transform: uppercase; border: 1px solid var(--primary-teal-light); background: var(--bg-light-teal); color: var(--primary-teal);">{{ $session->status }}</span>
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('session.classroom', $session->id) }}" class="btn primary" style="padding: 8px 18px; font-size: 12px;">MANAGE CLASS</a>
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
