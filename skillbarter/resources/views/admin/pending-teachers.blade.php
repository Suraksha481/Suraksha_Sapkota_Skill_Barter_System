@extends('admin.layout')

@section('title', 'Pending Teachers')
@section('page-title', 'Pending Teachers')

@section('content')
    <p>These accounts are waiting for admin approval. Click a name to view the public profile.</p>

    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="text-align:left;border-bottom:1px solid #e5e7eb"><th>Name</th><th>Email</th><th>Joined</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($teachers as $t)
                <tr style="border-bottom:1px solid #f3f4f6">
                    <td><a href="{{ route('teachers.show', $t) }}" target="_blank">{{ $t->name }}</a></td>
                    <td>{{ $t->email }}</td>
                    <td>{{ $t->created_at->format('Y-m-d') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.teachers.approve', $t->id) }}" style="display:inline">@csrf<button>Approve</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:12px">{{ $teachers->links() }}</div>
@endsection
