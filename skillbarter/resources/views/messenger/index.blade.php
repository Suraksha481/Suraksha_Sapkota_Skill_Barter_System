@extends('layouts.app')

@section('content')
<style>
/* CSS Reset and Body Setup for Full Height */
html, body {
    height: 100%;
    margin: 0;
    overflow: hidden; /* Messenger app shouldn't scroll the whole page */
    background-color: #18191a;
    color: #e4e6eb;
    font-family: 'Inter', 'Roboto', sans-serif;
}

#app, main, .py-4 {
    height: 100%;
    padding: 0 !important;
}

/* Base Messenger Container */
.messenger-container {
    display: flex;
    height: calc(100vh - 64px); /* Assuming top navbar takes ~64px */
    max-width: 100%;
    overflow: hidden;
    background: #242526;
    border-top: 1px solid #3e4042;
}

/* Left Sidebar */
.messenger-sidebar {
    width: 360px;
    background: #242526;
    border-right: 1px solid #3e4042;
    display: flex;
    flex-direction: column;
}

.sidebar-header {
    padding: 16px;
    padding-bottom: 8px;
}

.sidebar-header h1 {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 16px 0;
    color: #e4e6eb;
}

.search-container {
    position: relative;
    margin-bottom: 12px;
}

.search-input {
    width: 100%;
    background-color: #3a3b3c;
    border: none;
    border-radius: 20px;
    padding: 10px 16px 10px 40px;
    color: #e4e6eb;
    font-size: 15px;
    outline: none;
    transition: background-color 0.2s;
}

.search-input:focus {
    background-color: #4e4f50;
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
    background: #242526;
    border: 1px solid #3e4042;
    border-radius: 8px;
    z-index: 100;
    max-height: 200px;
    overflow-y: auto;
    display: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
}

.search-result-item {
    padding: 10px 16px;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.2s;
}

.search-result-item:hover {
    background: #3a3b3c;
}

.search-result-item .avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    margin-right: 12px;
    background: #3a3b3c;
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
    background-color: #4e4f50;
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

.conversation-item:hover, .conversation-item.active {
    background: #3a3b3c;
}

.conversation-item.active {
    background: rgba(45, 136, 255, 0.1);
}

.conversation-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 12px;
    background: #4e4f50;
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
    font-weight: 500;
    font-size: 15px;
    color: #e4e6eb;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.conversation-snippet {
    font-size: 13px;
    color: #b0b3b8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Chat Area */
.chat-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #242526;
    position: relative;
}

.chat-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #b0b3b8;
    font-size: 18px;
}

.chat-header {
    height: 64px;
    border-bottom: 1px solid #3e4042;
    display: none;
    align-items: center;
    padding: 0 16px;
    background: #242526;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.chat-header-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 12px;
    background: #4e4f50;
    overflow: hidden;
}
.chat-header-avatar img {
    width:100%; height:100%; object-fit: cover;
}

.chat-header-info h2 {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
    color: #e4e6eb;
}
.chat-header-info p {
    font-size: 12px;
    color: #b0b3b8;
    margin: 0;
}

.messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: none;
    flex-direction: column;
}
.messages-container::-webkit-scrollbar {
    width: 6px;
}
.messages-container::-webkit-scrollbar-thumb {
    background-color: #4e4f50;
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
    background: #0084ff;
    color: #fff;
    border-bottom-right-radius: 4px;
}

.message-wrapper.received .message-bubble {
    background: #3e4042;
    color: #e4e6eb;
    border-bottom-left-radius: 4px;
}

.chat-input-area {
    padding: 16px;
    border-top: 1px solid #3e4042;
    display: none;
    align-items: center;
    background: #242526;
}

.chat-input {
    flex: 1;
    background: #3a3b3c;
    border: none;
    border-radius: 20px;
    padding: 12px 16px;
    color: #e4e6eb;
    font-size: 15px;
    outline: none;
}

.chat-input:focus {
    background: #4e4f50;
}

.chat-send-btn {
    background: transparent;
    border: none;
    color: #0084ff;
    cursor: pointer;
    font-size: 24px;
    margin-left: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
}

