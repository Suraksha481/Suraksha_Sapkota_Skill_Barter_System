<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = ['author_id', 'target_type', 'target_id', 'rating', 'comment'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function target()
    {
        return $this->morphTo();
    }
}
