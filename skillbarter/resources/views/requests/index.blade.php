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
        <p>{{ auth()->user()->isTeacher() ? 'Manage your inbound student requests.' : 'Manage your learning requests to teachers.' }}</p>
    </div>

    @if(auth()->user()->isTeacher())
    <!-- RECEIVED REQUESTS FOR TEACHERS -->
    <div class="dashboard-section">
        <h2>Inbound Student Requests</h2>
        <ul>
            @forelse($received as $request)
                <li style="padding: 2rem; background: #fff; border: 1px solid #eee; border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: transform 0.3s ease; list-style: none;">
                    <p style="margin: 0; font-size: 1.1rem; color: var(--text-slate);">
                        <strong style="color: var(--text-slate);">{{ $request->requester->name ?? 'Unknown' }}</strong>
                        @if($request->userSkill->type === 'offer')
                            offered to teach you
                        @else
                            wants to learn
                        @endif
                        <strong style="color: var(--text-slate);">{{ $request->userSkill->skill->title ?? '' }}</strong>
                    </p>
                    @if($request->message)
                        <p style="color: var(--text-secondary); margin: 1rem 0; font-style: italic; background: var(--bg-light-teal); padding: 1.25rem; border-left: 4px solid var(--primary-teal); border-radius: 8px; font-weight: 500;">"{{ $request->message }}"</p>
                    @endif
                    <div style="margin-top: 1rem;">
                        <span class="badge {{ $request->status }}" style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ ucfirst($request->status) }}</span>
                    </div>

                    @if($request->status === 'open')
                        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                            <form method="POST" action="{{ route('requests.accept', $request) }}">
                                @csrf
                                <button type="submit" class="btn-pill primary" style="border:none; cursor:pointer;">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('requests.decline', $request) }}">
                                @csrf
                                <button type="submit" class="btn-pill secondary" style="cursor:pointer;">Decline</button>
                            </form>
                        </div>
                    @endif



                    @if($request->status === 'accepted')
                        <div style="margin-top: 1.5rem; padding: 2rem; background: #fff; border: 2px solid var(--primary-teal); border-radius: 16px; box-shadow: 0 10px 30px rgba(32, 166, 138, 0.1);">
                            <h4 style="margin-top: 0; color: var(--primary-teal); font-weight: 800;">Schedule this Session</h4>
                            <p style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">Set the date and time for your exchange with {{ $request->requester->name }}.</p>
                            
                            <form method="POST" action="{{ route('requests.schedule', $request) }}">
                                @csrf
                                <div style="display: flex; flex-direction: column; gap: 1rem;">
                                    <div>
                                        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">START DATE & TIME</label>
                                        <input type="datetime-local" name="start_time" required style="width: 100%; padding: 12px; border: 1px solid var(--primary-teal-light); border-radius: 8px; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--primary-teal)'">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">MEETING LINK (OPTIONAL)</label>
                                        <input type="url" name="meeting_link" placeholder="https://zoom.us/j/..." style="width: 100%; padding: 12px; border: 1px solid var(--primary-teal-light); border-radius: 8px; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--primary-teal)'">
                                    </div>
                                    <button type="submit" class="btn-pill primary" style="width:100%; border:none; padding:12px; cursor:pointer;">Confirm Schedule & Create Session</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if($request->status === 'scheduled')
                        @php $session = \App\Models\SessionModel::where('request_id', $request->id)->first(); @endphp
                        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                            @if($session)
                                <a href="{{ route('session.classroom', $session->id) }}" class="btn-pill primary" style="text-decoration:none;">Enter Classroom</a>
                            @endif
                            <form method="POST" action="{{ route('requests.complete', $request) }}">
                                @csrf
                                <button type="submit" class="btn-pill secondary" style="cursor:pointer;">Mark Complete</button>
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
    <!-- SENT REQUESTS FOR STUDENTS -->
    <div class="dashboard-section">
        <h2>Requests Sent to Teachers</h2>
        <ul>
            @forelse($sent as $request)
                <li style="padding: 2rem; background: #fff; border: 1px solid #eee; border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: transform 0.3s ease; list-style: none;">
                    <p style="margin: 0; font-size: 1.1rem; color: #000;">
                        Request to <strong style="color: #000;">{{ $request->responder->name ?? 'Unknown' }}</strong>
                        for <strong style="color: #000;">{{ $request->userSkill->skill->title ?? '' }}</strong>
                    </p>
                    @if($request->message)
                        <p style="color: var(--text-secondary); margin: 1rem 0; font-style: italic; background: var(--bg-light-teal); padding: 1.25rem; border-left: 4px solid var(--primary-teal); border-radius: 8px; font-weight: 500;">"{{ $request->message }}"</p>
                    @endif
                    <div style="margin-top: 1rem;">
                        <span class="badge {{ $request->status }}" style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ ucfirst($request->status) }}</span>
                    </div>

                    @if(in_array($request->status, ['open', 'accepted']))
                        <form method="POST" action="{{ route('requests.cancel', $request) }}" style="margin-top: 1.5rem;">
                            @csrf
                            <button type="submit" class="btn-pill secondary" style="cursor:pointer;">Cancel Request</button>
                        </form>
                    @endif

                    

                    @if($request->status === 'accepted')
                        <div style="margin-top: 1.5rem; padding: 1.5rem; background: var(--bg-light-teal); border: 1px solid var(--primary-teal-light); border-radius: 12px; text-align: center;">
                            <p style="margin: 0; color: #666; font-style: italic;">Waiting for the teacher to schedule the session time...</p>
                        </div>
                    @endif

                    @if($request->status === 'scheduled')
                        @php $session = \App\Models\SessionModel::where('request_id', $request->id)->first(); @endphp
                        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem; flex-wrap: wrap;">
                            @if($session)
                                <a href="{{ route('session.classroom', $session->id) }}" class="btn-pill primary" style="text-decoration:none;">Enter Classroom</a>
                            @endif
                            <a href="{{ route('disputes.create', $request->id) }}"
                               style="display: inline-flex; align-items: center; padding: 10px 22px; border-radius: 50px; border: 2px solid #fca5a5; color: #dc2626; font-weight: 700; font-size: 0.85rem; text-decoration: none; background: #fff; transition: background 0.3s;"
                               title="Something went wrong? Report this session to our admin.">
                                Report Issue
                            </a>
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
