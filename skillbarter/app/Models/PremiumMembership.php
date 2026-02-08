<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PremiumMembership extends Model
{
    protected $fillable = [
        'user_id',
        'plan',
        'started_at',
        'expires_at',
        'status',
        'name',
        'price',
        'currency',
        'features_json',
        'billing_cycle',
    ];

    protected $casts = [
        'features_json' => 'array',
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
