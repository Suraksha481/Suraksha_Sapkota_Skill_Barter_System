<header id="header" class="site-header">

<style>
/* ===============================
   HEADER BASE
================================ */
#header {
    background: #fff;
    color: var(--text-slate);
    padding: 25px 8%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 1000;
    border-bottom: 1px solid #f0f0f0;
}

#header a {
    color: var(--text-slate);
    text-decoration: none;
    font-weight: 500;
}

/* ===============================
   BRAND
================================ */
.brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.brand .brand-ss-logo {
    width: 36px;
    height: 36px;
    background: var(--primary-teal);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 900;
    letter-spacing: -0.5px;
}

.brand a {
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: -1px;
    color: var(--text-slate) !important;
}

/* ===============================
   NAVIGATION
================================ */
.main-nav-list {
    display: flex;
    gap: 30px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-link {
    text-decoration: none;
    color: var(--text-slate);
    font-weight: 700;
    font-size: 1.05rem;
    padding: 10px 18px;
    border-radius: 30px;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 4px;
}

.nav-link:hover, .nav-link.active {
    color: var(--primary-teal);
    background: rgba(32, 166, 138, 0.08);
}

.nav-item { position: relative; }

/* Pages Dropdown */
.pages-dropdown {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(10px);
    background: #fff;
    min-width: 200px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    display: none;
    z-index: 1000;
    padding: 10px 0;
    border: 1px solid #f0f0f0;
}

.nav-item:hover .pages-dropdown { display: block; }

.dropdown-item {
    display: block;
    padding: 10px 20px;
    color: var(--text-slate);
    font-size: 0.95rem;
    font-weight: 600;
    transition: all 0.3s;
}

.dropdown-item:hover {
    background: var(--bg-light-teal);
    color: var(--primary-teal);
}

.header-icon-btn {
    width: 42px;
    height: 42px;
    background: var(--primary-teal);
    color: #fff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(32, 166, 138, 0.2);
}

.header-icon-btn:hover {
    background: var(--primary-teal-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(32, 166, 138, 0.3);
}

.notif-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ef4444;
    color: #fff;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 10px;
    border: 2px solid var(--primary-teal);
}

/* User Profile Mini */
.user-avatar-mini {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--primary-teal);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    cursor: pointer;
}

/* Dropdowns (Same logic as before, updated styles) */
.header-dropdown {
    position: absolute;
    right: 0;
    top: 50px;
    width: 320px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    display: none;
    z-index: 1001;
    overflow: hidden;
    border: 1px solid #f0f0f0;
}

@media (max-width: 992px) {
    .main-nav { display: none; }
}
</style>

<div class="brand">
    <div class="brand-ss-logo">SS</div>
    <a href="{{ url('/') }}">SkillSwap</a>
</div>

<nav class="main-nav">
    <ul class="main-nav-list">
        <li class="nav-item"><a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a></li>
        <li class="nav-item"><a href="{{ url('/about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">About</a></li>
        @guest
        <li class="nav-item"><a href="{{ url('/service') }}" class="nav-link {{ request()->is('service') ? 'active' : '' }}">Services</a></li>
        @endguest
        <li class="nav-item">
            <a href="#" class="nav-link {{ (request()->is('find-skill') || request()->is('privacy-policy') || request()->is('terms-of-use') || request()->is('help-center')) ? 'active' : '' }}">
                Pages
                <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </a>
            <div class="pages-dropdown">
                <a href="{{ url('/find-skill') }}" class="dropdown-item">Find Skills</a>
                @auth <a href="{{ url('/match') }}" class="dropdown-item">Skill Matching</a> @endauth
                <a href="{{ route('privacy-policy') }}" class="dropdown-item">Privacy Policy</a>
                <a href="{{ url('/terms-of-use') }}" class="dropdown-item">Terms of Use</a>
                <a href="{{ url('/help-center') }}" class="dropdown-item">Help Center</a>
            </div>
        </li>
        <li class="nav-item"><a href="{{ url('/contact') }}" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
    </ul>
</nav>

