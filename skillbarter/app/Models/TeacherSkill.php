<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_profile_id',
        'skill_id',
    ];

    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
