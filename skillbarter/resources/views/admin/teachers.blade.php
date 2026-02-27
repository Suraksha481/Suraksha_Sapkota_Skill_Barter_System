@extends('admin.layout')

@section('title', $title ?? 'Teachers')
@section('page-title', $title ?? 'Teachers')

@section('content')
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="text-align:left;border-bottom:1px solid #e5e7eb"><th>Name</th><th>Email</th><th>Approved</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($teachers as $t)
                <tr style="border-bottom:1px solid #f3f4f6">
                    <td>{{ $t->name }}</td>
                    <td>{{ $t->email }}</td>
                    <td>{{ $t->is_teacher_approved ? 'Yes' : 'No' }}</td>
                    <td>
                        @if(!$t->is_teacher_approved)
                            <form method="POST" action="{{ route('admin.teachers.approve', $t->id) }}" style="display:inline">@csrf<button>Approve</button></form>
                            <form method="POST" action="{{ route('admin.teachers.reject', $t->id) }}" style="display:inline">@csrf<button>Reject</button></form>
                        @else
                            <form method="POST" action="{{ route('admin.teachers.reject', $t->id) }}" style="display:inline">@csrf<button>Unapprove</button></form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:12px">{{ $teachers->links() }}</div>

@endsection
