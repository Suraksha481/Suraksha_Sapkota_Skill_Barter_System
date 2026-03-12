@extends('admin.layout')

@section('content')
<section class="container">
    <h1>Users</h1>
    @if(session('status'))<div class="alert">{{ session('status') }}</div>@endif

    <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden">
        <thead style="background:#f8fafc"><tr><th style="padding:8px">Name</th><th style="padding:8px">Email</th><th style="padding:8px">Role</th><th style="padding:8px">Active</th><th style="padding:8px">Actions</th></tr></thead>
        <tbody>
        @foreach($users as $u)
            <tr>
                <td style="padding:8px"><a href="{{ route('admin.users.show', $u->id) }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">{{ $u->name }}</a></td>
                <td style="padding:8px">{{ $u->email }}</td>
                <td style="padding:8px">{{ $u->role ?? '-' }}</td>
                <td style="padding:8px">{{ $u->is_active ? 'Yes' : 'No' }}</td>
                <td style="padding:8px">
                    <form method="POST" action="{{ route('admin.users.toggle-active', $u->id) }}" style="display:inline">
                        @csrf
                        <button type="submit">{{ $u->is_active ? 'Deactivate' : 'Activate' }}</button>
                    </form>

                    <form method="POST" action="{{ route('admin.users.change-role', $u->id) }}" style="display:inline;margin-left:8px">
                        @csrf
                        <select name="role" onchange="this.form.submit()">
                            <option value="" {{ $u->role ? '' : 'selected' }}>No role</option>
                            <option value="student" {{ $u->role==='student' ? 'selected' : '' }}>Student</option>
                            <option value="teacher" {{ $u->role==='teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="admin" {{ $u->role==='admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </form>

                    <form method="POST" action="{{ route('admin.users.delete', $u->id) }}" style="display:inline;margin-left:8px">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $users->links() }}</div>
</section>

@endsection
