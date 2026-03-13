<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    use HasFactory;
    protected $table = 'sessions';
    protected $fillable = [

        'teacher_id',
        'student_id',
        'skill_id',

        'start_time',
        'end_time',

        'meeting_link',

        'status'

    ];

    public function organiser() { return $this->belongsTo(User::class,'organiser_id'); }

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function student(){
        return $this->belongsTo(User::class,'student_id');
    }

    public function materials(){
        return $this->hasMany(SessionMaterial::class,'session_id');
    }

    public function assignments(){
        return $this->hasMany(SessionAssignment::class,'session_id');
    }
    
}