<div class="nav-actions">

    @guest
        <a href="{{ route('login') }}" class="btn-pill secondary">Login</a>
        <a href="{{ route('register') }}" class="btn-pill primary">Get started</a>
    @endguest

    @auth
        <div class="user-profile" style="position:relative; display:flex; gap:12px; align-items:center;">
            <!-- Messenger -->
            <a href="{{ route('messenger.index') }}" class="header-icon-btn" title="Messages">
                <svg style="width:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
            </a>

            <!-- Notifications -->
            <div style="position:relative;">
                @php
                    $notifications = Auth::user()->notifications()->latest()->take(6)->get();
                    $unreadCount = Auth::user()->unreadNotifications()->count();
                @endphp
                <button id="notif-toggle" class="header-icon-btn">
                    <svg style="width:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @if($unreadCount > 0)
                        <span class="notif-badge">{{ $unreadCount }}</span>
                    @endif
                </button>
                <div id="notif-dropdown" class="header-dropdown notif-card">
                    <div class="notif-header" style="padding:15px; border-bottom:1px solid #eee; display:flex; justify-content:space-between; align-items:center;">
                        <strong style="color:#000">Notifications</strong>
                        @if($unreadCount > 0)
                            <form method="POST" action="{{ route('notifications.read-all') }}">@csrf<button type="submit" style="background:none; border:none; color:var(--primary-teal); font-size:12px; cursor:pointer;">Mark all read</button></form>
                        @endif
                    </div>
                    <div style="max-height:280px; overflow-y:auto;">
                        @forelse($notifications as $n)
                            <div style="padding:12px 15px; border-bottom:1px solid #f9f9f9; background: #fff">
                                @php
                                    $notifUrl = $n->data['url'] ?? (isset($n->data['request_id']) ? route('requests.index') : '#');
                                @endphp
                                <a href="{{ $notifUrl }}" style="display:block; text-decoration: none;">
                                    <div style="font-size:13px; color:#000">{{ $n->data['message'] ?? 'Notification' }}</div>
                                    <small style="color:#888;">{{ $n->created_at->diffForHumans() }}</small>
                                </a>
                            </div>
                        @empty
                            <div style="padding:20px; text-align:center; color:#ccc;">No notifications</div>
                        @endforelse
                    </div>
                    <div style="padding:10px; text-align:center; border-top:1px solid #eee;"><a href="{{ route('notifications.index') }}" style="font-size:13px; color:var(--primary-teal)">View all</a></div>
                </div>
            </div>

            <!-- Profile -->
            <div style="position:relative;">
                <div id="profile-toggle" class="user-avatar-mini">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div id="profile-dropdown" class="header-dropdown">
                    <div style="padding:20px; text-align:center; border-bottom:1px solid #eee;">
                        <div class="user-avatar-mini" style="width:60px; height:60px; margin:0 auto 10px; font-size:24px;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <div style="font-weight:700; color:#000;">{{ Auth::user()->name }}</div>
                        <div style="font-size:12px; color:#888;">{{ Auth::user()->email }}</div>
                    </div>
                    <ul style="list-style:none; padding:10px 0;">
                        <li><a href="{{ route('dashboard') }}" style="display:block; padding:8px 20px; font-size:14px;">Dashboard</a></li>
                        @if(Auth::user()->isStudent())
                            <li><a href="{{ route('premium.index') }}" style="display:block; padding:8px 20px; font-size:14px;">Premium</a></li>
                        @endif
                        <li><a href="{{ route('profile.show') }}" style="display:block; padding:8px 20px; font-size:14px;">Profile</a></li>
                        <li><a href="{{ route('my.skills') }}" style="display:block; padding:8px 20px; font-size:14px;">My Skills</a></li>
                        <li><a href="{{ route('requests.index') }}" style="display:block; padding:8px 20px; font-size:14px;">Requests</a></li>
                        <li><a href="{{ route('sessions.index') }}" style="display:block; padding:8px 20px; font-size:14px;">Sessions</a></li>
                        <li><a href="{{ route('rewards.index') }}" style="display:block; padding:8px 20px; font-size:14px;">Rewards</a></li>
                        <li style="border-top:1px solid #eee; margin-top:5px; padding-top:5px;">
                            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" style="width:100%; text-align:left; background:none; border:none; padding:8px 20px; font-size:14px; cursor:pointer; color:#e74c3c;">Logout</button></form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endauth
</div>

</header>

<script>
document.getElementById('notif-toggle')?.addEventListener('click', function(){
    let drop = document.getElementById('notif-dropdown');
    drop.style.display = drop.style.display === 'block' ? 'none' : 'block';
});

document.getElementById('profile-toggle')?.addEventListener('click', function(){
    let drop = document.getElementById('profile-dropdown');
    drop.style.display = drop.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', function(e){
    if (!e.target.closest('.user-profile')) {
        const pDrop = document.getElementById('profile-dropdown');
        const nDrop = document.getElementById('notif-dropdown');
        if(pDrop) pDrop.style.display = 'none';
        if(nDrop) nDrop.style.display = 'none';
    }
});
</script>
