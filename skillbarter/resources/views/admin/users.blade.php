@extends('admin.layout')

@section('title', 'User Management')
@section('subtitle', 'Manage platform users, roles, and account status')

@section('content')
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
        @foreach($users as $u)
            <tr>
                <td><a href="{{ route('admin.users.show', $u->id) }}">{{ $u->name }}</a></td>
                <td>{{ $u->email }}</td>
                <td><span class="admin-badge badge-teal">{{ ucfirst($u->role ?? 'Unassigned') }}</span></td>
                <td><span class="admin-badge {{ $u->is_active ? 'badge-teal' : 'badge-red' }}">{{ $u->is_active ? 'Active' : 'Banned' }}</span></td>
                <td>
                    <div class="action-buttons">
                    <form method="POST" action="{{ route('admin.users.toggle-active', $u->id) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-admin {{ $u->is_active ? 'btn-delete-admin' : 'btn-primary-admin' }}">
                            {{ $u->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.users.delete', $u->id) }}" style="display:inline;margin-left:8px">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-delete-admin" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem">{{ $users->links() }}</div>
@endsection
