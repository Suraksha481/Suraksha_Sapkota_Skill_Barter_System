@extends('admin.layout')

@section('title', 'Teacher Approvals')
@section('page-title', 'Teacher Approvals')

@section('content')
    <p>The tables below show all teacher accounts on the system. Use the approve buttons for new applicants and the unapprove links to revoke access.</p>

    {{-- pending teachers first --}}
    <h2 style="margin-top:1.5rem;font-size:1.25rem;">Pending Approvals</h2>
    @if($pending->count())
    <table style="width:100%;border-collapse:collapse;margin-bottom:1.5rem">
        <thead>
            <tr style="text-align:left;border-bottom:1px solid #e5e7eb"><th>Name</th><th>Email</th><th>Joined</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($pending as $t)
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
    {{ $pending->links() }}
    @else
        <p>No pending teachers.</p>
    @endif

    {{-- all teachers list --}}
    <h2 style="margin-top:2rem;font-size:1.25rem;">All Teachers</h2>
    <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden">
        <thead style="background:#f8fafc"><tr><th style="padding:8px">Name</th><th style="padding:8px">Email</th><th style="padding:8px">Approved</th><th style="padding:8px">Joined</th><th style="padding:8px">Actions</th></tr></thead>
        <tbody>
            @foreach($all as $t)
                <tr>
                    <td style="padding:8px"><a href="{{ route('teachers.show', $t) }}" target="_blank">{{ $t->name }}</a></td>
                    <td style="padding:8px">{{ $t->email }}</td>
                    <td style="padding:8px">{{ $t->is_teacher_approved ? 'Yes' : 'No' }}</td>
                    <td style="padding:8px">{{ $t->created_at->format('Y-m-d') }}</td>
                    <td style="padding:8px">
                        @if(!$t->is_teacher_approved)
                            <form method="POST" action="{{ route('admin.teachers.approve', $t->id) }}" style="display:inline">@csrf<button>Approve</button></form>
                        @else
                            <form method="POST" action="{{ route('admin.teachers.reject', $t->id) }}" style="display:inline">@csrf<button>Unapprove</button></form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:12px">{{ $all->links() }}</div>
@endsection
