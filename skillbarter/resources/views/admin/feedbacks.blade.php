@extends('admin.layout')

@section('title', 'User Feedbacks')
@section('subtitle', 'View and manage user-submitted feedback and ratings')

@section('content')
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden">
        <thead style="background:#f8fafc"><tr><th style="padding:8px">ID</th><th style="padding:8px">Author</th><th style="padding:8px">Target</th><th style="padding:8px">Comment</th><th style="padding:8px">Actions</th></tr></thead>
        <tbody>
        @foreach($feedbacks as $f)
            <tr>
                <td style="padding:8px">{{ $f->id }}</td>
                <td style="padding:8px">{{ $f->author->name ?? $f->author_id }}</td>
                <td style="padding:8px">{{ $f->target_type }} #{{ $f->target_id }}</td>
                <td style="padding:8px">{{ Str::limit($f->comment, 120) }}</td>
                <td style="padding:8px">
                    <form method="POST" action="{{ route('admin.feedbacks.delete', $f->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete feedback?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $feedbacks->links() }}</div>
@endsection
