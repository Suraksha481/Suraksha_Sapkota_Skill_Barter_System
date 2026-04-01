@extends('app')

@section('content')
<style>
/* CSS Reset and Body Setup for Full Height */
html, body {
    height: 100%;
    margin: 0;
    background-color: #f8fafc; /* Ensure body bg is consistent */
}

/* Ensure the messenger fills enough space but keeps header visible naturally */
.messenger-container {
    display: flex;
    height: calc(100vh - 120px); 
    min-height: 600px;
    max-width: 1200px;
    margin: 20px auto;
    overflow: hidden;
    background: #fff;
    border: 1px solid var(--primary-teal-light);
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.05);
}

/* Left Sidebar */
.messenger-sidebar {
    width: 360px;
    background: #fdfdfd; /* Subtly different from active chat area */
    border-right: 1px solid var(--primary-teal-light);
    display: flex;
    flex-direction: column;
}

.sidebar-header {
    padding: 16px;
    padding-bottom: 8px;
}

.sidebar-header h1 {
    font-size: 24px;
    font-weight: 800;
    margin: 0 0 16px 0;
    color: var(--text-dark);
}

.search-container {
    position: relative;
    margin-bottom: 12px;
}

.search-input {
    width: 100%;
    background-color: #fff;
    border: 1.5px solid var(--primary-teal-light); /* Always show teal border */
    border-radius: 20px;
    padding: 10px 16px 10px 40px;
    color: var(--text-slate);
    font-size: 15px;
    outline: none;
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: var(--primary-teal);
    box-shadow: 0 0 0 4px rgba(32, 166, 138, 0.1);
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #8e8f92;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: #fff;
    border: 1px solid var(--primary-teal-light);
    border-radius: 12px;
    z-index: 100;
    max-height: 250px;
    overflow-y: auto;
    display: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.search-result-item {
    padding: 10px 16px;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.2s;
}

.search-result-item:hover {
    background: var(--bg-light-teal);
}

.search-result-item .avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    margin-right: 12px;
    background: var(--primary-teal-light);
}

/* Conversation List */
.conversation-list {
    flex: 1;
    overflow-y: auto;
    padding: 8px;
}

.conversation-list::-webkit-scrollbar {
    width: 6px;
}
.conversation-list::-webkit-scrollbar-thumb {
    background-color: var(--primary-teal-light);
    border-radius: 10px;
}

.conversation-item {
    display: flex;
    align-items: center;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.2s;
    margin-bottom: 4px;
}

.conversation-item:hover {
    background: var(--bg-light-teal);
}

.conversation-item.active {
    background: var(--bg-light-teal);
    border-left: 4px solid var(--primary-teal);
    box-shadow: inset 0 0 10px rgba(32, 166, 138, 0.05);
}

.conversation-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 12px;
    background: var(--primary-teal-light);
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}
.conversation-avatar img {
    width: 100%; height: 100%; object-fit: cover;
}

.conversation-info {
    flex: 1;
    overflow: hidden;
}

.conversation-name {
    font-weight: 700;
    font-size: 15px;
    color: var(--text-dark);
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.conversation-snippet {
    font-size: 13px;
    color: var(--text-secondary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Chat Area */
.chat-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #fff;
    position: relative;
}

.chat-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: var(--text-secondary);
    font-size: 18px;
    background: #fff; /* Match the perfection of a clean canvas */
}

.chat-header {
    height: 72px;
    border-bottom: 1px solid #f0f0f0;
    display: none;
    align-items: center;
    padding: 0 24px;
    background: #fff;
}

.chat-header-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    margin-right: 12px;
    background: var(--primary-teal-light);
    overflow: hidden;
}
.chat-header-avatar img {
    width:100%; height:100%; object-fit: cover;
}

.chat-header {
    height: 72px;
    border-bottom: 1px solid var(--primary-teal-light);
    display: none;
    align-items: center;
    padding: 0 24px;
    background: #fff;
    border-left: 1px solid var(--primary-teal-light);
}

