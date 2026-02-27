<header id="header" class="site-header">

<style>
/* ===============================
   HEADER BASE
================================ */
#header {
    background: #000;
    color: #fff;
    padding: 15px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

#header a {
    color: #fff;
    text-decoration: none;
}

/* ===============================
   BRAND
================================ */
.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #fff;
    color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

/* ===============================
   NAVIGATION
================================ */
.main-nav ul {
    display: flex;
    gap: 25px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.main-nav a:hover {
    opacity: 0.7;
}

/* ===============================
   SEARCH
================================ */
.search-hero input {
    padding: 8px 14px;
    border-radius: 6px;
    border: 1px solid #333;
    background: #111;
    color: #fff;
}

.search-hero input:focus {
    outline: none;
    border-color: #555;
}

/* Notification Button */
.notif-btn {
    width: 42px;
    height: 42px;
    background: #fff;
    color: #000;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
}

.notif-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #000;
    color: #fff;
    font-size: 11px;
    padding: 3px 6px;
    border-radius: 50%;
}

/* Dropdown Card */
.notif-card {
    position: absolute;
    right: 0;
    top: 55px;
    width: 360px;
    background: #fff;
    color: #000;
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.18);
    display: none;
    overflow: hidden;
    z-index: 999;
}

/* Header */
.notif-header {
    padding: 14px 16px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.mark-all {
    background: none;
    border: none;
    color: #000;
    font-size: 12px;
    cursor: pointer;
}

/* Fix notification text color */
.notif-card,
.notif-card a,
.notif-card .notif-message,
.notif-card .notif-time {
    color: #000 !important;
}

.notif-item.unread {
    background: #f2f2f2;
}

.notif-item.unread a {
    color: #000 !important;
}

/* Body */
.notif-body {
    max-height: 300px;
    overflow-y: auto;
}

.notif-item {
    padding: 12px 16px;
    border-bottom: 1px solid #f0f0f0;
}

.notif-item a {
    color: #000;
    text-decoration: none;
    display: block;
}

.notif-item:hover {
    background: #f7f7f7;
}

.unread {
    background: #f1f1f1;
}

.notif-message {
    font-size: 14px;
    font-weight: 500;
}

.notif-time {
    font-size: 12px;
    color: #777;
}

/* Empty state */
.empty-notif {
    padding: 20px;
    text-align: center;
    color: #888;
}

/* Footer */
.notif-footer {
    padding: 10px;
    text-align: center;
    border-top: 1px solid #eee;
}

.notif-footer a {
    font-size: 13px;
    color: #000;
}

/* ===============================
   PROFILE AVATAR
================================ */
.profile-box .profile-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #fff;
    color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    cursor: pointer;
}

/* ===============================
   PROFILE DROPDOWN
================================ */
#profile-dropdown {
    position: absolute;
    right: 0;
    top: 55px;
    width: 420px;
    background: #fff;
    color: #000;
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.18);
    display: none;
    overflow: hidden;
}

#profile-dropdown ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

/* Profile Header */
.profile-card {
    padding: 25px 20px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.profile-card .profile-avatar {
    width: 70px;
    height: 70px;
    margin: 0 auto 10px;
    background: #f2f2f2;
    font-size: 26px;
}

.profile-name {
    font-size: 18px;
    font-weight: 600;
}

.profile-sub {
    font-size: 13px;
    color: #777;
}

/* Contact Info */
.contact-row {
    padding: 8px 20px;
    text-align: center;
    font-size: 14px;
    color: #444;
}

/* Section Title */
.section-title {
    padding: 8px 20px;
    font-size: 12px;
    text-transform: uppercase;
    color: #888;
}

/* Links */
#profile-dropdown li a {
    display: block;
    padding: 12px 20px;
    color: #000;
}

#profile-dropdown li a:hover {
    background: #f5f5f5;
}

/* Logout */
.logout-btn {
    width: 100%;
    padding: 12px 20px;
    border: none;
    background: transparent;
    color: #000;
    text-align: left;
    cursor: pointer;
}

.logout-btn:hover {
    background: #f5f5f5;
}
</style>

<div class="brand">
    <span class="logo-circle">SS</span>
    <a href="{{ url('/') }}">Skill Swap</a>
</div>

<nav class="main-nav">
    <ul>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/service') }}">Service</a></li>
        <li><a href="{{ url('/find-skill') }}">Find Skill</a></li>
        <li><a href="{{ url('/blogs') }}">Blogs</a></li>
        <li><a href="{{ url('/about') }}">About</a></li>
    </ul>
</nav>

<form class="search-hero" method="GET" action="{{ route('find-skill') }}">
    <input type="search" name="q" placeholder="Search skills..." value="{{ request('q') }}">
</form>

<div class="nav-actions">

@guest
    <a class="btn ghost" href="{{ route('register') }}">Sign Up</a>
    <a class="btn primary" href="{{ route('login') }}">Login</a>
@endguest

@auth
<div class="user-profile" style="position:relative; display:flex; gap:15px; align-items:center;">

  <!-- Notifications -->
<div class="notifications" style="position:relative;">

    @php
        $notifications = Auth::user()->notifications()->latest()->take(8)->get();
        $unreadCount = Auth::user()->unreadNotifications()->count();
    @endphp

    <!-- Bell -->
    <div id="notif-toggle" class="notif-btn">
        🔔
        @if($unreadCount > 0)
            <span class="notif-badge">{{ $unreadCount }}</span>
        @endif
    </div>

    <!-- Dropdown -->
    <div id="notif-dropdown" class="notif-card">

        <div class="notif-header">
            <strong>Notifications</strong>
            @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button type="submit" class="mark-all">Mark all read</button>
            </form>
            @endif
        </div>

        <div class="notif-body">
            @forelse($notifications as $notification)
                <div class="notif-item {{ $notification->read_at ? '' : 'unread' }}">
                    <a href="{{ isset($notification->data['request_id']) ? route('requests.index') : '#' }}">
                        <div class="notif-message">
                            {{ $notification->data['message'] ?? 'New notification' }}
                        </div>
                        <small class="notif-time">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </a>
                </div>
            @empty
                <div class="empty-notif">
                    No notifications yet.
                </div>
            @endforelse
        </div>

        <div class="notif-footer">
            <a href="{{ route('notifications.index') }}">View all</a>
        </div>

    </div>
</div>

    <!-- Profile -->
    <div class="profile-box" id="profile-toggle">
        <div class="profile-avatar">
            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
        </div>
    </div>

    <div id="profile-dropdown">
        <ul>
            <li>
                <div class="profile-card">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </div>
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-sub">{{ Auth::user()->username ?? '' }}</div>
                </div>
            </li>

            <li class="contact-row">{{ Auth::user()->email }}</li>

            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('profile.show') }}">Profile</a></li>
            <li><a href="{{ route('my.skills') }}">My Skills</a></li>
            <li><a href="{{ route('requests.index') }}">Requests</a></li>
            <li><a href="{{ route('rewards.index') }}">Rewards</a></li>
            <li><a href="{{ route('premium.index') }}">Premium</a></li>

            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </li>
        </ul>
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
        document.getElementById('profile-dropdown').style.display = 'none';
        document.getElementById('notif-dropdown').style.display = 'none';
    }
});
</script>
