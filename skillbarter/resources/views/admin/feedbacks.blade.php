@extends('admin.layout')

@section('title', 'User Feedbacks')
@section('subtitle', 'View and manage user-submitted feedback and ratings')

@section('content')
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Author</th>
                    <th>Target</th>
                    <th>Comment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($feedbacks as $f)
                <tr>
                    <td>{{ $f->id }}</td>
                    <td>{{ $f->author->name ?? $f->author_id }}</td>
                    <td><span class="admin-badge badge-gray">{{ ucfirst($f->target_type) }} #{{ $f->target_id }}</span></td>
                    <td>{{ Str::limit($f->comment, 120) }}</td>
                    <td>
                        <div class="action-buttons">
                            <form method="POST" action="{{ route('admin.feedbacks.delete', $f->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin btn-delete-admin" onclick="return confirm('Delete feedback?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem">{{ $feedbacks->links() }}</div>
@endsection
