@extends('layouts.app')

@section('content')
<section class="container">
    <h1>Notifications</h1>

    <div style="margin-bottom:1rem;">
        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            <button class="btn ghost">Mark all as read</button>
        </form>
    </div>

    <ul style="list-style:none; padding:0;">
        @forelse($notifications as $n)
            <li style="padding:12px; border-bottom:1px solid #eee; background:{{ $n->read_at ? '#fff' : '#f8f9fa' }};">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <p style="margin:0;">{{ $n->data['message'] ?? ucfirst(str_replace('_',' ', $n->data['type'] ?? 'notification')) }}</p>
                        <small style="color:#666;">{{ $n->created_at->diffForHumans() }}</small>
                    </div>
                    <div>
                        @if(! $n->read_at)
                            <form method="POST" action="{{ route('notifications.read', $n->id) }}">
                                @csrf
                                <button class="btn tiny">Mark read</button>
                            </form>
                        @endif
                    </div>
                </div>
            </li>
        @empty
            <li class="empty">No notifications.</li>
        @endforelse
    </ul>

    <div style="margin-top:1rem;">
        {{ $notifications->links() }}
    </div>
</section>
@endsection
