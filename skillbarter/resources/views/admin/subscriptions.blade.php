@extends('admin.layout')
@section('title', 'System Subscriptions')
@section('subtitle', 'Monitor active plans and platform revenue')

@section('content')
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    <div style="margin-bottom:1rem">Active revenue: <strong>NPR {{ number_format($revenue ?? 0, 2) }}</strong></div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Plan</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($subs as $s)
                <tr>
                    <td>{{ $s->id }}</td>
                    <td>{{ $s->user->name ?? $s->user_id }}</td>
                    <td><span class="admin-badge badge-gray">{{ ucfirst($s->plan) }}</span></td>
                    <td><strong>{{ $s->price }} {{ $s->currency }}</strong></td>
                    <td><span class="admin-badge {{ $s->status === 'active' ? 'badge-teal' : 'badge-red' }}">{{ ucfirst($s->status) }}</span></td>
                    <td>
                        @if($s->status === 'active')
                        <div class="action-buttons">
                            <form method="POST" action="{{ route('admin.subscriptions.cancel', $s->id) }}">
                                @csrf
                                <button type="submit" class="btn-admin btn-delete-admin" onclick="return confirm('Cancel subscription?')">Cancel</button>
                            </form>
                        </div>
                        @else
                        -
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem">{{ $subs->links() }}</div>
@endsection

