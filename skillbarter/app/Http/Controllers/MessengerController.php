<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use App\Events\MessageSent;

class MessengerController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $conversations = Conversation::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->with(['userOne', 'userTwo'])
            ->latest('updated_at')
            ->get();

        $target_user_id = $request->get('user');
        $targetUser = null;
        if ($target_user_id) {
            $targetUser = User::find($target_user_id);
        }

        return view('messenger.index', compact('conversations', 'user', 'target_user_id', 'targetUser'));
    }

    public function show(Conversation $conversation)
    {
        $user = auth()->user();
        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            abort(403);
        }

        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get();
        return response()->json(['messages' => $messages]);
    }

    public function search(Request $request)
    {
        $q = $request->get('q');
        $user = auth()->user();

        // Find users with an accepted/completed RequestModel involvement
        $allowedUserIds = \App\Models\RequestModel::whereIn('status', ['accepted', 'completed'])
            ->where(function ($query) use ($user) {
            $query->where('requester_id', $user->id)
                ->orWhere('responder_id', $user->id);
        })
            ->get()
            ->flatMap(function ($req) use ($user) {
            return [$req->requester_id, $req->responder_id];
        })
            ->reject(function ($id) use ($user) {
            return $id == $user->id; // Remove the current user id
        })
            ->unique()
            ->values()
            ->toArray();

        // If they are admin, they can search anyone? The prompt specifically mentioned students/teachers. Let's strictly enforce unless admin.
        if ($user->isAdmin()) {
            $users = User::where('name', 'like', "%{$q}%")
                ->where('id', '!=', $user->id)
                ->take(10)
                ->get(['id', 'name', 'avatar', 'role']);
        }
        else {
            $users = User::whereIn('id', $allowedUserIds)
                ->where('name', 'like', "%{$q}%")
                ->take(10)
                ->get(['id', 'name', 'avatar', 'role']);
        }

        return response()->json(['users' => $users]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'target_user_id' => 'required|exists:users,id',
            'body' => 'required|string|max:2000'
        ]);

        $targetId = $request->target_user_id;

        // Check if conversation already exists
        $conversation = Conversation::where(function ($q) use ($user, $targetId) {
            $q->where('user_one_id', $user->id)->where('user_two_id', $targetId);
        })->orWhere(function ($q) use ($user, $targetId) {
            $q->where('user_one_id', $targetId)->where('user_two_id', $user->id);
        })->first();

        // If new or existing conversation, check rate limit for messages
        if (!$user->isPremium()) {
            $recentMessagesCount = Message::where('sender_id', $user->id)
                ->where('created_at', '>=', now()->subDays(7))
                ->count();

            if ($recentMessagesCount >= 5) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have reached your limit of 5 messages per week. <a href="' . route('premium.index', ['ref' => $targetId]) . '" style="color: #fff; text-decoration: underline; font-weight: bold;">Upgrade to Premium for more chats!</a>',
                ], 429);
            }
        } else {
            $monthlyMessagesCount = Message::where('sender_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
                
            if ($monthlyMessagesCount >= 100) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have reached your Premium limit of 100 messages per month.',
                ], 429);
            }
        }

        // If new conversation create it
        if (!$conversation) {
            // Create conversation
            $conversation = Conversation::create([
                'user_one_id' => $user->id,
                'user_two_id' => $targetId,
            ]);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $request->body,
        ]);

        $conversation->touch(); // Update updated_at for sorting

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'status' => 'ok',
            'message' => $message->load('sender'),
            'conversation' => $conversation->load(['userOne', 'userTwo']),
        ]);
    }
}
