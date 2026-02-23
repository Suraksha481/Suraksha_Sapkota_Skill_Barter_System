<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\RequestModel;

class RequestAccepted extends Notification
{
    use Queueable;

    protected $requestModel;

    public function __construct(RequestModel $requestModel)
    {
        $this->requestModel = $requestModel;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'request_accepted',
            'request_id' => $this->requestModel->id,
            'by_user_id' => $this->requestModel->responder_id,
            'message' => 'Your request was accepted',
        ];
    }
}
