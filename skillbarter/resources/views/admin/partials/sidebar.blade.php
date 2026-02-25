<div style="padding:28px;">
    <h2 style="margin:0 0 16px 0;">Marketplace Admin</h2>
    <nav>
        <a class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="sidebar-item {{ request()->routeIs('admin.teachers.pending') ? 'active' : '' }}" href="{{ route('admin.teachers.pending') }}">Teacher Applications</a>
        <a class="sidebar-item {{ request()->routeIs('admin.teachers.approved') ? 'active' : '' }}" href="{{ route('admin.teachers.approved') }}">Approved Teachers</a>
        <a class="sidebar-item {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">Users</a>
        <a class="sidebar-item {{ request()->routeIs('admin.skills') ? 'active' : '' }}" href="{{ route('admin.skills') }}">All Skills</a>
        <a class="sidebar-item {{ request()->routeIs('admin.requests') ? 'active' : '' }}" href="{{ route('admin.requests') }}">Student Requests</a>
        <a class="sidebar-item {{ request()->routeIs('admin.subscriptions') ? 'active' : '' }}" href="{{ route('admin.subscriptions') }}">Subscriptions</a>
        <a class="sidebar-item {{ request()->routeIs('admin.feedbacks') ? 'active' : '' }}" href="{{ route('admin.feedbacks') }}">Feedback</a>
        <a class="sidebar-item" href="#">Settings</a>
    </nav>
</div>
