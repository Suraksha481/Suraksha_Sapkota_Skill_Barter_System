@extends('app')

@section('content')

<section class="skill-detail-container">
    <div class="skill-hero-section">
        <div class="hero-left">
            <div class="user-meta-top">
                <div class="mini-avatar-circle">SS</div>
                <span class="creator-name">Skill Swap</span>
            </div>
            
            <h1 class="skill-main-title">{{ $skill->title }}</h1>
            
            <div class="skill-sub-info">
                <span class="category-badge">{{ strtoupper($skill->category) }}</span>
                <span class="meta-divider">•</span>
                <span class="meta-item">{{ isset($teachers) ? $teachers->count() : 0 }} Experts</span>
                <span class="meta-divider">•</span>
                <span class="meta-item">Skill </span>
            </div>

            <div class="hero-action-area">
                @auth
                    @if($isAdded)
                        <button class="btn-main-action disabled" disabled style="background: #111; color: #fff; border-color: #111; cursor: not-allowed; opacity: 0.6;">Already Added</button>
                    @else
                        @php $user = auth()->user(); @endphp
                        @if($user->isTeacher() && ! $user->isStudent())
                            <button class="btn-main-action add-skill-btn" data-skill-id="{{ $skill->id }}" data-type="offer">Add to My Skills</button>
                        @elseif($user->isStudent() && ! $user->isTeacher())
                            <button class="btn-main-action add-skill-btn" data-skill-id="{{ $skill->id }}" data-type="request">Add to My Skills</button>
                        @else
                            <div class="action-complex">
                                <select class="type-select-premium add-skill-type">
                                    <option value="offer">Teach it</option>
                                    <option value="request">Learn it</option>
                                </select>
                                <button class="btn-main-action add-skill-btn" data-skill-id="{{ $skill->id }}">Add Skill</button>
                            </div>
                        @endif
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn-main-action">Join to Master</a>
                @endauth
            </div>
        </div>

        <div class="hero-right">
            <div class="skill-visual-frame">
                <div class="visual-placeholder">
                    <div class="visual-logo">✨</div>
                    <div class="visual-text">Premium Visual Slot</div>
                </div>
            </div>
        </div>
    </div>

    <div class="skill-content-tabs">
        <div class="tab-headers">
            <button class="tab-btn active" data-tab="about">About</button>
            <button class="tab-btn" data-tab="teachers">Teachers ({{ isset($teachers) ? $teachers->count() : 0 }})</button>
        </div>

        <div class="tab-panes">
            <div class="tab-pane active" id="about">
                <div class="about-content">
                    <h2 class="pane-title">About this skill</h2>
                    <div class="description-text">
                        {{ $skill->description ?? 'No detailed description available for this skill yet.' }}
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="teachers">
                <h2 class="pane-title">Available Mentors</h2>
                @if(isset($teachers) && $teachers->isNotEmpty())
                    <div class="teachers-minimal-grid">
                        @foreach($teachers as $teacher)
                            <div class="teacher-card-clean">
                                <img src="{{ $teacher->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($teacher->name).'&background=000&color=fff' }}" alt="{{ $teacher->name }}" class="clean-avatar">
                                <div class="clean-info">
                                    <h3>{{ $teacher->name }}</h3>
                                    <p>{{ Str::limit($teacher->bio, 80) }}</p>
                                    <a href="{{ route('teachers.show', $teacher) }}" class="btn-profile-link">View Profile</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="empty-msg">No teachers available for this skill at the moment.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    :root {
        --primary-bg: #ffffff;
        --secondary-bg: #fdfdfd;
        --text-main: #000000;
        --text-muted: #111111;
        --accent-color: #000000;
        --border-light: #e5e5e5;
        --card-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    .skill-detail-container {
        max-width: 1250px;
        margin: 3rem auto;
        padding: 0 2rem;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* HERO SECTION */
    .skill-hero-section {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 5rem;
        align-items: center;
        margin-bottom: 5rem;
    }

    .user-meta-top {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 2rem;
    }

    .mini-avatar-circle {
        width: 36px;
        height: 36px;
        background: #000;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
    }

    .creator-name {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1.5px;
        color: var(--text-muted);
    }

    .skill-main-title {
        font-size: 4rem;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 1.5rem;
        color: var(--text-main);
        letter-spacing: -2px;
    }

    .skill-sub-info {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 0.95rem;
        color: var(--text-muted);
        margin-bottom: 3rem;
    }

    .category-badge {
        background: #000;
        color: #fff;
        padding: 6px 14px;
        border-radius: 4px;
        font-weight: 800;
        font-size: 0.7rem;
        letter-spacing: 1px;
    }

    .meta-divider {
        color: #ccc;
    }

    .hero-action-area {
        margin-top: 1rem;
    }

    .btn-main-action {
        background: #000;
        color: #fff;
        padding: 18px 45px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.95rem;
        border: 2px solid #000;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

   

    .action-complex {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .type-select-premium {
        padding: 16px;
        border-radius: 8px;
        border: 2px solid #000;
        background: #fff;
        font-weight: 700;
        outline: none;
    }

    /* RIGHT VISUAL */
    .skill-visual-frame {
        width: 100%;
        aspect-ratio: 16/10;
        background: #000;
        border-radius: 24px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 40px 80px rgba(0,0,0,0.15);
    }

    .visual-placeholder {
        text-align: center;
    }

    .visual-logo {
        font-size: 5rem;
        margin-bottom: 1rem;
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .visual-text {
        color: #333;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 0.85rem;
    }

    /* TABS */
    .skill-content-tabs {
        border-top: 2px solid #f0f0f0;
        padding-top: 3rem;
    }

    .tab-headers {
        display: flex;
        gap: 40px;
        margin-bottom: 4rem;
    }

    .tab-btn {
        background: none;
        border: none;
        font-size: 1.1rem;
        font-weight: 800;
        color: #999;
        cursor: pointer;
        padding-bottom: 12px;
        position: relative;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: #000;
    }

    .tab-pane {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tab-pane.active {
        display: block;
    }

    .pane-title {
        font-size: 1.75rem;
        font-weight: 900;
        margin-bottom: 2rem;
        letter-spacing: -1px;
    }

    .description-text {
        color: #444;
        font-size: 1.2rem;
        line-height: 1.9;
        max-width: 850px;
    }

    /* TEACHERS GRID IN TAB */
    .teachers-minimal-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 2.5rem;
    }

    .teacher-card-clean {
        display: flex;
        gap: 20px;
        align-items: center;
        padding: 2rem;
        background: #fff;
        border: 2px solid #f0f0f0;
        border-radius: 20px;
        transition: all 0.3s;
        border-color: #000;
    }

   

    .clean-avatar {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #000;
        padding: 3px;
    }

    .clean-info h3 {
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .clean-info p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .btn-profile-link {
        font-size: 0.85rem;
        font-weight: 800;
        color: #000;
        text-decoration: none;
        border-bottom: 2px solid #000;
        padding-bottom: 2px;
        transition: opacity 0.3s;
    }


    @media (max-width: 1000px) {
        .skill-hero-section {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 3rem;
        }

        .user-meta-top {
            justify-content: center;
        }

        .skill-sub-info {
            justify-content: center;
        }

        .skill-main-title {
            font-size: 3rem;
        }

        .hero-right {
            order: -1;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-btn');
        const panes = document.querySelectorAll('.tab-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.getAttribute('data-tab');
                
                tabs.forEach(t => t.classList.remove('active'));
                panes.forEach(p => p.classList.remove('active'));

                tab.classList.add('active');
                document.getElementById(target).classList.add('active');
            });
        });
    });
</script>

@endsection
