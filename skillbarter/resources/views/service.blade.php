@extends('app')

@section('page_title', 'Services - SkillSwap')

@section('content')

<style>
:root {
    --srv-primary: #20a68a;
    --srv-text-main: #0f172a;
    --srv-text-muted: #64748b;
    --srv-bg: #f8fafc;
}

.srv-page-wrapper {
    background: var(--srv-bg);
    min-height: 100vh;
    padding-bottom: 120px;
    font-family: 'Inter', sans-serif;
}

.srv-hero-clean {
    padding: 100px 5% 60px;
    text-align: center;
    background: #aad9d0;
    border-radius: 0 0 50px 50px;
}

.srv-hero-clean h1 {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: #080808;
    letter-spacing: -1px;
    margin-bottom: 20px;
}

.srv-hero-clean p {
    font-size: 1.15rem;
    color: #666;
    max-width: 650px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Minimal Grid */
.srv-grid {
    max-width: 1200px;
    margin: 0 auto 80px;
    padding: 0 5%;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
}

.srv-card-clean {
    background: #ffffff;
    border-radius: 20px;
    padding: 45px 40px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(0,0,0,0.02);
}

.srv-card-clean:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
}

.srv-icon-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: rgba(32, 166, 138, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
}

.srv-icon-placeholder svg {
    width: 28px;
    height: 28px;
    color: var(--srv-primary);
}

.srv-card-clean h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--srv-text-main);
    margin-bottom: 15px;
    line-height: 1.3;
    overflow-wrap: break-word;
    word-break: break-word;
}

.srv-card-clean p {
    color: var(--srv-text-muted);
    font-size: 1.05rem;
    line-height: 1.6;
    margin: 0;
    overflow-wrap: break-word;
    word-break: break-word;
}

.cta-box-modern {
    background: #ffffff;
    max-width: 1100px;
    margin: 0 auto;
    padding: 60px;
    border-radius: 30px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.03);
}

.cta-box-modern h2 {
    font-size: 2rem;
    font-weight: 800;
    color: var(--srv-text-main);
    margin-bottom: 30px;
}

.cta-btn {
    display: inline-block;
    padding: 16px 40px;
    background: var(--srv-primary);
    color: #fff;
    font-weight: 700;
    border-radius: 30px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 1.1rem;
}

.cta-btn:hover {
    background: #178a72;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(32, 166, 138, 0.3);
}

@media (max-width: 768px) {
    .srv-grid { grid-template-columns: 1fr; }
    .srv-card-clean { padding: 35px 30px; }
}
</style>

<div class="srv-page-wrapper">
    <header class="srv-hero-clean">
        <h1><span style="color:#050606;">Services</span></h1>
        <p>A comprehensive look at all the features and capabilities we provide to facilitate your skill-bartering journey.</p>
    </header>

    <main class="srv-grid">
        @forelse($services as $service)
            <div class="srv-card-clean">
                <div class="srv-icon-placeholder">
                    {{-- Generic elegant check/star icon for the design --}}
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3>{{ $service->title }}</h3>
                <p>{{ $service->description }}</p>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #fff; border-radius: 20px;">
                <p style="color: #64748b; font-size: 1.1rem;">No services have been added yet.</p>
            </div>
        @endforelse
    </main>

    <div style="padding: 0 5%;">
        <div class="cta-box-modern">
            <h2>Ready to unlock your true potential?</h2>
            <a href="{{ route('register') }}" class="btn-pill primary" style="padding: 15px 40px;">Join the Community</a>

        </div>
    </div>
</div>

@endsection
