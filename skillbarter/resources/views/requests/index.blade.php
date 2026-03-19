@extends('app')

@section('content')

<section class="dashboard">



    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1>Skill Interactions</h1>
        <p>Manage your teaching offers and learning requests in one place.</p>
    </div>

    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 2px solid #000; padding-bottom: 1rem;">
        <a href="{{ route('requests.index', ['tab' => 'received']) }}" 
           style="padding: 0.6rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 700; transition: all 0.3s ease; {{ $tab === 'received' ? 'background: #000; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.2);' : 'background: #fff; color: #000; border: 1px solid #000;' }}">
            Received ({{ $received->count() }})
        </a>
        <a href="{{ route('requests.index', ['tab' => 'sent']) }}" 
           style="padding: 0.6rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 700; transition: all 0.3s ease; {{ $tab === 'sent' ? 'background: #000; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.2);' : 'background: #fff; color: #000; border: 1px solid #000;' }}">
            Sent ({{ $sent->count() }})
        </a>
    </div>

    @if($tab === 'received')
    <!-- RECEIVED REQUESTS -->
    <div class="dashboard-section">
        <h2>{{ auth()->user()->isTeacher() ? 'Inbound Student Requests' : 'Inbound Teacher Offers' }}</h2>
        <ul>
            @forelse($received as $request)
                <li style="padding: 2rem; background: #fff; border: 1px solid #eee; border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: transform 0.3s ease; list-style: none;">
                    <p style="margin: 0; font-size: 1.1rem; color: #000;">
                        <strong style="color: #000;">{{ $request->requester->name ?? 'Unknown' }}</strong>
                        @if($request->userSkill->type === 'offer')
                            offered to teach you
                        @else
                            wants to learn
                        @endif
                        <strong style="color: #000;">{{ $request->userSkill->skill->title ?? '' }}</strong>
                    </p>
                    @if($request->message)
                        <p style="color: #666; margin: 1rem 0; font-style: italic; background: #f9f9f9; padding: 1rem; border-left: 4px solid #000; border-radius: 4px;">"{{ $request->message }}"</p>
                    @endif
                    <div style="margin-top: 1rem;">
                        <span class="badge {{ $request->status }}" style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ ucfirst($request->status) }}</span>
                    </div>

                    @if($request->status === 'open')
                        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                            <form method="POST" action="{{ route('requests.accept', $request) }}">
                                @csrf
                                <button type="submit" class="btn primary small" style="background: #000; color: #fff; border: 1px solid #000; padding: 10px 25px; cursor: pointer; font-weight: 700;">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('requests.decline', $request) }}">
                                @csrf
                                <button type="submit" class="btn ghost small" style="background: #fff; color: #000; border: 1px solid #000; padding: 10px 25px; cursor: pointer; font-weight: 700;">Decline</button>
                            </form>
                        </div>
                    @endif



                    @if($request->status === 'accepted')
                        <div style="margin-top: 1.5rem; padding: 1.5rem; background: #fdfdfd; border: 1px solid #000; border-radius: 8px;">
                            <h4 style="margin-top: 0; color: #000;">Schedule this Session</h4>
                            <p style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">Set the date and time for your exchange with {{ $request->requester->name }}.</p>
                            
                            <form method="POST" action="{{ route('requests.schedule', $request) }}">
                                @csrf
                                <div style="display: flex; flex-direction: column; gap: 1rem;">
                                    <div>
                                        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">START DATE & TIME</label>
                                        <input type="datetime-local" name="start_time" required style="width: 100%; padding: 10px; border: 1px solid #000; border-radius: 4px;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">MEETING LINK (OPTIONAL)</label>
                                        <input type="url" name="meeting_link" placeholder="https://zoom.us/j/..." style="width: 100%; padding: 10px; border: 1px solid #000; border-radius: 4px;">
                                    </div>
                                    <button type="submit" class="btn primary" style="background: #000; color: #fff; border: none; padding: 12px; font-weight: 700; cursor: pointer;">Confirm Schedule & Create Session</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if($request->status === 'scheduled')
                        @php $session = \App\Models\SessionModel::where('request_id', $request->id)->first(); @endphp
                        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                            @if($session)
                                <a href="{{ route('session.classroom', $session->id) }}" class="btn primary small" style="background: #000; color: #fff; border: 1px solid #000; padding: 10px 25px; text-decoration: none; display: inline-block; font-weight: 700;">Enter Classroom</a>
                            @endif
                            <form method="POST" action="{{ route('requests.complete', $request) }}">
                                @csrf
                                <button type="submit" class="btn ghost small" style="background: #fff; color: #000; border: 1px solid #000; padding: 10px 25px; cursor: pointer; font-weight: 700;">Mark Complete</button>
                            </form>
                        </div>
                    @endif
                </li>
            @empty
                <li class="empty">No student requests yet.</li>
            @endforelse
        </ul>
    </div>
    @else
    <!-- SENT REQUESTS -->
    <div class="dashboard-section">
        <h2>{{ auth()->user()->isTeacher() ? 'Offers Sent to Students' : 'Requests Sent to Teachers' }}</h2>
        <ul>
            @forelse($sent as $request)
                <li style="padding: 2rem; background: #fff; border: 1px solid #eee; border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: transform 0.3s ease; list-style: none;">
                    <p style="margin: 0; font-size: 1.1rem; color: #000;">
                        @if($request->userSkill->type === 'offer')
                            You offered to teach <strong style="color: #000;">{{ $request->responder->name ?? 'Unknown' }}</strong>
                        @else
                            Request to <strong style="color: #000;">{{ $request->responder->name ?? 'Unknown' }}</strong>
                        @endif
                        for <strong style="color: #000;">{{ $request->userSkill->skill->title ?? '' }}</strong>
                    </p>
                    @if($request->message)
                        <p style="color: #666; margin: 1rem 0; font-style: italic; background: #f9f9f9; padding: 1rem; border-left: 4px solid #000; border-radius: 4px;">"{{ $request->message }}"</p>
                    @endif
                    <div style="margin-top: 1rem;">
                        <span class="badge {{ $request->status }}" style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ ucfirst($request->status) }}</span>
                    </div>

                    @if(in_array($request->status, ['open', 'accepted']))
                        <form method="POST" action="{{ route('requests.cancel', $request) }}" style="margin-top: 1.5rem;">
                            @csrf
                            <button type="submit" class="btn ghost small" style="background: #fff; color: #000; border: 1px solid #000; padding: 10px 25px; cursor: pointer; font-weight: 700;">Cancel Request</button>
                        </form>
                    @endif

                    

                    @if($request->status === 'accepted')
                        <div style="margin-top: 1.5rem; padding: 1.5rem; background: #fdfdfd; border: 1px solid #eee; border-radius: 8px; text-align: center;">
                            <p style="margin: 0; color: #666; font-style: italic;">Waiting for the teacher to schedule the session time...</p>
                        </div>
                    @endif

                    @if($request->status === 'scheduled')
                        @php $session = \App\Models\SessionModel::where('request_id', $request->id)->first(); @endphp
                        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                            @if($session)
                                <a href="{{ route('session.classroom', $session->id) }}" class="btn primary small" style="background: #000; color: #fff; border: 1px solid #000; padding: 10px 25px; text-decoration: none; display: inline-block; font-weight: 700;">Enter Classroom</a>
                            @endif
                        </div>
                    @endif
                </li>
            @empty
                <li class="empty">You haven't sent any requests yet.</li>
            @endforelse
        </ul>
    </div>
    @endif

</section>

@endsection
