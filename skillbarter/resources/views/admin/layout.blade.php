<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="sidebar">
    <h2>Skill Barter Admin</h2>

    <a href="/admin/dashboard">📊 Dashboard</a>

    <a href="/admin/teacher-applications" class="active">👨‍🏫 Teacher Applications</a>
    <a href="#">✔ Approved Teachers</a>
    <a href="#">✖ Rejected Teachers</a>

    <a href="#">🎓 Students</a>
    <a href="#">📚 Skills</a>

    <a href="#">📩 Session Requests</a>
    <a href="#">✔ Active Sessions</a>
    <a href="#">✔ Completed Sessions</a>

    <a href="#">⭐ Feedback</a>

    <a href="#">💎 Subscriptions</a>

    <a href="#">📁 Resources</a>

    <a href="#">📜 Activity Logs</a>

    <hr>
    <a href="#">⚙ Settings</a>
</div>

<div class="main">
    @yield('content')
</div>

</body>
</html>
