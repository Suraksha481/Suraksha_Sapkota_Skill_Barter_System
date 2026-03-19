<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'student_id',
        'title',
        'details',
        'file_path',
        'file_url'
    ];

    public function session()
    {
        return $this->belongsTo(SessionModel::class, 'session_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
