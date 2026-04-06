<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'category',
        'role',
        'image_path',
        'teacher_route',
        'student_route',
    ];
}
