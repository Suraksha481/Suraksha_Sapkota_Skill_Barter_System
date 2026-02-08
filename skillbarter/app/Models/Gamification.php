<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gamification extends Model
{
    use HasFactory;
    protected $table = 'gamification';
    protected $fillable = ['user_id','points','badges','level'];
    protected $casts = ['badges' => 'array'];
    public function user() { return $this->belongsTo(User::class); }
}
