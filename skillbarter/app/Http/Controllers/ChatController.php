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

        $message = Message::create([
            'request_id' => $requestModel->id,
            'sender_id' => $user->id,
            'body' => $data['body'],
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'ok', 'message' => $message->load('sender')]);
    }
}
