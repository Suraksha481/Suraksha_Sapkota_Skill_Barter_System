<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_request_id',
        'user_id',
        'reason',
        'status',
        'admin_notes',
    ];

    /**
     * The session request this dispute belongs to.
     */
    public function sessionRequest()
    {
        return $this->belongsTo(RequestModel::class, 'session_request_id');
    }

    /**
     * The user who filed this dispute.
     */
    public function filer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
