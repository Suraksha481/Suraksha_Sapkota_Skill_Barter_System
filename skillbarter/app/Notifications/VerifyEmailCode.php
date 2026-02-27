<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailCode extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $code)
    {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // some notifiables may be simple route instances without a name property
        $name = method_exists($notifiable, 'routeNotificationFor')
            ? '' : null; // we don't rely on this method here

        if (isset($notifiable->name)) {
            $name = $notifiable->name;
        }

        $greeting = 'Hello' . ($name ? ' ' . $name : '');

        return (new MailMessage)
            ->subject('Email Verification Code - SkillXchange')
            ->greeting($greeting . '!')
            ->line('Welcome to SkillXchange! Your email verification code is:')
            ->line('')
            ->line('**' . $this->code . '**')
            ->line('')
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not request this code, please ignore this email.')
            ->salutation('Best regards, SkillXchange Team');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'code' => $this->code,
        ];
    }
}
