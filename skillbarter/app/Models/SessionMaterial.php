<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'title',
        'file_path',
        'file_url'
    ];

    public function session()
    {
        return $this->belongsTo(SessionModel::class, 'session_id');
    }
}
