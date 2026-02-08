<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    use HasFactory;
    protected $table = 'sessions';
    protected $fillable = ['title','description','organiser_id','starts_at','ends_at','location','capacity'];

    public function organiser() { return $this->belongsTo(User::class,'organiser_id'); }
}
