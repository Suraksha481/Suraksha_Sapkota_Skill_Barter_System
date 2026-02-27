<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\RequestModel;

class RequestDeclined extends Notification
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
        $teacher = $this->requestModel->responder->name;
        $skill = $this->requestModel->userSkill->skill->title ?? '';

        return [
            'type' => 'request_declined',
            'request_id' => $this->requestModel->id,
            'by_user_id' => $this->requestModel->responder_id,
            'message' => "{$teacher} declined your request for {$skill}.",
            'url' => route('requests.show', $this->requestModel->id),
        ];
    }
}
