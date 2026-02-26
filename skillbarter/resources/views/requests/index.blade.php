@extends('layouts.app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Session Requests</h1>
        <p>Manage your teaching and learning requests</p>
    </div>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <!-- Tab Navigation -->
    @php
        $tab = $tab ?? (auth()->user()->isTeacher() ? 'received' : 'sent');
    @endphp

    <div class="dashboard-actions" style="margin-bottom: 2rem;">
        @if(auth()->user()->isTeacher())
            <a href="{{ route('requests.index', ['tab' => 'received']) }}"
               class="btn {{ $tab === 'received' ? 'primary' : 'ghost' }}">
                Received ({{ $received->count() }})
            </a>
        @else
            <a href="{{ route('requests.index', ['tab' => 'sent']) }}"
               class="btn {{ $tab === 'sent' ? 'primary' : 'ghost' }}">
                Sent ({{ $sent->count() }})
            </a>
        @endif
    </div>

    @if(! auth()->user()->isTeacher())
        <div style="margin-bottom:1rem;">
            <div class="alert info">
                When a teacher accepts your request you will be notified here and via Notifications. You can also open the request details to see status changes.
            </div>
        </div>
    @endif

    @if($tab === 'received')
    <!-- RECEIVED REQUESTS -->
    <div class="dashboard-section">
        <h2>Requests Received</h2>
        <ul>
            @forelse($received as $request)
                <li style="padding: 1rem; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 1rem;">
                    <p>
                        <strong>{{ $request->requester->name ?? 'Unknown' }}</strong>
                        wants to learn
                        <strong>{{ $request->userSkill->skill->title ?? '' }}</strong>
                    </p>
                    @if($request->message)
                        <p style="color: #666; margin: 0.5rem 0;">{{ $request->message }}</p>
                    @endif
                    <p>
                        <span class="badge {{ $request->status }}">{{ ucfirst($request->status) }}</span>
                    </p>

                    @if($request->status === 'open')
                        <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                            <form method="POST" action="{{ route('requests.accept', $request) }}">
                                @csrf
                                <button type="submit" class="btn primary small">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('requests.decline', $request) }}">
                                @csrf
                                <button type="submit" class="btn ghost small">Decline</button>
                            </form>
                        </div>
                    @endif

                    <div style="margin-top:0.5rem;display:flex;gap:0.5rem;align-items:center;">
                        <a href="{{ route('chat.show', $request) }}" class="btn small">Open Chat</a>
                    </div>

                    @if($request->status === 'accepted')
                        <form method="POST" action="{{ route('requests.complete', $request) }}" style="margin-top: 0.5rem;">
                            @csrf
                            <button type="submit" class="btn primary small">Mark Complete</button>
                        </form>
                    @endif
                </li>
            @empty
                <li class="empty">No requests received.</li>
            @endforelse
        </ul>
    </div>
    @else
    <!-- SENT REQUESTS -->
    <div class="dashboard-section">
        <h2>Requests Sent</h2>
        <ul>
            @forelse($sent as $request)
                <li style="padding: 1rem; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 1rem;">
                    <p>
                        Request to <strong>{{ $request->responder->name ?? 'Unknown' }}</strong>
                        for <strong>{{ $request->userSkill->skill->title ?? '' }}</strong>
                    </p>
                    @if($request->message)
                        <p style="color: #666; margin: 0.5rem 0;">{{ $request->message }}</p>
                    @endif
                    <p>
                        <span class="badge {{ $request->status }}">{{ ucfirst($request->status) }}</span>
                    </p>

                    @if(in_array($request->status, ['open', 'accepted']))
                        <form method="POST" action="{{ route('requests.cancel', $request) }}" style="margin-top: 0.5rem;">
                            @csrf
                            <button type="submit" class="btn ghost small">Cancel</button>
                        </form>
                    @endif

                    <div style="margin-top:0.5rem;display:flex;gap:0.5rem;align-items:center;">
                        <a href="{{ route('chat.show', $request) }}" class="btn small">Open Chat</a>
                    </div>

                    @if($request->status === 'accepted')
                        <form method="POST" action="{{ route('requests.complete', $request) }}" style="margin-top: 0.5rem;">
                            @csrf
                            <button type="submit" class="btn primary small">Mark Complete</button>
                        </form>
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
