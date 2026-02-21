@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Chat: {{ $requestModel->userSkill->skill->title ?? 'Session' }}</h1>
        <p>Between <strong>{{ $requestModel->requester->name }}</strong> and <strong>{{ $requestModel->responder->name }}</strong></p>
    </div>

    <div class="chat-container" style="max-width:800px; margin:0 auto;">
        <div id="messages" style="border:1px solid #ddd; padding:1rem; height:400px; overflow:auto; background:white;">
            @foreach($messages as $m)
                <div style="margin-bottom:0.5rem;">
                    <strong>{{ $m->sender->name }}</strong>
                    <span style="color:#666; font-size:0.9rem;">{{ $m->created_at->diffForHumans() }}</span>
                    <div style="margin-top:0.25rem;">{{ $m->body }}</div>
                </div>
            @endforeach
        </div>

        <form id="chatForm" style="display:flex; gap:0.5rem; margin-top:1rem;">
            @csrf
            <input type="text" name="body" id="body" placeholder="Write a message..." style="flex:1; padding:0.5rem; border:1px solid #ddd; border-radius:6px;">
            <button class="btn primary" type="submit">Send</button>
        </form>
    </div>

</section>

@section('scripts')
<script>
    const requestId = {{ $requestModel->id }};
    const userId = {{ auth()->id() }};

    function appendMessage(data) {
        const container = document.getElementById('messages');
        const el = document.createElement('div');
        el.style.marginBottom = '0.5rem';
        el.innerHTML = `<strong>${data.sender_name}</strong> <span style="color:#666; font-size:0.9rem;">${data.created_at}</span><div style="margin-top:0.25rem;">${data.body}</div>`;
        container.appendChild(el);
        container.scrollTop = container.scrollHeight;
    }

    document.getElementById('chatForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const body = document.getElementById('body');
        if (!body.value.trim()) return;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const res = await fetch(`{{ route('chat.send', $requestModel) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body: body.value })
        });

        if (res.ok) {
            const json = await res.json();
            appendMessage({ sender_name: json.message.sender.name, body: json.message.body, created_at: json.message.created_at });
            body.value = '';
        }
    });

    if (window.Echo) {
        window.Echo.private('request.' + requestId)
            .listen('MessageSent', (e) => {
                appendMessage(e);
            });
    }
</script>
@endsection
