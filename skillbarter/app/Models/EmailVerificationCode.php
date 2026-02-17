<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailVerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the code is valid (not expired and not used).
     */
    public function isValid(): bool
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Mark the code as used.
     */
    public function markAsUsed(): void
    {
        $this->update(['used' => true]);
    }

    /**
     * Get a valid code for a user.
     */
    public static function getValidCodeForUser($userId)
    {
        return self::where('user_id', $userId)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();
    }
}