.chat-header-info h2 {
    font-size: 17px;
    font-weight: 700;
    margin: 0;
    color: var(--text-dark);
}
.chat-header-info p {
    font-size: 12px;
    color: var(--primary-teal);
    font-weight: 600;
    margin: 0;
}

.messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: none;
    flex-direction: column;
    border-left: 1px solid var(--primary-teal-light); /* Vertical separation border */
}
.messages-container::-webkit-scrollbar {
    width: 6px;
}
.messages-container::-webkit-scrollbar-thumb {
    background-color: var(--primary-teal-light);
    border-radius: 10px;
}

.message-wrapper {
    display: flex;
    margin-bottom: 12px;
    align-items: flex-end;
}

.message-wrapper.sent {
    justify-content: flex-end;
}

.message-wrapper.received {
    justify-content: flex-start;
}

.message-bubble {
    max-width: 65%;
    padding: 10px 14px;
    border-radius: 18px;
    font-size: 15px;
    line-height: 1.4;
    word-wrap: break-word;
}

.message-wrapper.sent .message-bubble {
    background: var(--primary-teal);
    color: #fff;
    border-bottom-right-radius: 4px;
}

.message-wrapper.received .message-bubble {
    background: var(--bg-light-teal);
    color: var(--text-dark);
    border-bottom-left-radius: 4px;
    border: 1px solid var(--primary-teal-light);
}

.chat-input-area {
    padding: 20px 24px;
    border-top: 1px solid var(--primary-teal-light);
    border-left: 1px solid var(--primary-teal-light); /* Vertical separation border */
    display: none;
    align-items: center;
    background: #fff;
}

.chat-input {
    flex: 1;
    background: var(--bg-light-teal);
    border: 1.5px solid transparent;
    border-radius: 25px;
    padding: 12px 20px;
    color: var(--text-slate);
    font-size: 15px;
    outline: none;
    transition: all 0.2s;
}

.chat-input:focus {
    background: #fff;
    border-color: var(--primary-teal);
}

.chat-send-btn {
    background: transparent;
    border: none;
    color: var(--primary-teal);
    cursor: pointer;
    font-size: 28px;
    margin-left: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
}

.chat-send-btn:hover {
    color: var(--primary-teal-dark);
    transform: scale(1.1);
}
.chat-send-btn:disabled {
    color: #cbd5e1;
    cursor: not-allowed;
}

.error-banner {
    background: #dc3545;
    color: white;
    padding: 12px;
    text-align: center;
    display: none;
    font-size: 14px;
}

/* Make it responsive */
@media (max-width: 768px) {
    .messenger-sidebar {
        width: 100%;
        position: absolute;
        z-index: 10;
        height: 100%;
    }
    .chat-area {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 5;
    }
    .messenger-sidebar.hidden {
        display: none;
    }
}
</style>

