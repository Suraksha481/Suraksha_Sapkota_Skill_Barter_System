@extends('app')

@section('content')
<style>
    :root {
        --classroom-teal: var(--primary-teal, #20a68a);
        --classroom-teal-dark: var(--primary-teal-dark, #188c75);
        --classroom-bg: var(--bg-light-teal, #f4fdfb);
        --classroom-slate: #0f172a;
        --classroom-gray: #64748b;
    }

    .classroom-container {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 20px;
        font-family: 'Inter', sans-serif;
    }

    .card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 24px;
        margin-bottom: 40px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.04);
    }

    .card-header {
        background: var(--classroom-bg);
        color: var(--classroom-slate);
        padding: 30px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(32, 166, 138, 0.1);
    }
    .card-header h1 {
        font-size: 1.8rem;
        font-weight: 900;
        letter-spacing: -0.5px;
        color: var(--classroom-slate);
        margin: 0;
    }
    .card-header small {
        font-size: 1rem;
        color: var(--classroom-gray);
        font-weight: 600;
        margin-top: 5px;
        display: block;
    }

    .card-body {
        padding: 40px;
    }

    .btn-bw {
        background: var(--classroom-teal);
        color: #fff !important;
        border: none;
        border-radius: 50px;
        padding: 12px 28px;
        text-decoration: none;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(32, 166, 138, 0.2);
    }
    .btn-bw:hover {
        background: var(--classroom-teal-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(32, 166, 138, 0.3);
    }

    .btn-outline {
        background: #fff;
        color: var(--classroom-teal) !important;
        border: 2px solid var(--classroom-teal);
        border-radius: 50px;
        padding: 8px 18px;
        text-decoration: none;
        font-weight: 800;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-outline:hover {
        background: var(--classroom-bg);
        transform: translateY(-2px);
    }

    .badge-bw {
        background: #fff;
        border: 1px solid rgba(32, 166, 138, 0.2);
        color: var(--classroom-teal);
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }

    .input-bw {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 20px;
        width: 100%;
        margin-top: 8px;
        font-size: 0.95rem;
        font-family: inherit;
        color: var(--classroom-slate);
        transition: border-color 0.3s;
        background: #fff;
    }
    .input-bw:focus {
        outline: none;
        border-color: var(--classroom-teal);
        box-shadow: 0 0 0 4px rgba(32,166,138,0.1);
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }

    @media (max-width: 768px) {
        .grid-2 { grid-template-columns: 1fr; }
    }

    .material-list, .practice-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .list-item {
        border-bottom: 2px dashed #f1f5f9;
        padding: 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .list-item:last-child {
        border-bottom: none;
    }
    .list-item span, .list-item strong {
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--classroom-slate);
    }

    .alert-bw {
        background: var(--classroom-bg);
        border-left: 4px solid var(--classroom-teal);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        font-weight: 700;
        color: var(--classroom-teal-dark);
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .btn-primary-bw {
        background: var(--classroom-teal);
        color: #fff !important;
        border: none;
        border-radius: 16px;
        padding: 18px 30px;
        text-decoration: none;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 1rem;
        display: inline-block;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(32, 166, 138, 0.25);
        cursor: pointer;
    }
    .btn-primary-bw:hover {
        background: var(--classroom-teal-dark);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(32, 166, 138, 0.35);
    }
    
    .btn-secondary-bw {
        background: #fff;
        color: var(--classroom-slate) !important;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 30px;
        text-decoration: none;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 1rem;
        display: inline-block;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .btn-secondary-bw:hover {
        border-color: var(--classroom-gray);
        background: #f8fafc;
        transform: translateY(-2px);
    }

    .participant-chip {
        display: inline-flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 50px;
        padding: 8px 20px;
        gap: 15px;
        transition: all 0.2s;
    }
    .participant-chip:hover {
        border-color: rgba(32,166,138,0.3);
        background: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    .participant-chip strong {
        color: var(--classroom-slate);
        font-size: 0.95rem;
    }
    .info-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .action-box {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 20px;
        padding: 25px;
    }
    .action-box-solid {
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.02);
    }

    .divider-line {
        border: 0;
        border-top: 2px solid #f1f5f9;
        margin: 35px 0;
    }
</style>

<div class="classroom-container">

    @if(session('success'))
        <div class="alert-bw">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <div>
                <h1>CLASSROOM ({{ auth()->id() === $session->organiser_id ? 'TEACHER VIEW' : 'STUDENT VIEW' }})</h1>
                <small>{{ $session->skill->title ?? 'Session' }}</small>
            </div>
            <div class="badge-bw">
                {{ $session->status }}
            </div>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 30px; margin-bottom: 20px;">
                <div style="display: flex; gap: 40px; align-items: flex-start; flex-wrap: wrap;">
                    <div style="min-width: 250px;">
                        <span class="info-label">TEACHER</span>
                        <div class="participant-chip">
                            <strong>{{ $session->teacher->name }}</strong>
                            @if(auth()->id() !== $session->organiser_id)
                                <a href="{{ route('messenger.index') }}?user={{ $session->organiser_id }}" class="btn-outline" style="font-size: 10px; padding: 4px 12px;">CHAT</a>
                            @endif
                        </div>
                    </div>
                    <div style="flex-grow: 1;">
                        <span class="info-label">STUDENTS IN THIS CLASS</span>
                        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                            @forelse($session->participants as $p)
                                <div class="participant-chip">
                                    <strong>{{ $p->name }}</strong>
                                    @if(auth()->id() === $session->organiser_id && $p->id !== auth()->id())
                                        <a href="{{ route('messenger.index') }}?user={{ $p->id }}" class="btn-outline" style="font-size: 10px; padding: 4px 12px;">CHAT</a>
                                    @endif
                                </div>
                            @empty
                                <span style="color: #94a3b8; font-style: italic; margin-top: 10px; display: inline-block;">No students attached to this session yet.</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if(auth()->id() === $session->organiser_id)
                    <div class="action-box">
                        <form action="{{ route('session.add-participant', $session->id) }}" method="POST" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
                            @csrf
                            <span class="info-label" style="margin: 0; padding-right: 10px;">ADD ANOTHER ACCEPTED STUDENT:</span>
                            <div style="flex-grow: 1; min-width: 250px;">
                                <select name="user_id" required class="input-bw" style="margin-top: 0;">
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
                            </div>
                            <button type="submit" class="btn-bw" style="padding: 14px 24px;">ADD TO CLASS</button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- SCHEDULE SECTION -->
            <hr class="divider-line">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--classroom-slate); margin: 0;">Session Schedule</h3>
                
                <div style="display: flex; align-items: center; gap: 15px; background: #f8fafc; padding: 20px; border-radius: 16px; border: 1.5px solid #e2e8f0;">
                    <div style="font-size: 2rem;">🗓️</div>
                    <div>
                        <span class="info-label" style="margin-bottom: 5px;">CURRENT TIME</span>
                        <strong style="font-size: 1.1rem; color: var(--classroom-teal-dark);">
                            @if($session->start_time)
                                {{ \Carbon\Carbon::parse($session->start_time)->format('F j, Y - g:i A') }}
                                @if($session->end_time)
                                    to {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}
                                @endif
                            @else
                                Not fully scheduled
                            @endif
                        </strong>
                    </div>
                </div>

                @if(auth()->id() === $session->organiser_id)
                    <!-- TEACHER CAN UPDATE -->
                    <div class="action-box">
                        <form action="{{ route('session.update-schedule', $session->id) }}" method="POST" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
                            @csrf
                            <div style="flex-grow: 1;">
                                <span class="info-label">UPDATE START TIME</span>
                                <input type="datetime-local" name="start_time" class="input-bw" value="{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('Y-m-d\TH:i') : '' }}" required>
                            </div>
                            <div style="flex-grow: 1;">
                                <span class="info-label">UPDATE END TIME</span>
                                <input type="datetime-local" name="end_time" class="input-bw" value="{{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('Y-m-d\TH:i') : '' }}" required>
                            </div>
                            <button type="submit" class="btn-bw" style="padding: 14px 24px; height: 50px;">UPDATE SCHEDULE</button>
                        </form>
                    </div>
                @else
                    <!-- STUDENT CAN REQUEST RESCHEDULE -->
                    @if($session->status !== 'completed')
                        @if($session->reschedule_requested)
                            <div class="action-box" style="background: #fff; border-color: rgba(32,166,138,0.3);">
                                <span class="info-label" style="color: var(--classroom-teal-dark);">RESCHEDULE REQUEST SENT</span>
                                <p style="color: var(--classroom-slate); font-weight: 500; font-size: 0.95rem; line-height: 1.5; margin: 5px 0 0 0; background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0;">
                                    "{{ $session->reschedule_remarks }}"
                                </p>
                                <small style="display: block; margin-top: 10px; color: #94a3b8; font-style: italic;">We have politely notified the teacher. They will safely review your note and adjust the class time.</small>
                            </div>
                        @else
                            <div class="action-box">
                                <form action="{{ route('session.request-reschedule', $session->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 10px;">
                                    @csrf
                                    <span class="info-label">REQUEST A DIFFERENT TIME</span>
                                    <textarea name="remarks" class="input-bw" rows="2" placeholder="Teacher, I am not available then. Could we do Tuesday at 5 PM instead?" required></textarea>
                                    <button type="submit" class="btn-outline" style="align-self: flex-start; margin-top: 5px;">SEND RESCHEDULE REQUEST</button>
                                </form>
                            </div>
                        @endif
                    @endif
                @endif
            </div>

            <!-- MEETING LINK SECTION -->
            <hr class="divider-line">
            
            <div>
                @if($session->status === 'completed')
                    <div class="action-box-solid" style="text-align: center; border-color: #e2e8f0; background: #fdfdfd;">
                        <span class="info-label" style="color: #10b981; font-size: 1rem; margin-bottom: 10px;">✔ Session Completed</span>
                        <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 0;">This session has gracefully ended. Materials and practice submissions remain permanently available below.</p>
                        @if(auth()->id() === $session->participant_id)
                            <hr class="divider-line" style="margin: 25px auto; width: 50%;">
                            <a href="{{ route('feedback.create', ['session_id' => $session->id]) }}" class="btn-primary-bw">RATE YOUR TEACHER</a>
                        @endif
                    </div>
                @else
                    @if(auth()->id() === $session->organiser_id)
                        <!-- TEACHER VIEW -->
                        <div class="action-box-solid">
                            <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--classroom-slate); margin-top: 0; margin-bottom: 25px;">Live Class Controls</h3>
                            
                            <form action="{{ route('session.update-link', $session->id) }}" method="POST" style="margin-bottom: 35px; background: var(--classroom-bg); padding: 25px; border-radius: 16px;">
                                @csrf
                                <span class="info-label" style="color: var(--classroom-teal-dark);">MEETING LINK (Zoom, Google Meet, etc.)</span>
                                <div style="display: flex; gap: 15px;">
                                    <input type="url" name="meeting_link" class="input-bw" value="{{ $session->meeting_link }}" placeholder="https://zoom.us/j/..." required style="margin: 0; background: #fff;">
                                    <button type="submit" class="btn-bw" style="border-radius: 12px; padding: 0 30px;">@if($session->meeting_link) UPDATE @else SAVE @endif</button>
                                </div>
                            </form>

                            @if($session->meeting_link)
                                <div style="text-align: center; padding: 40px; border-radius: 20px; background: {{ $session->is_live ? 'var(--classroom-teal)' : '#f8fafc' }}; color: {{ $session->is_live ? '#fff' : 'var(--classroom-slate)' }}; transition: all 0.3s ease; border: 1.5px solid {{ $session->is_live ? 'transparent' : '#e2e8f0' }}; box-shadow: {{ $session->is_live ? '0 15px 35px rgba(32,166,138,0.3)' : 'none' }};">
                                    @if($session->is_live)
                                        <h3 style="font-weight: 900; margin-bottom: 30px; letter-spacing: 1px; font-size: 1.4rem;">● SESSION IS LIVE</h3>
                                        <div style="display: flex; gap: 15px; justify-content: center; flex-direction: column; max-width: 400px; margin: 0 auto;">
                                            <a href="{{ $session->meeting_link }}" target="_blank" class="btn-secondary-bw" style="border: none !important;">OPEN MEETING ROOM</a>
                                            <form action="{{ route('session.toggle-live', $session) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-secondary-bw" style="background: transparent; color: #fff !important; width: 100%; border: 2px solid rgba(255,255,255,0.4) !important;">STOP LIVE SESSION</button>
                                            </form>
                                        </div>
                                    @else
                                        <h3 style="margin-bottom: 25px; font-weight: 800; font-size: 1.2rem;">Link is Ready</h3>
                                        <form action="{{ route('session.toggle-live', $session) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-primary-bw" style="width: 100%; max-width: 400px; padding: 22px; font-size: 1.1rem; border-radius: 50px;">START LIVE CLASS</button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <div style="text-align: center; padding: 30px; color: #94a3b8; border: 2px dashed #cbd5e1; border-radius: 16px; font-weight: 600;">
                                    Please save a meeting link first to unlock live class controls.
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- STUDENT VIEW -->
                        <div class="action-box-solid" style="text-align: center; padding: 60px 40px;">
                            @if(!$session->meeting_link)
                                <div>
                                    <div style="font-size: 60px; margin-bottom: 25px; filter: grayscale(1); opacity: 0.5;">⏳</div>
                                    <h3 style="margin: 0; font-size: 1.6rem; font-weight: 900; color: var(--classroom-slate);">AWAITING MEETING LINK...</h3>
                                    <p style="color: #64748b; margin-top: 15px; max-width: 500px; margin-left: auto; margin-right: auto; line-height: 1.6;">The teacher hasn't provided the live room link yet. You can relax or kindly message them a reminder.</p>
                                    <a href="{{ route('messenger.index') }}?user={{ $session->organiser_id }}" class="btn-secondary-bw" style="margin-top: 30px; border-radius: 50px;">MESSAGE TEACHER</a>
                                </div>
                            @else
                                @if($session->is_live)
                                    <div style="background: var(--classroom-teal); padding: 50px; border-radius: 20px; color: #fff; box-shadow: 0 20px 40px rgba(32,166,138,0.3);">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; font-weight: 800; margin-bottom: 20px; font-size: 0.9rem; letter-spacing: 1px;">
                                            <span style="width: 12px; height: 12px; background: #fff; border-radius: 50%; display: inline-block; animation: pulse 1.5s infinite;"></span>
                                            LIVE SESSION IN PROGRESS
                                        </div>
                                        <h2 style="font-size: 2.2rem; font-weight: 900; margin-bottom: 15px; letter-spacing: -1px;">Class is Started</h2>
                                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 35px; font-size: 1.1rem;">Your teacher successfully opened the room. Join now!</p>
                                        <a href="{{ $session->meeting_link }}" target="_blank" class="btn-secondary-bw" style="font-size: 1.1rem; width: 100%; max-width: 400px; padding: 22px; border-radius: 50px; border: none !important;">JOIN LIVE CLASS NOW</a>
                                    </div>
                                @else
                                    <div class="action-box">
                                        <h3 style="margin-bottom: 10px; font-weight: 800; font-size: 1.4rem; color: var(--classroom-slate);">Teacher has not started</h3>
                                        <p style="color: #64748b; margin-bottom: 35px; line-height: 1.6;">The meeting link is fully prepared, but the teacher has not initiated the live session yet. You will be able to join when they start.</p>
                                        <div style="display: flex; flex-direction: column; gap: 20px; align-items: center;">
                                            <a href="{{ route('messenger.index') }}?user={{ $session->organiser_id }}" class="btn-bw">MESSAGE TEACHER</a>
                                            <span style="font-size: 0.85rem; color: #94a3b8; font-style: italic;">The join button will securely unlock here once the session begins.</span>
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
            <div class="card-header">
                <h1 style="font-size: 1.3rem;">MATERIALS</h1>
            </div>
            <div class="card-body">
                <ul class="material-list">
                    @forelse($session->materials as $material)
                        <li class="list-item">
                            <span>{{ $material->title }}</span>
                            <a href="{{ $material->file_url }}" target="_blank" class="btn-outline" style="font-size: 0.75rem;">
                                {{ auth()->id() === $session->organiser_id ? 'VIEW & CHECK' : 'DOWNLOAD FILE' }}
                            </a>
                        </li>
                    @empty
                        <li style="color: #94a3b8; font-style: italic; padding: 10px 0;">No materials shared yet.</li>
                    @endforelse
                </ul>

                @if(auth()->id() === $session->organiser_id)
                    <div style="margin-top: 40px; border-top: 2px dashed #f1f5f9; padding-top: 30px;">
                        <span class="info-label" style="color: var(--classroom-slate);">UPLOAD NEW MATERIAL</span>
                        <form action="{{ route('session.upload-material', $session->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="title" class="input-bw" placeholder="Material Title (e.g. Chapter 1 PDF)" required>
                            <input type="file" name="file" class="input-bw" style="border:none; padding: 15px 0; background: transparent; box-shadow: none;" required>
                            <button type="submit" class="btn-bw" style="width: 100%; margin-top: 15px; border-radius: 12px;">SECURE UPLOAD</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- PRACTICE SUBMISSIONS -->
        <div class="card">
            <div class="card-header">
                <h1 style="font-size: 1.3rem;">PRACTICE & HOMEWORK</h1>
            </div>
            <div class="card-body">
                <ul class="practice-list">
                    @forelse($session->assignments as $assignment)
                        <li class="list-item" style="flex-direction: column; align-items: flex-start; gap: 10px;">
                            <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                                <strong>{{ $assignment->title }}</strong>
                                @if($assignment->file_url)
                                    <a href="{{ $assignment->file_url }}" target="_blank" class="btn-outline" style="font-size: 0.75rem;">VIEW WORK</a>
                                @endif
                            </div>
                            @if($assignment->details)
                                <p style="font-size: 0.95rem; color: #64748b; line-height: 1.5; margin: 5px 0;">{{ $assignment->details }}</p>
                            @endif
                            <small style="color: #94a3b8; font-weight: 600;">Submitted: {{ $assignment->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li style="color: #94a3b8; font-style: italic; padding: 10px 0;">No practice files submitted yet.</li>
                    @endforelse
                </ul>

                @if(auth()->id() === $session->participant_id)
                    <div style="margin-top: 40px; border-top: 2px dashed #f1f5f9; padding-top: 30px;">
                        <span class="info-label" style="color: var(--classroom-slate);">SUBMIT NEW PRACTICE</span>
                        <form action="{{ route('session.submit-practice', $session->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="title" class="input-bw" placeholder="Task Name (e.g. Design Draft v1)" required>
                            <textarea name="details" class="input-bw" placeholder="Notes/Description to teacher..." rows="3" style="resize: vertical;"></textarea>
                            <input type="file" name="file" class="input-bw" style="border:none; padding: 15px 0; background: transparent; box-shadow: none;">
                            <button type="submit" class="btn-bw" style="width: 100%; margin-top: 15px; border-radius: 12px;">SUBMIT WORK</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ACTIONS -->
    @if(auth()->id() === $session->organiser_id && $session->status !== 'completed')
        <div style="margin-top: 20px; text-align: right; padding-bottom: 60px;">
            <form action="{{ route('session.complete-session', $session->id) }}" method="POST" onsubmit="return confirm('WARNING: Are you absolutely sure you want to finish this session permanently?');">
                @csrf
                <button type="submit" class="btn-secondary-bw" style="border-radius: 50px;">MARK COURSE AS COMPLETED</button>
            </form>
        </div>
    @endif

</div>
@endsection

