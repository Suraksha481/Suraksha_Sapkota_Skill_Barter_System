<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'image'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class , 'user_skills')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function userSkills()
    {
        return $this->hasMany(UserSkill::class);
    }


}