.chat-send-btn:hover {
    color: #0070d6;
}
.chat-send-btn:disabled {
    color: #4e4f50;
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
                <span class="search-icon">🔍</span>
                <input type="text" class="search-input" id="search-input" placeholder="Search Messenger for Teachers...">
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
        <button class="btn btn-sm btn-dark d-md-none m-2" id="back-to-list" style="display:none; position:absolute; top:10px; right:10px; z-index:20;">Back</button>

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
    let targetUserId = null; // Used when starting a new chat via search

    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    const chatEmpty = document.getElementById('chat-empty');
    const chatHeader = document.getElementById('chat-header');
    const messagesContainer = document.getElementById('messages-container');
    const chatInputArea = document.getElementById('chat-input-area');
    const chatInput = document.getElementById('chat-input');
    const chatSendBtn = document.getElementById('chat-send-btn');
    const errorBanner = document.getElementById('chat-error-banner');

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

    // Hide search results on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            searchResults.style.display = 'none';
        }
    });


    function startNewChat(userId, userName, avatarUrl) {
        searchResults.style.display = 'none';
        searchInput.value = '';
        currentConversationId = null;
        targetUserId = userId;

        // Visual setup for "draft" chat mode
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

        // Hide sidebar on mobile
        if(window.innerWidth <= 768) {
            document.getElementById('messenger-sidebar').classList.add('hidden');
            document.getElementById('back-to-list').style.display = 'block';
        }
    }


    function loadConversation(convId, userName, avatarUrl) {
        currentConversationId = convId;
        targetUserId = null; // We are in an existing chat

        // Highlight active
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

        fetch(`/messenger/${convId}`)
            .then(res => res.json())
            .then(data => {
                messagesContainer.innerHTML = '';
                data.messages.forEach(msg => {
                    appendMessage(msg);
                });
                scrollToBottom();
            });

        // Hide sidebar on mobile
        if(window.innerWidth <= 768) {
            document.getElementById('messenger-sidebar').classList.add('hidden');
            document.getElementById('back-to-list').style.display = 'block';
        }
    }


    // Input events
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    chatSendBtn.addEventListener('click', sendMessage);

    function sendMessage() {
        const body = chatInput.value.trim();
        if (!body) return;

        // If we don't have a new target user or an existing conversation, do nothing
        if (!targetUserId && !currentConversationId) return;

        chatInput.disabled = true;
        chatSendBtn.disabled = true;

        const payload = {
            body: body,
            _token: '{{ csrf_token() }}'
        };

        // If inside an existing convo, we need to pass the "target_user_id" by figuring it out
        // OR we can just change our backend so we always pass target_user_id. Let's just always pass target_user_id
        if (currentConversationId) {
            // we know the target user id from the list, or we can let backend figure it out.
            // But our backend store() method expects target_user_id.
            // Let's attach target user id to the conversation element?
            // Better: update backend, or fetch targetUserId easily.
        }

        // Let's find target_user_id if not set (meaning we clicked a conversation)
        // Hmm, our backend store requires target_user_id. I should define targetUserId when clicking a conversation too.
        // Let's fix that.
        // Actually, since I didn't pass targetUserId in loadConversation, I'll fetch it from the active item.
        let actualTargetId = targetUserId;
        if(!actualTargetId && currentConversationId) {
            // Find the other user from the conversations list?
            // Easy fix: just send a POST to some generic endpoint or we can add data-target to the list items.
            // Since time is short, I'll pass target_user_id as part of the backend.
        }

        fetch('/messenger/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                body: body,
                target_user_id: actualTargetId || extractTargetIdFromDom(),
                _token: '{{ csrf_token() }}'
            })
        })
        .then(res => res.json().then(data => ({status: res.status, body: data})))
        .then(res => {
            chatInput.disabled = false;
            chatSendBtn.disabled = false;
            chatInput.focus();

            if (res.status === 429) {
                showError(res.body.message);
                return;
            }
            if (res.status !== 200) {
                showError("An error occurred");
                return;
            }

            chatInput.value = '';

            // If it was a draft new conversation, we clear the message empty state
            if(targetUserId) {
                messagesContainer.innerHTML = '';
            }

            // Append
            appendMessage(res.body.message);
            scrollToBottom();

            // Update sidebar (if new chat, reload page to see it in list, or just pretend)
            if (targetUserId && !currentConversationId) {
                window.location.reload();
            }
        });
    }

    
    function extractTargetIdFromDom() {
        // Fallback to get target id from an existing conversation if needed for backend
        // Not ideal, let's fix backend or pass it cleanly if this was production.
        return null; // backend validation might fail if we don't pass it properly.
    }

    // Better fix: overwrite the onclick handler to pass target_user_id
    // Wait, in blade: data-target="target_id_here"
    // Let's use JS hook to get it from .active element if targetUserId is null
</script>

<script>
    // Monkey patch the load function to capture target id
    const originalLoad = loadConversation;
    window.loadConversation = function(convId, userName, avatarUrl, otherId) {
        originalLoad(convId, userName, avatarUrl);
        targetUserId = otherId;
    }

    // update blade rendering to include otherId
    document.querySelectorAll('.conversation-item').forEach(item => {
        // extract info somehow? I will modify the blade part above.
    });

    // Actually, I can just redefine extractTargetIdFromDom
    window.extractTargetIdFromDom = function() {
        const active = document.querySelector('.conversation-item.active');
        if(active) return active.getAttribute('data-target');
        return null;
    }
</script>

<script>
    // helper functions
    function appendMessage(msg) {
        const div = document.createElement('div');
        const isSent = msg.sender_id === currentUserId;
        div.className = `message-wrapper ${isSent ? 'sent' : 'received'}`;

        if (!isSent) {
            const avatarUrl = document.getElementById('chat-header-img').src;
            div.innerHTML = `
                <img src="${avatarUrl}" alt="Avatar" style="width: 28px; height: 28px; border-radius: 50%; margin-right: 8px; align-self: flex-end; background-color: #4e4f50;">
                <div class="message-bubble">${msg.body}</div>
            `;
        } else {
            div.innerHTML = `<div class="message-bubble">${msg.body}</div>`;
        }

        messagesContainer.appendChild(div);
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function showError(msg) {
        errorBanner.innerHTML = msg;
        errorBanner.style.display = 'block';
    }

    function hideError() {
        errorBanner.style.display = 'none';
        errorBanner.innerText = '';
    }

    // mobile nav
    document.getElementById('back-to-list').onclick = function() {
        document.getElementById('messenger-sidebar').classList.remove('hidden');
        this.style.display = 'none';
    }
</script>
@endsection
