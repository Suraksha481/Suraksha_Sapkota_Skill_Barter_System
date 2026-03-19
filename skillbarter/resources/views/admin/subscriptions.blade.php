@extends('admin.layout')
@section('title', 'System Subscriptions')
@section('subtitle', 'Monitor active plans and platform revenue')

@section('content')
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    <div style="margin-bottom:1rem">Active revenue: <strong>NPR {{ number_format($revenue ?? 0, 2) }}</strong></div>

    <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden">
        <thead style="background:#f8fafc"><tr><th style="padding:8px">ID</th><th style="padding:8px">User</th><th style="padding:8px">Plan</th><th style="padding:8px">Price</th><th style="padding:8px">Status</th><th style="padding:8px">Actions</th></tr></thead>
        <tbody>
        @foreach($subs as $s)
            <tr>
                <td style="padding:8px">{{ $s->id }}</td>
                <td style="padding:8px">{{ $s->user->name ?? $s->user_id }}</td>
                <td style="padding:8px">{{ $s->plan }}</td>
                <td style="padding:8px">{{ $s->price }} {{ $s->currency }}</td>
                <td style="padding:8px">{{ $s->status }}</td>
                <td style="padding:8px">
                    @if($s->status === 'active')
                    <form method="POST" action="{{ route('admin.subscriptions.cancel', $s->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Cancel subscription?')">Cancel</button>
                    </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $subs->links() }}</div>
@endsection

@endsection
