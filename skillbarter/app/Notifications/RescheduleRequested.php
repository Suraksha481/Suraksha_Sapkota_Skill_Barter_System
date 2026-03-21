<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\SessionModel;
use App\Models\User;

class RescheduleRequested extends Notification
{
    use Queueable;

    public $session;
    public $user;
    public $remarks;
    public $type; // 'request' or 'update'

    /**
     * Create a new notification instance.
     *
     * @param SessionModel $session
     * @param User|null $user The user initiating the action (student for request, teacher for update)
     * @param string|null $remarks
     * @param string $type
     */
    public function __construct(SessionModel $session, User $user = null, $remarks = null, $type = 'request')
    {
        $this->session = $session;
        $this->user = $user;
        $this->remarks = $remarks;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->type === 'update') {
            return [
                'type' => 'schedule_updated',
                'session_id' => $this->session->id,
                'message' => 'The teacher updated the schedule for your session: ' . ($this->session->skill->title ?? 'a skill') . '.',
                'url' => route('session.classroom', $this->session->id)
            ];
        }

        return [
            'type' => 'reschedule_request',
            'session_id' => $this->session->id,
            'student_id' => $this->user ? $this->user->id : null,
            'student_name' => $this->user ? $this->user->name : 'Student',
            'remarks' => $this->remarks,
            'message' => ($this->user ? $this->user->name : 'Student') . ' requested to reschedule the session for ' . ($this->session->skill->title ?? 'a skill') . '.',
            'url' => route('session.classroom', $this->session->id)
        ];
    }
}



