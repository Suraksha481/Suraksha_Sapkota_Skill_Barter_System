<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\RequestModel;

class RequestReceived extends Notification
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
        $skill = $this->requestModel->userSkill->skill->title ?? 'a skill';
        $from = $this->requestModel->requester->name;

        return [
            'type' => 'request_received',
            'request_id' => $this->requestModel->id,
            'from_user_id' => $this->requestModel->requester_id,
            'message' => "New request from {$from} for {$skill}.",
            'url' => route('requests.show', $this->requestModel->id),
        ];
    }
}