<div class="messenger-container" id="messenger-app">

    <!-- Left Sidebar -->
    <div class="messenger-sidebar" id="messenger-sidebar">
        <div class="sidebar-header">
            <h1>Chats</h1>
            <div class="search-container">
                <span class="search-icon"></span>
                <input type="text" class="search-input" id="search-input" placeholder="Search Messenger...">
                <div class="search-results" id="search-results"></div>
            </div>
            <!-- Conversation Filters / Tabs can go here -->
        </div>

        <div class="conversation-list" id="conversation-list">
            @foreach($conversations as $conv)
                @php
                    $otherUser = $conv->user_one_id === $user->id ? $conv->userTwo : $conv->userOne;
                @endphp
                <div class="conversation-item" data-id="{{ $conv->id }}" data-target="{{ $otherUser->id }}" onclick="loadConversation({{ $conv->id }}, '{{ $otherUser->name }}', '{{ $otherUser->avatar }}', {{ $otherUser->id }})">
                    <div class="conversation-avatar">
                        <img src="{{ $otherUser->avatar ?? asset('images/default-avatar.png') }}" alt="{{ $otherUser->name }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&background=random'">
                    </div>
                    <div class="conversation-info">
                        <div class="conversation-name">{{ $otherUser->name }}</div>
                        <div class="conversation-snippet">Click to view messages</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Right Chat Area -->
    <div class="chat-area" id="chat-area">
        <div class="error-banner" id="chat-error-banner"></div>
        <button class="btn btn-sm btn-pill primary d-md-none m-2" id="back-to-list" style="display:none; position:absolute; top:10px; right:10px; z-index:20;">Back</button>

        <div class="chat-empty" id="chat-empty">
            Select a conversation or search for someone to start chatting
        </div>

        <div class="chat-header" id="chat-header">
            <div class="chat-header-avatar">
                <img id="chat-header-img" src="" alt="Avatar">
            </div>
            <div class="chat-header-info">
                <h2 id="chat-header-name">User Name</h2>
                <p>Teacher</p>
            </div>
        </div>

        <div class="messages-container" id="messages-container">
            <!-- Messages dynamically loaded here -->
        </div>

        <div class="chat-input-area" id="chat-input-area">
            <input type="text" class="chat-input" id="chat-input" placeholder="Type a message..." disabled>
            <button class="chat-send-btn" id="chat-send-btn" disabled>
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
<script>
    const currentUserId = {{ $user->id }};
    let currentConversationId = null;
    let targetUserId = null; 

    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    const chatEmpty = document.getElementById('chat-empty');
    const chatHeader = document.getElementById('chat-header');
    const messagesContainer = document.getElementById('messages-container');
    const chatInputArea = document.getElementById('chat-input-area');
    const chatInput = document.getElementById('chat-input');
    const chatSendBtn = document.getElementById('chat-send-btn');
    const errorBanner = document.getElementById('chat-error-banner');

    document.addEventListener('DOMContentLoaded', function() {
        const autoTargetId = @json($target_user_id ?? null);
        const targetUser = @json($targetUser ?? null);

        if (autoTargetId) {
            const existingConv = document.querySelector(`.conversation-item[data-target="${autoTargetId}"]`);
            if (existingConv) {
                existingConv.click();
            } else if (targetUser) {
                const fallbackAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(targetUser.name)}&background=random`;
                startNewChat(targetUser.id, targetUser.name, targetUser.avatar || fallbackAvatar);
            }
        }
    });

    // Search functionality
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }
        searchTimeout = setTimeout(() => {
            fetch(`/messenger/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.users.length === 0) {
                        searchResults.innerHTML = '<div class="p-2 text-center text-muted">No users found</div>';
                    } else {
                        data.users.forEach(u => {
                            const div = document.createElement('div');
                            div.className = 'search-result-item';
                            const fallbackAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(u.name)}&background=random`;
                            div.innerHTML = `
                                <img src="${u.avatar || fallbackAvatar}" class="avatar" onerror="this.src='${fallbackAvatar}'">
                                <div>${u.name} <br><small class="text-muted">${u.role}</small></div>
                            `;
                            div.onclick = () => startNewChat(u.id, u.name, u.avatar || fallbackAvatar);
                            searchResults.appendChild(div);
                        });
                    }
                    searchResults.style.display = 'block';
                });
        }, 500);
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-container')) searchResults.style.display = 'none';
    });

    function startNewChat(userId, userName, avatarUrl) {
        searchResults.style.display = 'none';
        searchInput.value = '';
        currentConversationId = null;
        targetUserId = userId;

        chatEmpty.style.display = 'none';
        chatHeader.style.display = 'flex';
        messagesContainer.style.display = 'flex';
        chatInputArea.style.display = 'flex';

        document.getElementById('chat-header-name').innerText = userName;
        document.getElementById('chat-header-img').src = avatarUrl;
        messagesContainer.innerHTML = '<div class="text-center w-100 mt-4 text-muted">Send a message to start the conversation</div>';

        chatInput.disabled = false;
        chatSendBtn.disabled = false;
        chatInput.focus();
        hideError();

        if(window.innerWidth <= 768) {
            document.getElementById('messenger-sidebar').classList.add('hidden');
            document.getElementById('back-to-list').style.display = 'block';
        }
    }

    function loadConversation(convId, userName, avatarUrl, otherId) {
        currentConversationId = convId;
        targetUserId = otherId;

        document.querySelectorAll('.conversation-item').forEach(el => el.classList.remove('active'));
        const item = document.querySelector(`.conversation-item[data-id="${convId}"]`);
        if(item) item.classList.add('active');

        chatEmpty.style.display = 'none';
        chatHeader.style.display = 'flex';
        messagesContainer.style.display = 'flex';
        chatInputArea.style.display = 'flex';

        document.getElementById('chat-header-name').innerText = userName;
        document.getElementById('chat-header-img').src = avatarUrl;
        chatInput.disabled = false;
        chatSendBtn.disabled = false;
        hideError();

        // Echo Real-time
        if (window.Echo) {
            window.Echo.leaveAllChannels();
            window.Echo.private(`conversation.${convId}`)
                .listen('MessageSent', (e) => {
                    if (e.sender_id !== currentUserId) {
                        appendMessage({ body: e.body, sender_id: e.sender_id });
                        scrollToBottom();
                    }
                });
        }

        fetch(`/messenger/${convId}`)
            .then(res => res.json())
            .then(data => {
                messagesContainer.innerHTML = '';
                data.messages.forEach(appendMessage);
                scrollToBottom();
            });

        if(window.innerWidth <= 768) {
            document.getElementById('messenger-sidebar').classList.add('hidden');
            document.getElementById('back-to-list').style.display = 'block';
        }
    }

    chatInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') sendMessage(); });
    chatSendBtn.addEventListener('click', sendMessage);

    function sendMessage() {
        const body = chatInput.value.trim();
        if (!body || (!targetUserId && !currentConversationId)) return;

        chatInput.disabled = true;
        chatSendBtn.disabled = true;

        fetch('/messenger/messages', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({
                body: body,
                target_user_id: targetUserId,
                _token: '{{ csrf_token() }}'
            })
        })
        .then(res => res.json().then(data => ({status: res.status, body: data})))
        .then(res => {
            chatInput.disabled = false;
            chatSendBtn.disabled = false;
            chatInput.focus();

            if (res.status === 429) { showError(res.body.message); return; }
            if (res.status !== 200) { showError("An error occurred"); return; }

            chatInput.value = '';
            if(!currentConversationId) { messagesContainer.innerHTML = ''; window.location.reload(); return; }

            appendMessage(res.body.message);
            scrollToBottom();
        });
    }

    function appendMessage(msg) {
        const div = document.createElement('div');
        const isSent = msg.sender_id === currentUserId;
        div.className = `message-wrapper ${isSent ? 'sent' : 'received'}`;
        if (!isSent) {
            const avatarUrl = document.getElementById('chat-header-img').src;
            div.innerHTML = `<img src="${avatarUrl}" alt="Avatar" style="width: 28px; height: 28px; border-radius: 50%; margin-right: 8px; align-self: flex-end; background-color: #4e4f50;">
                             <div class="message-bubble">${msg.body}</div>`;
        } else {
            div.innerHTML = `<div class="message-bubble">${msg.body}</div>`;
        }
        messagesContainer.appendChild(div);
    }

    function scrollToBottom() { messagesContainer.scrollTop = messagesContainer.scrollHeight; }
    function showError(msg) { errorBanner.innerHTML = msg; errorBanner.style.display = 'block'; }
    function hideError() { errorBanner.style.display = 'none'; errorBanner.innerText = ''; }

    document.getElementById('back-to-list').onclick = function() {
        document.getElementById('messenger-sidebar').classList.remove('hidden');
        this.style.display = 'none';
    }
</script>
@endsection
