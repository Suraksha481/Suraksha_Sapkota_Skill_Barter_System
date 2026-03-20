@extends('admin.layout')

@section('title', 'Disputes')
@section('subtitle', 'Review and resolve reported session issues')

@section('content')

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Filed By</th>
                    <th>Session</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Raised</th>
                    <th>Resolve</th>
                </tr>
            </thead>
            <tbody>
            @forelse($disputes as $d)
                <tr>
                    <td>#{{ $d->id }}</td>
                    <td>{{ $d->filer->name ?? '—' }}</td>
                    <td>
                        @if($d->sessionRequest)
                            <small>
                                <strong>{{ $d->sessionRequest->requester->name ?? '?' }}</strong>
                                &rarr;
                                {{ $d->sessionRequest->responder->name ?? '?' }}
                            </small>
                        @else
                            <span style="color:#aaa">Deleted session</span>
                        @endif
                    </td>
                    <td style="max-width:280px;">{{ \Illuminate\Support\Str::limit($d->reason, 100) }}</td>
                    <td>
                        @if($d->status === 'open')
                            <span class="admin-badge badge-red">Open</span>
                        @elseif($d->status === 'resolved_refunded')
                            <span class="admin-badge badge-teal">Refunded</span>
                        @else
                            <span class="admin-badge badge-gray">Dismissed</span>
                        @endif
                    </td>
                    <td>{{ $d->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($d->status === 'open')
                            <div class="action-buttons" style="flex-direction: column; gap: 6px;">
                                <form method="POST" action="{{ route('admin.disputes.resolve', $d->id) }}">
                                    @csrf
                                    <input type="hidden" name="action" value="refund">
                                    <button type="submit" class="btn-admin btn-delete-admin"
                                        onclick="return confirm('Cancel session and mark as refunded?')">
                                        Refund &amp; Cancel
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.disputes.resolve', $d->id) }}">
                                    @csrf
                                    <input type="hidden" name="action" value="dismiss">
                                    <button type="submit" class="btn-admin btn-primary-admin">
                                        Dismiss
                                    </button>
                                </form>
                            </div>
                        @else
                            <span style="color:#aaa; font-size:0.85rem;">Resolved</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding: 40px; color:#aaa;">
                        No disputes filed yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem">{{ $disputes->links() }}</div>

@endsection
