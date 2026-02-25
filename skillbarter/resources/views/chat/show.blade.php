@extends('app')

@section('content')

<div class="chat-page" style="max-width:1000px;margin:1.5rem auto;">
    <div class="chat-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;display:flex;flex-direction:column;height:70vh">
        <div class="chat-header" style="padding:12px 16px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;gap:12px;background:#fafafa">
            <div style="width:44px;height:44px;border-radius:50%;background:#111827;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600">{{ strtoupper(substr($requestModel->userSkill->user->name ?? 'U',0,1)) }}</div>
            <div>
                <div style="font-weight:600">Chat: {{ $requestModel->userSkill->skill->title ?? 'Request' }}</div>
                <div style="font-size:12px;color:#6b7280">Request #{{ $requestModel->id }} — {{ $requestModel->requester->name ?? '' }} ↔ {{ $requestModel->responder->name ?? '' }}</div>
            </div>
            <div style="margin-left:auto;color:#6b7280;font-size:13px">Status: <span class="badge {{ $requestModel->status }}" style="margin-left:6px">{{ ucfirst($requestModel->status) }}</span></div>
        </div>

        <div id="messages" style="flex:1;overflow:auto;padding:18px;background:linear-gradient(180deg,#ffffff, #f9fafb)">
            @foreach($messages as $m)
                @php $isMe = auth()->id() === $m->sender_id; @endphp
                <div style="display:flex;flex-direction:column;align-items:{{ $isMe ? 'flex-end' : 'flex-start' }};margin-bottom:12px">
                    <div style="max-width:75%;padding:10px 14px;border-radius:12px;line-height:1.35;background:{{ $isMe ? '#0ea5a3' : '#f3f4f6' }};color:{{ $isMe ? '#fff' : '#111827' }}">
                        <div style="font-size:13px">{{ $m->body }}</div>
                    </div>
                    <div style="font-size:11px;color:#6b7280;margin-top:6px">{{ $m->sender->name ?? 'User' }} · {{ $m->created_at->format('H:i') }}</div>
                </div>
            @endforeach
        </div>

        <form id="sendForm" style="display:flex;padding:12px;border-top:1px solid #f3f4f6;gap:8px;align-items:center">
            <textarea id="body" name="body" rows="1" placeholder="Write a message..." style="flex:1;padding:10px;border:1px solid #e5e7eb;border-radius:8px;resize:none"></textarea>
            <button id="sendBtn" class="btn primary" type="submit" style="padding:8px 12px">Send</button>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* simple responsive tweaks */
    @media (max-width:640px){ .chat-page{padding:0 12px} .chat-card{height:70vh} }
</style>
@endpush

@push('scripts')
<script>
(() => {
    const requestId = {{ $requestModel->id }};
    const messagesEl = document.getElementById('messages');
    const form = document.getElementById('sendForm');
    const bodyInput = document.getElementById('body');

    function scrollToEnd(){ messagesEl.scrollTop = messagesEl.scrollHeight; }

    function makeBubble(msg){
        const isMe = msg.sender_id === {{ auth()->id() ?? 'null' }};
        const wrapper = document.createElement('div');
        wrapper.style.display = 'flex';
        wrapper.style.flexDirection = 'column';
        wrapper.style.alignItems = isMe ? 'flex-end' : 'flex-start';
        wrapper.style.marginBottom = '12px';

        const bubble = document.createElement('div');
        bubble.style.maxWidth = '75%';
        bubble.style.padding = '10px 14px';
        bubble.style.borderRadius = '12px';
        bubble.style.lineHeight = '1.35';
        bubble.style.background = isMe ? '#0ea5a3' : '#f3f4f6';
        bubble.style.color = isMe ? '#fff' : '#111827';
        bubble.textContent = msg.body;

        const meta = document.createElement('div');
        meta.style.fontSize = '11px';
        meta.style.color = '#6b7280';
        meta.style.marginTop = '6px';
        meta.textContent = (msg.sender?.name || 'User') + ' · ' + (msg.time || '');

        wrapper.appendChild(bubble);
        wrapper.appendChild(meta);
        messagesEl.appendChild(wrapper);
        scrollToEnd();
    }

    // Echo subscription
    if (window.Echo) {
        window.Echo.private('request.' + requestId)
            .listen('MessageSent', (e) => {
                const m = e.message;
                makeBubble({ body: m.body, sender: m.sender ?? { name: e.sender_name }, sender_id: m.sender_id, time: 'just now' });
            });
    }

    form.addEventListener('submit', function(ev){
        ev.preventDefault();
        console.log('chat: submit handler fired');
        const body = bodyInput.value.trim();
        console.log('chat: body=', body);
        if (!body) return;

        fetch(`{{ route('chat.send', $requestModel) }}`, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body })
        }).then(async res => {
            console.log('chat.send response', res.status);
            if (res.status === 429) {
                const json = await res.json();
                alert(json.message || 'Message limit reached');
                return;
            }
            if (res.status === 419) {
                // CSRF/session expired
                alert('Session expired or CSRF mismatch. Please refresh and try again.');
                return;
            }
            if (!res.ok) {
                const txt = await res.text();
                console.error('Send failed:', res.status, txt);
                alert('Send failed: ' + (txt || res.status));
                return;
            }
            const json = await res.json();
            console.log('chat.send json', json);
            const msg = json.message;
            makeBubble({ body: msg.body, sender: msg.sender || { name: '{{ auth()->user()->name ?? "You" }}' }, sender_id: msg.sender_id, time: 'just now' });
            bodyInput.value = '';
            console.log('chat: message appended and input cleared');
        }).catch(err => { console.error('Network error', err); alert('Network error'); });
    });

    // initial scroll
    scrollToEnd();
})();
</script>
@endpush

@endsection
