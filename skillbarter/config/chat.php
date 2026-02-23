<?php

return [
    // Number of free messages a non-premium user can send per day across all chats
    'free_messages_per_day' => env('CHAT_FREE_MESSAGES_PER_DAY', 10),

    // Text shown when limit is reached
    'limit_reached_message' => env('CHAT_LIMIT_REACHED_MESSAGE', 'You have reached the free daily chat limit. Upgrade to premium for unlimited chat.'),
];
