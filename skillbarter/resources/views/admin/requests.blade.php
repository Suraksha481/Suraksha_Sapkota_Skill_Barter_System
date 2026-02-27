@extends('admin.layout')

@section('content')
<section class="container">
    <h1>Session Requests</h1>
    @if(session('status'))<div class="alert">{{ session('status') }}</div>@endif

    <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden">
        <thead style="background:#f8fafc"><tr><th style="padding:8px">ID</th><th style="padding:8px">Requester</th><th style="padding:8px">Responder</th><th style="padding:8px">Status</th><th style="padding:8px">Actions</th></tr></thead>
        <tbody>
        @foreach($requests as $r)
            <tr>
                <td style="padding:8px">{{ $r->id }}</td>
                <td style="padding:8px">{{ $r->requester->name ?? $r->requester_id }}</td>
                <td style="padding:8px">{{ $r->responder->name ?? $r->responder_id }}</td>
                <td style="padding:8px">{{ $r->status }}</td>
                <td style="padding:8px">
                    <form method="POST" action="{{ route('admin.requests.update-status', $r->id) }}">
                        @csrf
                        <select name="status" onchange="this.form.submit()">
                            <option value="pending" {{ $r->status==='pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ $r->status==='accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="declined" {{ $r->status==='declined' ? 'selected' : '' }}>Declined</option>
                            <option value="completed" {{ $r->status==='completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $r->status==='cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $requests->links() }}</div>
</section>

@endsection
