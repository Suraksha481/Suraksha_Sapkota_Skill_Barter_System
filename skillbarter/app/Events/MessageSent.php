<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('sender');
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('request.' . $this->message->request_id);
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'request_id' => $this->message->request_id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->name ?? null,
            'body' => $this->message->body,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
