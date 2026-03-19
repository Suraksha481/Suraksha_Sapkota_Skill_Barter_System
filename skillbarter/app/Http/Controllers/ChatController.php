<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\RequestModel;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Show chat for a request (only participants)
    public function show(RequestModel $requestModel)
    {
        $user = auth()->user();

        if ($user->id !== $requestModel->requester_id && $user->id !== $requestModel->responder_id) {
            abort(403);
        }

        $messages = Message::where('request_id', $requestModel->id)->with('sender')->orderBy('created_at')->get();

        return view('chat.show', compact('requestModel', 'messages'));
    }

    // Store and broadcast message
    public function send(Request $request, RequestModel $requestModel)
    {
        $user = $request->user();

        if ($user->id !== $requestModel->requester_id && $user->id !== $requestModel->responder_id) {
            abort(403);
        }

        $data = $request->validate(['body' => 'required|string|max:2000']);

        // Enforce limits
        if (! $user->isPremium()) {
            $limit = (int) config('chat.free_messages_per_day', 50);
            $sentToday = Message::where('sender_id', $user->id)
                ->whereDate('created_at', now()->toDateString())
                ->count();

            if ($sentToday >= $limit) {
                $targetId = $requestModel->responder_id === $user->id ? $requestModel->requester_id : $requestModel->responder_id;
                return response()->json([
                    'status' => 'error',
                    'message' => config('chat.limit_reached_message', 'You have reached your daily message limit. <a href="' . route('premium.index', ['ref' => $targetId]) . '" style="color: blue; text-decoration: underline;">Upgrade to Premium</a>'),
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

        $message = Message::create([
            'request_id' => $requestModel->id,
            'sender_id' => $user->id,
            'body' => $data['body'],
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'ok', 'message' => $message->load('sender')]);
    }
}
