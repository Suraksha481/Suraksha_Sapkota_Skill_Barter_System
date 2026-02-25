@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-white shadow">Total Users: <strong>{{ $stats['users'] }}</strong></div>
        <div class="p-4 bg-white shadow">Total Teachers: <strong>{{ $stats['teachers'] }}</strong></div>
        <div class="p-4 bg-white shadow">Total Students: <strong>{{ $stats['students'] }}</strong></div>
        <div class="p-4 bg-white shadow">Total Skills: <strong>{{ $stats['skills'] }}</strong></div>
        <div class="p-4 bg-white shadow">Total Sessions: <strong>{{ $stats['requests'] }}</strong></div>
        <div class="p-4 bg-white shadow">Premium Members: <strong>{{ $stats['premium_members'] }}</strong></div>
        <div class="p-4 bg-white shadow col-span-3">Revenue: <strong>{{ currency_format($stats['revenue'] ?? 0) }}</strong></div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <section class="bg-white p-4 shadow">
            <h2 class="font-semibold mb-2">User Management</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Role</th><th>Active</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->role ?? '-' }}</td>
                            <td>{{ $u->is_active ? 'Yes' : 'No' }}</td>
                            <td>
                                <form action="{{ route('admin.users.toggle-active', $u->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit">{{ $u->is_active ? 'Ban' : 'Activate' }}</button>
                                </form>
                                <form action="{{ route('admin.users.change-role', $u->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()">
                                        <option value="">--role--</option>
                                        <option value="admin">admin</option>
                                        <option value="teacher">teacher</option>
                                        <option value="student">student</option>
                                    </select>
                                </form>
                                <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="bg-white p-4 shadow">
            <h2 class="font-semibold mb-2">Skill Management</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr><th>Skill</th><th>Created</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($recentSkills as $s)
                        <tr>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->created_at->diffForHumans() }}</td>
                            <td>
                                <form action="{{ route('admin.skills.delete', $s->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete skill?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>

    <div class="grid grid-cols-3 gap-6 mt-6">
        <section class="bg-white p-4 shadow col-span-2">
            <h2 class="font-semibold mb-2">Session & Request Monitoring</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr><th>#</th><th>Requester</th><th>Responder</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($recentRequests as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ optional($r->requester)->name }}</td>
                            <td>{{ optional($r->responder)->name }}</td>
                            <td>{{ $r->status }}</td>
                            <td>
                                <form action="{{ route('admin.requests.update-status', $r->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending">pending</option>
                                        <option value="accepted">accepted</option>
                                        <option value="declined">declined</option>
                                        <option value="completed">completed</option>
                                        <option value="cancelled">cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="bg-white p-4 shadow">
            <h2 class="font-semibold mb-2">Feedback Monitoring</h2>
            <ul>
                @foreach($recentFeedbacks as $f)
                    <li>
                        <strong>{{ optional($f->author)->name }}</strong>: {{ Str::limit($f->comment, 80) }}
                        <form action="{{ route('admin.feedbacks.delete', $f->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>

    <section class="bg-white p-4 shadow mt-6">
        <h2 class="font-semibold mb-2">Premium Subscriptions</h2>
        <table class="w-full text-sm">
            <thead><tr><th>User</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($recentSubscriptions as $s)
                    <tr>
                        <td>{{ optional($s->user)->name ?? $s->user_id }}</td>
                        <td>{{ currency_format($s->price) }}</td>
                        <td>{{ $s->status }}</td>
                        <td>
                            <form action="{{ route('admin.subscriptions.cancel', $s->id) }}" method="POST">
                                @csrf
                                <button type="submit">Cancel</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

</div>
@endsection
@extends('app')

@section('content')

<section class="container">
    <h1>Admin Dashboard</h1>
    <p class="muted">Overview of site metrics</p>

    <div style="display:flex;gap:16px;margin-top:1rem;flex-wrap:wrap">
        <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 0 0 1px #eee;min-width:160px">
            <div style="font-size:12px;color:#6b7280">Users</div>
            <div style="font-size:20px;font-weight:700">{{ $stats['users'] }}</div>
        </div>
        <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 0 0 1px #eee;min-width:160px">
            <div style="font-size:12px;color:#6b7280">Teachers</div>
            <div style="font-size:20px;font-weight:700">{{ $stats['teachers'] }}</div>
        </div>
        <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 0 0 1px #eee;min-width:160px">
            <div style="font-size:12px;color:#6b7280">Students</div>
            <div style="font-size:20px;font-weight:700">{{ $stats['students'] }}</div>
        </div>
        <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 0 0 1px #eee;min-width:160px">
            <div style="font-size:12px;color:#6b7280">Requests</div>
            <div style="font-size:20px;font-weight:700">{{ $stats['requests'] }}</div>
        </div>
        <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 0 0 1px #eee;min-width:160px">
            <div style="font-size:12px;color:#6b7280">Messages</div>
            <div style="font-size:20px;font-weight:700">{{ $stats['messages'] }}</div>
        </div>
        <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 0 0 1px #eee;min-width:160px">
            <div style="font-size:12px;color:#6b7280">Skills</div>
            <div style="font-size:20px;font-weight:700">{{ $stats['skills'] }}</div>
        </div>
        <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 0 0 1px #eee;min-width:160px">
            <div style="font-size:12px;color:#6b7280">Premium Members</div>
            <div style="font-size:20px;font-weight:700">{{ $stats['premium_members'] }}</div>
        </div>
        <div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 0 0 1px #eee;min-width:160px">
            <div style="font-size:12px;color:#6b7280">Revenue</div>
            <div style="font-size:20px;font-weight:700">{{ $stats['revenue'] ?? 0 }}</div>
        </div>
    </div>

    <div style="margin-top:2rem">
        <div style="display:flex;align-items:center;justify-content:space-between">
            <h3>Recent Users</h3>
            <div>
                <a href="{{ route('admin.users') }}">Manage Users</a> ·
                <a href="{{ route('admin.skills') }}">Manage Skills</a> ·
                <a href="{{ route('admin.requests') }}">Session Requests</a> ·
                <a href="{{ route('admin.feedbacks') }}">Feedback</a> ·
                <a href="{{ route('admin.subscriptions') }}">Subscriptions</a>
            </div>
        </div>
        <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden">
            <thead style="background:#f8fafc"><tr><th style="padding:8px;text-align:left">Name</th><th style="padding:8px;text-align:left">Email</th><th style="padding:8px">Role</th></tr></thead>
            <tbody>
            @foreach($recentUsers as $u)
                <tr><td style="padding:8px">{{ $u->name }}</td><td style="padding:8px">{{ $u->email }}</td><td style="padding:8px">{{ $u->role ?? '-' }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>

</section>

@endsection
