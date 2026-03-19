<div class="admin-sidebar">

    <div class="admin-logo">
        <h2>SkillXchange</h2>
        <span>Admin Panel</span>
    </div>

    <ul class="admin-menu">

        <li>
            <a href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('admin.users') }}">
                Users
            </a>
        </li>

        <li>
            <a href="{{ route('admin.teachers.pending') }}">
                Teacher Approvals
            </a>
        </li>

        <li>
            <a href="{{ route('admin.skills') }}">
                Skills
            </a>
        </li>
        <li>
            <a href="{{ route('admin.services') }}">
                Services
            </a>
        </li>

        <li>
            <a href="{{ route('admin.subscriptions') }}">
                Subscriptions
            </a>
        </li>
        <li>
            <a href="{{ route('admin.payouts') }}">
                Payouts
            </a>
        </li>

        <li>
            <a href="{{ route('admin.feedbacks') }}">
                Feedbacks
            </a>
        </li>

        <li>
            <a href="{{ route('admin.requests') }}">
                Session Requests
            </a>
        </li>

        <li>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    Logout
                </button>
            </form>
        </li>

    </ul>

</div>
