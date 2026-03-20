@extends('app')

@section('content')
<style>
    .classroom-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        background: #fff;
        color: #000;
        font-family: 'Inter', sans-serif;
    }

    .card {
        background: #fff;
        border: 2px solid #000;
        border-radius: 0;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .card-header {
        background: #000;
        color: #fff;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-body {
        padding: 25px;
    }

    .btn-bw {
        background: #000;
        color: #fff;
        border: 2px solid #000;
        padding: 12px 24px;
        text-decoration: none;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        display: inline-block;
    }

    .btn-outline {
        background: #fff;
        color: #000;
        border: 2px solid #000;
        padding: 8px 16px;
        text-decoration: none;
        font-weight: 700;
        cursor: pointer;
    }

    .badge-bw {
        border: 1px solid #000;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .input-bw {
        border: 2px solid #000;
        padding: 10px;
        width: 100%;
        margin-top: 5px;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    @media (max-width: 768px) {
        .grid-2 { grid-template-columns: 1fr; }
    }

    .material-list, .practice-list {
        list-style: none;
        padding: 0;
    }

    .list-item {
        border-bottom: 1px solid #eee;
        padding: 15px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .alert-bw {
        border: 2px solid #000;
        padding: 15px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* Override for better visibility */
    .btn-primary-bw {
        background: #000;
        color: #fff;
        border: 2px solid #000;
        padding: 15px 30px;
        text-decoration: none;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
        text-align: center;
    }
    
    .btn-secondary-bw {
        background: #fff;
        color: #000;
        border: 2px solid #000;
        padding: 15px 30px;
        text-decoration: none;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
        text-align: center;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid #000;
    }
</style>

<div class="classroom-container">

    @if(session('success'))
        <div class="alert-bw" style="border-color: #000;">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <div>
                <h1 style="margin: 0; font-size: 24px;">CLASSROOM ({{ auth()->id() === $session->organiser_id ? 'TEACHER VIEW' : 'STUDENT VIEW' }})</h1>
                <small>{{ $session->skill->title ?? 'Session' }}</small>
            </div>
            <div class="badge-bw" style="background: #fff; color: #000;">
                {{ $session->status }}
            </div>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 20px;">
                <div style="display: flex; gap: 40px; align-items: flex-start;">
                    <div>
                        <label style="display: block; font-size: 12px; color: #666;">TEACHER</label>
                        <strong>{{ $session->teacher->name }}</strong>
                        @if(auth()->id() !== $session->organiser_id)
                            <a href="{{ route('messenger.index') }}?user={{ $session->organiser_id }}" class="btn-outline" style="font-size: 10px; margin-left:10px; padding: 2px 8px;">CHAT</a>
                        @endif
                    </div>
                    <div style="flex-grow: 1;">
                        <label style="display: block; font-size: 12px; color: #666;">STUDENTS IN THIS CLASS</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 5px;">
                            @forelse($session->participants as $p)
                                <div style="display: flex; align-items: center; border: 1px solid #000; padding: 5px 12px;">
                                    <strong>{{ $p->name }}</strong>
                                    @if(auth()->id() === $session->organiser_id && $p->id !== auth()->id())
                                        <a href="{{ route('messenger.index') }}?user={{ $p->id }}" class="btn-outline" style="font-size: 10px; margin-left:10px; padding: 2px 8px;">CHAT</a>
                                    @endif
                                </div>
                            @empty
                                <span style="color: #888;">No students attached to this session yet.</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if(auth()->id() === $session->organiser_id)
                    <div style="background: #f9f9f9; padding: 15px; border: 1px dashed #000;">
                        <form action="{{ route('session.add-participant', $session->id) }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                            @csrf
                            <label style="font-size: 12px; font-weight: bold;">ADD ANOTHER ACCEPTED STUDENT:</label>
                            <select name="user_id" required style="padding: 8px; border: 2px solid #000;">
                                <option value="">Select Student...</option>
                                @php
                                    $acceptedRequests = \App\Models\RequestModel::where('responder_id', auth()->id())
                                        ->where('status', 'accepted')
                                        ->where('user_skill_id', $session->request->user_skill_id ?? 0)
                                        ->with('requester')
                                        ->get();
                                @endphp
                                @foreach($acceptedRequests as $ar)
                                    @if(!$session->participants->contains($ar->requester_id))
                                        <option value="{{ $ar->requester_id }}">{{ $ar->requester->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <button type="submit" class="btn-bw" style="padding: 8px 15px; font-size: 12px;">ADD TO CLASS</button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- MEETING LINK SECTION -->
            <div style="border-top: 2px solid #000; padding-top: 25px; margin-top: 20px;">
                @if($session->status === 'completed')
                    <div style="padding: 40px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 12px; text-align: center;">
                        <h2 style="color: #28a745; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Session Completed</h2>
                        <p style="color: #666; font-size: 16px;">This session has ended. Materials and chat remain available below.</p>
                        @if(auth()->id() === $session->participant_id)
                            <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">
                            <a href="{{ route('feedback.create', ['session_id' => $session->id]) }}" class="btn primary" style="padding: 12px 30px;">RATE YOUR TEACHER</a>
                        @endif
                    </div>
                @else
                    @if(auth()->id() === $session->organiser_id)
                        <!-- TEACHER VIEW -->
                        <div style="background: #fff; border: 1px solid #000; padding: 25px; border-radius: 8px;">
                            <h3 style="margin-top: 0; font-size: 16px; text-transform: uppercase; margin-bottom: 20px;">Live Class Controls</h3>
                            
                            <form action="{{ route('session.update-link', $session->id) }}" method="POST" style="margin-bottom: 25px; background: #fdfdfd; padding: 15px; border: 1px solid #eee;">
                                @csrf
                                <label style="display: block; font-size: 12px; font-weight: bold; margin-bottom: 8px;">MEETING LINK (Zoom, Google Meet, etc.)</label>
                                <div style="display: flex; gap: 10px;">
                                    <input type="url" name="meeting_link" value="{{ $session->meeting_link }}" placeholder="https://zoom.us/j/..." required style="flex-grow: 1; padding: 10px; border: 1px solid #000; border-radius: 4px;">
                                    <button type="submit" class="btn primary">@if($session->meeting_link) UPDATE LINK @else SAVE LINK @endif</button>
                                </div>
                            </form>

                            @if($session->meeting_link)
                                <div style="text-align: center; padding: 30px; border: 2px solid #000; background: {{ $session->is_live ? '#000' : '#fff' }}; color: {{ $session->is_live ? '#fff' : '#000' }}; transition: all 0.3s ease;">
                                    @if($session->is_live)
                                        <p style="font-weight: 800; margin-bottom: 20px; letter-spacing: 1px;">● SESSION IS LIVE</p>
                                        <div style="display: flex; gap: 15px; justify-content: center; flex-direction: column;">
                                            <a href="{{ $session->meeting_link }}" target="_blank" class="btn-secondary-bw">OPEN MEETING ROOM</a>
                                            <form action="{{ route('session.toggle-live', $session) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-secondary-bw" style="background: transparent; color: #fff; border-color: #fff; width: 100%;">STOP LIVE SESSION</button>
                                            </form>
                                        </div>
                                    @else
                                        <p style="margin-bottom: 20px; font-weight: 700; text-transform: uppercase;">Link is Ready</p>
                                        <form action="{{ route('session.toggle-live', $session) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-primary-bw" style="width: 100%; padding: 20px; font-size: 20px; letter-spacing: 1px;">START LIVE CLASS</button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <div style="text-align: center; padding: 20px; color: #888; border: 2px dashed #eee;">
                                    Please save a meeting link first to start the live class.
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- STUDENT VIEW -->
                        <div style="background: #fff; border: 2px solid #000; padding: 40px; text-align: center;">
                            @if(!$session->meeting_link)
                                <div>
                                    <div style="font-size: 50px; margin-bottom: 20px; filter: grayscale(1);">⏳</div>
                                    <h3 style="margin: 0; font-size: 24px; font-weight: 800; text-transform: uppercase;">Awaiting meeting link...</h3>
                                    <p style="color: #666; margin-top: 15px; max-width: 400px; margin-left: auto; margin-right: auto;">The teacher hasn't provided the meeting link yet. You can message them to remind them.</p>
                                    <a href="{{ route('messenger.index') }}?user={{ $session->organiser_id }}" class="btn-secondary-bw" style="margin-top: 20px;">MESSAGE TEACHER</a>
                                </div>
                            @else
                                @if($session->is_live)
                                    <div>
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 8px; color: #000; font-weight: 800; margin-bottom: 20px; font-size: 14px;">
                                            <span style="width: 10px; height: 10px; background: #000; border-radius: 50%; display: inline-block; animation: pulse 1.5s infinite;"></span>
                                            LIVE SESSION IN PROGRESS
                                        </div>
                                        <h2 style="font-size: 32px; font-weight: 900; text-transform: uppercase; margin-bottom: 10px; letter-spacing: -1px;">Class is Started</h2>
                                        <p style="color: #666; margin-bottom: 30px;">Your teacher is waiting for you in the meeting room.</p>
                                        <a href="{{ $session->meeting_link }}" target="_blank" class="btn-primary-bw" style="font-size: 20px; width: 100%; padding: 25px;">JOIN LIVE CLASS NOW</a>
                                    </div>
                                @else
                                    <div style="background: #fcfcfc; padding: 30px; border: 1px dashed #000;">
                                        <h3 style="margin-bottom: 5px; font-weight: 800; text-transform: uppercase;">Teacher has not started</h3>
                                        <p style="color: #666; margin-bottom: 25px;">The meeting link is ready, but the teacher has not started the live class yet. Please wait or message them.</p>
                                        <div style="display: flex; flex-direction: column; gap: 15px;">
                                            <a href="{{ route('messenger.index') }}?user={{ $session->organiser_id }}" class="btn-secondary-bw" style="width: 100%;">MESSAGE TEACHER</a>
                                            <p style="font-size: 12px; color: #999; font-style: italic;">Note: The join button will appear here once the teacher starts the live session.</p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="grid-2">
        <!-- MATERIALS -->
        <div class="card">
            <div class="card-header">MATERIALS</div>
            <div class="card-body">
                <ul class="material-list">
                    @forelse($session->materials as $material)
                        <li class="list-item">
                            <span>{{ $material->title }}</span>
                            <a href="{{ $material->file_url }}" target="_blank" class="btn-outline">
                                {{ auth()->id() === $session->organiser_id ? 'VIEW FILE' : 'DOWNLOAD' }}
                            </a>
                        </li>
                    @empty
                        <li style="color: #888;">No materials shared yet.</li>
                    @endforelse
                </ul>

                @if(auth()->id() === $session->organiser_id)
                    <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                        <h4 style="margin-top: 0;">UPLOAD MATERIAL</h4>
                        <form action="{{ route('session.upload-material', $session->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="title" class="input-bw" placeholder="Material Title" required>
                            <input type="file" name="file" class="input-bw" style="border:none; padding: 10px 0;" required>
                            <button type="submit" class="btn-bw" style="width: 100%; margin-top: 10px;">UPLOAD</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- PRACTICE SUBMISSIONS -->
        <div class="card">
            <div class="card-header">PRACTICE</div>
            <div class="card-body">
                <ul class="practice-list">
                    @forelse($session->assignments as $assignment)
                        <li class="list-item" style="flex-direction: column; align-items: flex-start;">
                            <div style="display: flex; justify-content: space-between; width: 100%;">
                                <strong>{{ $assignment->title }}</strong>
                                @if($assignment->file_url)
                                    <a href="{{ $assignment->file_url }}" target="_blank" class="btn-outline" style="font-size: 10px;">VIEW FILE</a>
                                @endif
                            </div>
                            @if($assignment->details)
                                <p style="font-size: 12px; margin: 5px 0;">{{ $assignment->details }}</p>
                            @endif
                            <small style="color: #999;">{{ $assignment->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li style="color: #888;">No practice submitted yet.</li>
                    @endforelse
                </ul>

                @if(auth()->id() === $session->participant_id)
                    <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                        <h4 style="margin-top: 0;">SUBMIT PRACTICE</h4>
                        <form action="{{ route('session.submit-practice', $session->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="title" class="input-bw" placeholder="Task Name" required>
                            <textarea name="details" class="input-bw" placeholder="Notes/Description" rows="2"></textarea>
                            <input type="file" name="file" class="input-bw" style="border:none; padding: 10px 0;">
                            <button type="submit" class="btn-bw" style="width: 100%; margin-top: 10px;">SUBMIT</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ACTIONS -->
    @if(auth()->id() === $session->organiser_id && $session->status !== 'completed')
        <div style="margin-top: 30px; text-align: right;">
            <form action="{{ route('session.complete-session', $session->id) }}" method="POST" onsubmit="return confirm('Finish this session?');">
                @csrf
                <button type="submit" class="btn-bw" style="background: #fff; color: #000;">MARK AS COMPLETED</button>
            </form>
        </div>
    @endif

</div>
@endsection

