@extends('app')

@section('content')
<div style="width: 100%; min-height: calc(100vh - 200px); display: flex; align-items: flex-start; justify-content: center; padding: 60px 20px;">
    <div style="width: 100%; max-width: 1000px;">

        {{-- Page Title --}}
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 36px; font-weight: 700; color: #000; margin-bottom: 10px;">My Skills</h1>
            <p style="color: #666; font-size: 16px;">Manage the skills you teach or want to learn</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; border-left: 4px solid #16a34a; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px;">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px;">
                ✗ {{ session('error') }}
            </div>
        @endif

        {{-- Add Skill Card --}}
        <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); padding: 40px; margin-bottom: 40px;">
            <h2 style="font-size: 24px; font-weight: 700; color: #000; margin-bottom: 30px; text-align: center;">➕ Add a Skill</h2>

            <form action="{{ route('my.skills.store') }}" method="POST">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    {{-- Skill Selection --}}
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px;">
                            Select Skill *
                        </label>
                        <select name="skill_id" required style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit;">
                            <option value="">-- Choose Skill --</option>
                            @if($allSkills->isEmpty())
                                <option disabled>No skills available</option>
                            @else
                                @foreach($allSkills as $skill)
                                    <option value="{{ $skill->id }}">{{ $skill->title }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($allSkills->isEmpty())
                            <p style="color:#666;font-size:13px;margin-top:5px;">
                                No skills have been added yet. Please <a href="{{ route('admin.skills') }}" target="_blank" style="text-decoration:underline;">ask an admin</a> to create some.
                            </p>
                        @endif
                        @error('skill_id')
                            <p style="color: #dc2626; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Type Selection --}}
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px;">
                            {{ $user->isTeacher() ? 'I Teach' : 'Type' }} *
                        </label>
                        <select name="type" required style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit;">
                            @if($user->isTeacher())
                                <option value="offer">I Teach</option>
                            @else
                                <option value="request">I Want to Learn</option>
                            @endif
                        </select>
                        @error('type')
                            <p style="color: #dc2626; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Level Selection --}}
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px;">
                            Level
                        </label>
                        <select name="level" style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit;">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div style="text-align: center;">
                    <button type="submit" style="background: #000; color: white; padding: 12px 40px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; transition: all 0.3s ease;">
                        Add Skill
                    </button>
                </div>
            </form>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">

            {{-- Skills I Teach --}}
            <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); padding: 30px;">
                <h3 style="font-size: 20px; font-weight: 700; color: #000; margin-bottom: 20px; text-align: center;">
                    💡 Skills I Teach
                </h3>
                @if($teachSkills && $teachSkills->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($teachSkills as $userSkill)
                            <div style="background: #f5f5f5; padding: 15px; border-radius: 8px; border-left: 4px solid #000; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <p style="margin: 0 0 5px 0; font-weight: 600; color: #000;">{{ $userSkill->skill->title }}</p>
                                    <p style="margin: 0; font-size: 12px; color: #666;">{{ ucfirst($userSkill->level) }} level</p>
                                </div>
                                <form action="{{ route('my.skills.destroy', $userSkill->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dc2626; color: white; padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600;" onclick="return confirm('Remove this skill?');">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: #999; text-align: center; margin: 0;">No teaching skills added yet.</p>
                @endif
            </div>

            {{-- Skills I Want to Learn --}}
            <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); padding: 30px;">
                <h3 style="font-size: 20px; font-weight: 700; color: #000; margin-bottom: 20px; text-align: center;">
                    📚 Skills I Want to Learn
                </h3>
                @if($learnSkills && $learnSkills->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($learnSkills as $userSkill)
                            <div style="background: #f5f5f5; padding: 15px; border-radius: 8px; border-left: 4px solid #000; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <p style="margin: 0 0 5px 0; font-weight: 600; color: #000;">{{ $userSkill->skill->title }}</p>
                                    <p style="margin: 0; font-size: 12px; color: #666;">{{ ucfirst($userSkill->level) }} level</p>
                                </div>
                                <form action="{{ route('my.skills.destroy', $userSkill->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dc2626; color: white; padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600;" onclick="return confirm('Remove this skill?');">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: #999; text-align: center; margin: 0;">No learning skills added yet.</p>
                @endif
            </div>

        </div>

{{-- Back Button --}}
    <div style="text-align: center; margin-bottom: 40px;">
        <a href="{{ route('profile.show') }}" style="display:inline-block; background:#000; color:white; padding:10px 24px; border-radius:8px; text-decoration:none; font-weight:600; font-size:16px; transition:background 0.3s ease;" onmouseover="this.style.background='#333'" onmouseout="this.style.background='#000'">
                ← Back to Profile
            </a>
        </div>

    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }

        div[style*="grid-template-columns: 1fr 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }

        div[style*="max-width: 1000px"] {
            padding: 20px;
        }
    }
</style>

@endsection
