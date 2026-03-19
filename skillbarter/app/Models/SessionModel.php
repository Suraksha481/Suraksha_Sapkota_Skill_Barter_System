<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    use HasFactory;
    protected $table = 'sessions';
    protected $fillable = [

        'organiser_id',
        'participant_id',
        'skill_id',
        'request_id',

        'start_time',
        'end_time',

        'meeting_link',
        'is_live',

        'status'

    ];

    public function organiser() { return $this->belongsTo(User::class,'organiser_id'); }

    public function teacher(){
        return $this->belongsTo(User::class,'organiser_id');
    }

    public function student(){
        return $this->belongsTo(User::class,'participant_id');
    }

    public function materials(){
        return $this->hasMany(SessionMaterial::class,'session_id');
    }

    public function assignments(){
        return $this->hasMany(SessionAssignment::class,'session_id');
    }

    public function skill(){
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function request(){
        return $this->belongsTo(RequestModel::class, 'request_id');
    }
}
