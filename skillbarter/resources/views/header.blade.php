<header id="header" class="site-header">
  <div class="brand">
    <span class="logo-circle">SS</span>
    <a href="{{ url('/') }}">Skill Swap</a>
  </div>

  <nav class="main-nav">
    <ul>
      <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
      <li><a href="{{ url('/service') }}" class="{{ request()->is('service') ? 'active' : '' }}">Service</a></li>
      <li><a href="{{ url('/find-skill') }}" class="{{ request()->is('find-skill') ? 'active' : '' }}">Find Skill</a></li>
      <li><a href="{{ url('/blogs') }}" class="{{ request()->is('blogs') ? 'active' : '' }}">Blogs</a></li>
      <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a></li>
    </ul>
  </nav>

  <form class="search-hero" method="GET" action="{{ route('find-skill') }}">
        <input
            type="search"
            name="q"
            placeholder="Search skills..."
            value="{{ request('q') }}"
        >
    </form>


  <div class="nav-actions">

    @guest
      {{-- Show for guests --}}
      <a class="btn ghost" href="{{ route('register') }}">Sign Up</a>
      <a class="btn primary" href="{{ route('login') }}">Login</a>
    @endguest

    @auth
      {{-- Show for logged-in users --}}
      <div class="user-profile">
        <span class="user-name">{{ Auth::user()->name }}</span>
        <div class="dropdown">
          <ul>
            <li><a href="{{ route('dashboard') }}">📊 Dashboard</a></li>

            {{-- Teacher-specific menu items --}}
            @if(Auth::user()->isTeacher())
              <li><hr style="margin: 8px 0;"></li>
              <li><strong>👨‍🏫 Teacher</strong></li>
              <li><a href="{{ route('teacher.dashboard') }}">My Teaching</a></li>
              <li><a href="{{ route('teacher.resources.index') }}">📚 Resources</a></li>
              <li><a href="{{ route('teacher.analytics') }}">📊 Analytics</a></li>
            @endif

            {{-- Student-specific menu items --}}
            @if(Auth::user()->isStudent())
              <li><hr style="margin: 8px 0;"></li>
              <li><strong>🎓 Student</strong></li>
              <li><a href="{{ route('student.dashboard') }}">My Learning</a></li>
              <li><a href="{{ route('student.learning-path') }}">📖 Learning Path</a></li>
              <li><a href="{{ route('student.progress') }}">📈 Progress</a></li>
            @endif

            {{-- Shared menu items --}}
            <li><hr style="margin: 8px 0;"></li>
              <li><a href="{{ route('profile.show') }}">👤 Profile</a></li>
            <li><a href="{{ route('my.skills') }}">⭐ My Skills</a></li>
            <li><a href="{{ route('requests.index') }}">📝 Requests</a></li>
            <li><a href="{{ route('rewards.index') }}">🏆 Rewards</a></li>
            <li><a href="{{ route('premium.index') }}">💎 Premium</a></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">🚪 Logout</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    @endauth

  </div>
</header>

<script>

    if (window.location.pathname === '/signup') {
        document.getElementById('header').style.display = 'none';
    }
</script>
<script>

    if (window.location.pathname === '/login') {
        document.getElementById('header').style.display = 'none';
    }
</script>

