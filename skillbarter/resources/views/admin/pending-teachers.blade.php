@extends('admin.layout')

@section('title', 'Teacher Approvals')
@section('subtitle', 'Review and approve new teacher applications')

@section('content')

    {{-- pending teachers first --}}
    <h2 style="margin-top:1.5rem;font-size:1.25rem;">Pending Approvals</h2>
    @if($pending->count())
    <div class="table-container" style="margin-bottom: 2rem;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Documents</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pending as $t)
                    <tr>
                        <td><a href="{{ route('admin.users.show', $t->id) }}" target="_blank">{{ $t->name }}</a></td>
                        <td>{{ $t->email }}</td>
                        <td>
                            @if($t->teacherProfile)
                                @if($t->teacherProfile->bank_account)
                                    <div style="font-size: 0.85rem;"><strong>Bank:</strong> {{ $t->teacherProfile->bank_account }}</div>
                                @endif
                                @if($t->teacherProfile->cv_path)
                                    <div style="font-size: 0.85rem;"><a href="{{ asset('storage/' . $t->teacherProfile->cv_path) }}" target="_blank">View CV</a></div>
                                @endif
                                @if($t->teacherProfile->certificate_path)
                                    <div style="font-size: 0.85rem;"><a href="{{ asset('storage/' . $t->teacherProfile->certificate_path) }}" target="_blank">View Certificate</a></div>
                                @endif
                                @if($t->teacherProfile->citizenship_path)
                                    <div style="font-size: 0.85rem;"><a href="{{ asset('storage/' . $t->teacherProfile->citizenship_path) }}" target="_blank">View Citizenship</a></div>
                                @endif
                                @if(!$t->teacherProfile->bank_account && !$t->teacherProfile->cv_path && !$t->teacherProfile->certificate_path && !$t->teacherProfile->citizenship_path)
                                    <span style="font-size: 0.85rem; color: #777;">None</span>
                                @endif
                            @else
                                <span style="font-size: 0.85rem; color: #777;">No Profile</span>
                            @endif
                        </td>
                        <td>{{ $t->created_at->format('Y-m-d') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.teachers.approve', $t->id) }}">
                                @csrf
                                <button type="submit" class="btn-admin btn-primary-admin">Approve</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $pending->links() }}
    @else
        <p>No pending teachers.</p>
    @endif

    {{-- all teachers list --}}
    <h2 style="margin-top:2rem;font-size:1.25rem;">All Teachers</h2>
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Approved</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($all as $t)
                    <tr>
                        <td><a href="{{ route('admin.users.show', $t->id) }}" target="_blank">{{ $t->name }}</a></td>
                        <td>{{ $t->email }}</td>
                        <td><span class="admin-badge {{ $t->is_teacher_approved ? 'badge-teal' : 'badge-gray' }}">{{ $t->is_teacher_approved ? 'Approved' : 'Pending' }}</span></td>
                        <td>{{ $t->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="action-buttons">
                                @if(!$t->is_teacher_approved)
                                    <form method="POST" action="{{ route('admin.teachers.approve', $t->id) }}" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn-admin btn-primary-admin">Approve</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.teachers.reject', $t->id) }}" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn-admin btn-delete-admin">Unapprove</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px">{{ $all->links() }}</div>
@endsection
