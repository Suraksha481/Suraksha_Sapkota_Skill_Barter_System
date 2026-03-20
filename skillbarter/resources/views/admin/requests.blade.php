@extends('admin.layout')

@section('title', 'Session Requests')
@section('subtitle', 'Monitor and manage session interactions between users')

@section('content')
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Requester</th>
                    <th>Responder</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($requests as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->requester->name ?? $r->requester_id }}</td>
                    <td>{{ $r->responder->name ?? $r->responder_id }}</td>
                    <td>
                        <span class="admin-badge badge-teal">{{ ucfirst($r->status) }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem">{{ $requests->links() }}</div>
@endsection
