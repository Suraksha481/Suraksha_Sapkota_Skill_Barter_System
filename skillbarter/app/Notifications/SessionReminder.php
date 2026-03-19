<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SessionReminder extends Notification
{
    protected $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Session Starting Soon!')
                    ->line('Your session for "' . $this->session->skill->title . '" is starting in 30 minutes.')
                    ->action('Go to Classroom', route('session.classroom', $this->session->id))
                    ->line('Don\'t be late!');
    }

    public function toArray($notifiable)
    {
        return [
            'session_id' => $this->session->id,
            'message' => 'REMINDER: Your session "' . $this->session->skill->name . '" starts in 30 minutes!',
            'type' => 'session_reminder'
        ];
    }
}
