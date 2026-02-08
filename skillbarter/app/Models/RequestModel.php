<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    use HasFactory;
    protected $table = 'requests';
    protected $fillable = ['requester_id','responder_id','user_skill_id','message','status','scheduled_at'];

    public function requester() { return $this->belongsTo(User::class,'requester_id'); }
    public function responder() { return $this->belongsTo(User::class,'responder_id'); }
    public function userSkill() { return $this->belongsTo(UserSkill::class,'user_skill_id'); }
}
