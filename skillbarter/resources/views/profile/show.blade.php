@extends('app')

@section('content')
<div style="width: 100%; min-height: calc(100vh - 200px); display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
    <div style="width: 100%; max-width: 900px;">

        {{-- Success Message --}}
        @if(session('status'))
            <div class="alert alert-success" style="background: #dcfce7; color: #166534; border-left: 4px solid #16a34a; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px;">
                ✓ {{ session('status') }}
            </div>
        @endif

        {{-- Profile Card --}}
        <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); overflow: hidden;">

            {{-- Header Section --}}
            <div style="background: var(--primary-teal); color: white; padding: 40px 30px; text-align: center;">
                <img
                    src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.$user->name.'&background=20a68a&color=fff' }}"
                    style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid white; margin-bottom: 15px;"
                    alt="Profile Avatar"
                >
                <h1 style="margin: 0 0 5px 0; font-size: 32px; font-weight: 700;">{{ $user->name }}</h1>
                <p style="margin: 5px 0; color: #d1d5db; font-size: 14px;">{{ $user->email }}</p>
                <span style="display: inline-block; background: white; color: var(--primary-teal); padding: 6px 16px; border-radius: 20px; font-weight: 600; margin-top: 12px; font-size: 13px;">
                    {{ ucfirst($user->role) }}
                </span>
            </div>

            {{-- Body Section --}}
            <div style="padding: 40px 30px;">

                {{-- About Section --}}
                <div style="margin-bottom: 35px;">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px; color: var(--text-slate);">About</h3>
                    <p style="color: #475569; line-height: 1.6; margin: 0;">
                        {{ $user->bio ?? 'No bio added yet.' }}
                    </p>
                </div>

                <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">

                {{-- Skills Section --}}
                <div style="margin-bottom: 35px;">
                    @if($user->isTeacher())
                        {{-- TEACHER VIEW: Shows "I Teach" section --}}
                        <div style="margin-bottom: 30px;">
                            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 15px; color: #000; text-align: center;">
                                💡 I Teach
                            </h3>
                            @if($user->skillsOffered && $user->skillsOffered->count() > 0)
                                <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
                                    @foreach($user->skillsOffered as $userSkill)
                                        <div style="background: var(--bg-light-teal); color: var(--text-slate); padding: 10px 18px; border-radius: 20px; font-size: 14px; font-weight: 500; border: 1px solid var(--primary-teal-light); text-align: center;">
                                            {{ $userSkill->skill->title ?? 'Unknown Skill' }}
                                            <span style="display: block; font-size: 11px; color: #666; margin-top: 3px;">{{ ucfirst($userSkill->level) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p style="color: #999; margin: 0; text-align: center;">No skills added yet.</p>
                            @endif
                        </div>
                    @else
                        {{-- STUDENT VIEW: Shows "I Learn" section --}}
                        <div style="margin-bottom: 30px;">
                            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 15px; color: #000; text-align: center;">
                                📚 I Learn
                            </h3>
                            @if($user->skillsWanted && $user->skillsWanted->count() > 0)
                                <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
                                    @foreach($user->skillsWanted as $userSkill)
                                        <div style="background: var(--bg-light-teal); color: var(--text-slate); padding: 10px 18px; border-radius: 20px; font-size: 14px; font-weight: 500; border: 1px solid var(--primary-teal-light); text-align: center;">
                                            {{ $userSkill->skill->title ?? 'Unknown Skill' }}
                                            <span style="display: block; font-size: 11px; color: #666; margin-top: 3px;">{{ ucfirst($userSkill->level) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p style="color: #999; margin: 0; text-align: center;">No skills added yet.</p>
                            @endif
                        </div>
                    @endif
                </div>

                <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">

                {{-- Action Buttons --}}
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('profile.edit') }}" class="btn-pill primary" style="text-decoration:none;">
                        Edit Profile
                    </a>
                    <a href="{{ route('my.skills') }}" class="btn-pill primary" style="text-decoration:none;">
                        Manage Skills
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn-pill secondary" style="text-decoration:none;">
                        Dashboard
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .alert-success:hover {
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
    }

    @media (max-width: 768px) {
        div[style*="max-width: 900px"] {
            padding: 20px;
        }
    }
</style>

@endsection
