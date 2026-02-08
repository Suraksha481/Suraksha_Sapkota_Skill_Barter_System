<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory;
    protected $table = 'matches';
    protected $fillable = ['seeker_id','provider_id','user_skill_id','status','matched_at'];

    public function seeker() { return $this->belongsTo(User::class,'seeker_id'); }
    public function provider() { return $this->belongsTo(User::class,'provider_id'); }
    public function userSkill() { return $this->belongsTo(UserSkill::class,'user_skill_id'); }
}
