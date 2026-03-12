@extends('admin.layout')

@section('title', 'User Details - ' . $user->name)
@section('page-title', 'User Details')

@section('content')
<div style="background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; max-width: 800px; margin: 0 auto;">
    
    {{-- Header --}}
    <div style="background: #f8fafc; padding: 30px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 20px;">
        @if($user->avatar)
            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=e2e8f0&color=475569" alt="{{ $user->name }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        @endif
        <div>
            <h2 style="margin: 0; font-size: 24px; color: #1e293b;">{{ $user->name }}</h2>
            <p style="margin: 4px 0 0; color: #64748b;">{{ $user->email }}</p>
            <div style="margin-top: 8px; display: inline-block; background: #e2e8f0; padding: 4px 12px; border-radius: 9999px; font-size: 13px; font-weight: 600; color: #475569;">
                {{ ucfirst($user->role) }}
                @if($user->role === 'teacher')
                    • {{ $user->is_teacher_approved ? 'Approved' : 'Pending' }}
                @endif
            </div>
            <div style="margin-top: 8px; display: inline-block; background: {{ $user->is_active ? '#dcfce7' : '#fee2e2' }}; color: {{ $user->is_active ? '#166534' : '#991b1b' }}; padding: 4px 12px; border-radius: 9999px; font-size: 13px; font-weight: 600;">
                {{ $user->is_active ? 'Active' : 'Inactive' }}
            </div>
        </div>
    </div>

    {{-- Details Body --}}
    <div style="padding: 30px;">
        
        <div style="margin-bottom: 25px;">
            <h3 style="font-size: 16px; font-weight: 600; color: #334155; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 15px;">Basic Info</h3>
            <p style="margin: 0 0 10px; color: #475569;"><strong>Bio:</strong> {{ $user->bio ?: 'No bio provided' }}</p>
            <p style="margin: 0 0 10px; color: #475569;"><strong>Joined:</strong> {{ $user->created_at->format('M d, Y g:i A') }}</p>
            <p style="margin: 0 0 10px; color: #475569;"><strong>Email Verified:</strong> {{ $user->hasVerifiedEmail() ? $user->email_verified_at->format('M d, Y') : 'No' }}</p>
        </div>

        @if($user->role === 'teacher' && $user->teacherProfile)
        <div style="margin-bottom: 25px;">
            <h3 style="font-size: 16px; font-weight: 600; color: #334155; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 15px;">Teacher Verification Details</h3>
            
            <p style="margin: 0 0 10px; color: #475569;"><strong>Bank Account:</strong> {{ $user->teacherProfile->bank_account ?: 'Not provided' }}</p>
            <p style="margin: 0 0 10px; color: #475569;"><strong>Experience:</strong> {{ $user->teacherProfile->experience_years ?: '0' }} years</p>
            <p style="margin: 0 0 10px; color: #475569;"><strong>Teaching Style:</strong> {{ $user->teacherProfile->teaching_style ?: 'Not provided' }}</p>

            <div style="margin-top: 15px; display: flex; gap: 15px; flex-wrap: wrap;">
                @if($user->teacherProfile->cv_path)
                    <a href="{{ asset('storage/'.$user->teacherProfile->cv_path) }}" target="_blank" style="padding: 8px 16px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; color: #334155; text-decoration: none; font-weight: 500; font-size: 14px;">📄 View CV</a>
                @endif
                @if($user->teacherProfile->certificate_path)
                    <a href="{{ asset('storage/'.$user->teacherProfile->certificate_path) }}" target="_blank" style="padding: 8px 16px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; color: #334155; text-decoration: none; font-weight: 500; font-size: 14px;">🎓 View Certificate</a>
                @endif
                @if($user->teacherProfile->citizenship_path)
                    <a href="{{ asset('storage/'.$user->teacherProfile->citizenship_path) }}" target="_blank" style="padding: 8px 16px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; color: #334155; text-decoration: none; font-weight: 500; font-size: 14px;">🪪 View Citizenship</a>
                @endif
            </div>
        </div>
        @endif

        <div style="margin-bottom: 25px;">
            <h3 style="font-size: 16px; font-weight: 600; color: #334155; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 15px;">
                {{ $user->role === 'teacher' ? 'Offered Skills' : 'Requested Skills' }}
            </h3>
            @php
                $skillsList = $user->role === 'teacher' ? $user->skillsOffered : $user->skillsWanted;
            @endphp
            
            @if($skillsList && $skillsList->count() > 0)
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @foreach($skillsList as $us)
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 20px; font-size: 14px; color: #475569;">
                        <strong>{{ $us->skill->title ?? 'Unknown' }}</strong> 
                        <span style="color: #94a3b8; font-size: 12px; margin-left: 5px;">({{ ucfirst($us->level) }})</span>
                    </div>
                @endforeach
                </div>
            @else
                <p style="color: #94a3b8; font-style: italic; margin: 0;">No skills listed.</p>
            @endif
        </div>

    </div>

    <div style="background: #f8fafc; padding: 20px 30px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between;">
        <a href="{{ url()->previous() }}" style="color: #64748b; text-decoration: none; font-weight: 500;">← Back</a>
        <div style="display: flex; gap: 10px;">
            @if($user->role === 'teacher' && !$user->is_teacher_approved)
                <form method="POST" action="{{ route('admin.teachers.approve', $user->id) }}">
                    @csrf <button type="submit" style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Approve Teacher</button>
                </form>
            @endif
            <form method="POST" action="{{ route('admin.users.toggle-active', $user->id) }}">
                @csrf <button type="submit" style="padding: 8px 16px; background: {{ $user->is_active ? '#f59e0b' : '#3b82f6' }}; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    {{ $user->is_active ? 'Deactivate User' : 'Activate User' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
