@extends('app')

@section('content')
<section class="container">
    <h1>Notifications</h1>

    <div style="margin-bottom:2rem;">
        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            <button class="btn ghost" style="background: #000; color: #fff; border: 1px solid #000; font-weight: 700;">Mark all as read</button>
        </form>
    </div>

    <ul style="list-style:none; padding:0;">
        @forelse($notifications as $n)
            <li style="padding:1.5rem; border-bottom:1px solid #eee; background:{{ $n->read_at ? '#fff' : '#fcfcfc' }}; transition: background 0.3s ease;">
                <div style="display:flex; justify-content:space-between; align-items:center; gap: 1rem;">
                    <div style="flex-grow: 1;">
                        @if(isset($n->data['url']))
                            <a href="{{ $n->data['url'] }}" style="text-decoration:none;color:inherit; display: block;">
                                <p style="margin:0; font-weight: {{ $n->read_at ? '400' : '700' }}; color: #000; font-size: 1.05rem;">{{ $n->data['message'] ?? ucfirst(str_replace('_',' ', $n->data['type'] ?? 'notification')) }}</p>
                            </a>
                        @else
                            <p style="margin:0; font-weight: {{ $n->read_at ? '400' : '700' }}; color: #000; font-size: 1.05rem;">{{ $n->data['message'] ?? ucfirst(str_replace('_',' ', $n->data['type'] ?? 'notification')) }}</p>
                        @endif
                        <small style="color:#888; display: block; margin-top: 0.25rem;">{{ $n->created_at->diffForHumans() }}</small>
                    </div>
                    <div>
                        @if(! $n->read_at)
                            <form method="POST" action="{{ route('notifications.read', $n->id) }}">
                                @csrf
                                <button type="submit" class="btn tiny bw" style="padding: 6px 12px; font-weight: 700; cursor: pointer;">Mark read</button>
                            </form>
                        @endif
                    </div>
                </div>
            </li>
        @empty
            <li style="padding: 3rem; text-align: center; color: #666; border: 1px dashed #eee; border-radius: 12px;">No notifications.</li>
        @endforelse
    </ul>

    <div style="margin-top:1rem;">
        {{ $notifications->links() }}
    </div>
</section>
@endsection
