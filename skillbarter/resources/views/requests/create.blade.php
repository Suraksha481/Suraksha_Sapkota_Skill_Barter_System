@extends('app')

@section('page_title', 'Request Session - SkillSwap')

@section('content')

<style>
:root {
    --req-primary: #20a68a;
    --req-primary-light: #e9f7f4;
    --req-text-main: #2d3e50;
    --req-text-muted: #6b8e88;
    --req-bg: #f8fbfa;
    --req-card-bg: #ffffff;
    --req-shadow: 0 20px 50px rgba(32, 166, 138, 0.08);
}

.req-wrapper {
    background: var(--req-bg);
    min-height: 100vh;
    padding: 120px 5% 80px;
}

.req-container {
    max-width: 800px;
    margin: 0 auto;
}

.req-card {
    background: var(--req-card-bg);
    border-radius: 40px;
    padding: 60px;
    box-shadow: var(--req-shadow);
    border: 1px solid var(--req-primary-light);
}

.req-header {
    margin-bottom: 40px;
    text-align: center;
}

.req-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--req-text-main);
    margin-bottom: 10px;
}

.req-header p {
    color: var(--req-text-muted);
    font-size: 1.1rem;
}

.skill-info-banner {
    background: var(--req-primary-light);
    border-radius: 30px;
    padding: 30px 40px;
    margin-bottom: 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid rgba(32, 166, 138, 0.2);
}

.skill-info-text h2 {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--req-primary);
    margin-bottom: 5px;
}

.skill-info-details {
    display: flex;
    gap: 30px;
    color: var(--req-text-main);
    font-weight: 600;
    font-size: 0.95rem;
}

.form-group {
    margin-bottom: 35px;
}

.form-label {
    display: block;
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--req-text-main);
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.form-control {
    width: 100%;
    padding: 18px 24px;
    border-radius: 20px;
    border: 2px solid var(--req-primary-light);
    background: #fff;
    font-family: inherit;
    font-size: 1rem;
    color: var(--req-text-main);
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--req-primary);
    box-shadow: 0 0 0 5px rgba(32, 166, 138, 0.1);
}

textarea.form-control {
    resize: none;
    min-height: 150px;
}

.req-btns {
    display: flex;
    gap: 20px;
    margin-top: 50px;
}

.req-btns .btn-pill {
    flex: 1;
}


.alert-modern {
    padding: 20px 30px;
    border-radius: 25px;
    background: #fff5f5;
    color: #c53030;
    border: 1px solid #feb2b2;
    margin-bottom: 30px;
    font-weight: 600;
}

@media (max-width: 768px) {
    .req-card { padding: 40px 25px; border-radius: 30px; }
    .skill-info-banner { flex-direction: column; align-items: flex-start; gap: 15px; }
    .skill-info-details { flex-direction: column; gap: 5px; }
    .req-btns { flex-direction: column; }
    .req-header h1 { font-size: 2rem; }
}
</style>

<div class="req-wrapper">
    <div class="req-container">
        
        <header class="req-header">
            <h1 style="color: #000;">Request Mentorship</h1>
            <p>Connect with <strong>{{ $userSkill->user->name ?? 'Expert' }}</strong> to master this skill.</p>
        </header>

        @if(session('error'))
            <div class="alert-modern">
                {!! session('error') !!}
            </div>
        @endif

        <div class="req-card">
            <div class="skill-info-banner">
                <div class="skill-info-text">
                    <h2>{{ $userSkill->skill->title ?? 'Professional Skill' }}</h2>
                    <div class="skill-info-details">
                        <span>Level: {{ ucfirst($userSkill->level ?? 'Beginner') }}</span>
                        @if($userSkill->price)
                            <span style="color: var(--req-primary);">Token Cost: {{ number_format($userSkill->price, 0) }} pts</span>
                        @endif
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('requests.store') }}" onsubmit="return confirm('Ready to send this request?');">
                @csrf
                <input type="hidden" name="user_skill_id" value="{{ $userSkill->id }}">

                <div class="form-group">
                    <label for="message" class="form-label">Introduce Yourself</label>
                    <textarea name="message" id="message" class="form-control" 
                              placeholder="Describe what you want to learn or any specific goals you have..."
                              required>{{ old('message') }}</textarea>
                    @error('message')
                        <span style="color: #ef4444; font-size: 0.85rem; margin-top: 10px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="scheduled_at" class="form-label">Preferred Date & Time</label>
                    <div style="position: relative;">
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" 
                               class="form-control" value="{{ old('scheduled_at') }}">
                    </div>
                    @error('scheduled_at')
                        <span style="color: #ef4444; font-size: 0.85rem; margin-top: 10px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="req-btns">
                    <button type="submit" class="btn-pill primary">Send Request</button>
                    <a href="{{ url()->previous() }}" class="btn-pill secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
