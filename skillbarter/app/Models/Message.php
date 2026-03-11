<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['request_id', 'conversation_id', 'sender_id', 'body'];

    public function request() { return $this->belongsTo(RequestModel::class, 'request_id'); }
    public function conversation() { return $this->belongsTo(Conversation::class, 'conversation_id'); }
    public function sender() { return $this->belongsTo(User::class, 'sender_id'); }
}
