<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\SessionModel;

class SessionScheduled extends Notification
{
    use Queueable;

    protected $session;

    public function __construct(SessionModel $session)
    {
        $this->session = $session;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        $teacherName = $this->session->teacher->name;
        $skill = $this->session->skill->title ?? 'a skill';

        return [
            'type' => 'session_scheduled',
            'session_id' => $this->session->id,
            'teacher_id' => $this->session->organiser_id,
            'message' => "Your session for {$skill} has been scheduled by {$teacherName}.",
            'url' => route('sessions.index'),
        ];
    }
}
