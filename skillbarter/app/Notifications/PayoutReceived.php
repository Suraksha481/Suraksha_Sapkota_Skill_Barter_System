<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Transaction;

class PayoutReceived extends Notification
{
    use Queueable;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'payout_received',
            'transaction_id' => $this->transaction->id,
            'amount' => $this->transaction->teacher_share,
            'message' => "You've received a payout of NPR {$this->transaction->teacher_share} for a {$this->transaction->type}.",
            'url' => '#', // Link to a earnings page if available
        ];
    }
}
