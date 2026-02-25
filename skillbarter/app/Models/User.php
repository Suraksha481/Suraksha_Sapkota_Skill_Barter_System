<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'is_teacher_approved',
        'bio',
        'avatar',
        'provider',
        'provider_id',
        'provider_token',
        'provider_refresh_token',
        'oauth_synced_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'string',
        'is_active' => 'boolean',
        'is_teacher_approved' => 'boolean',
    ];


    // ROLE HELPERS (CLEAN & STRICT)


    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function canTeach(): bool
    {
        return $this->isTeacher() && $this->is_teacher_approved && $this->is_active;
    }

    // RELATIONSHIPS


    public function userSkills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function teachSkills()
    {
        return $this->skills()->wherePivot('type', 'offer');
    }

    public function learnSkills()
    {
        return $this->skills()->wherePivot('type', 'request');
    }

    public function matchesAsSeeker()
    {
        return $this->hasMany(MatchModel::class, 'seeker_id');
    }

    public function matchesAsProvider()
    {
        return $this->hasMany(MatchModel::class, 'provider_id');
    }

    public function requestsMade()
    {
        return $this->hasMany(RequestModel::class, 'requester_id');
    }

    public function requestsReceived()
    {
        return $this->hasMany(RequestModel::class, 'responder_id');
    }

    public function sessions()
    {
        return $this->hasMany(SessionModel::class, 'organiser_id');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function gamification()
    {
        return $this->hasOne(Gamification::class);
    }

    public function premiumMembership()
    {
        return $this->hasOne(PremiumMembership::class);
    }

    public function feedbackGiven()
    {
        return $this->hasMany(Feedback::class, 'author_id');
    }

    public function teacherProfile()
    {
        return $this->hasOne(TeacherProfile::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

   // PREMIUM LOGIC


    public function isPremium(): bool
    {
        return $this->premiumMembership &&
            $this->premiumMembership->status === 'active' &&
            $this->premiumMembership->expires_at > now();
    }

    // GAMIFICATION


    public function getPoints(): int
    {
        return $this->gamification?->points ?? 0;
    }

    public function getLevel(): int
    {
        return $this->gamification?->level ?? 1;
    }

    public function getBadges(): array
    {
        return $this->gamification?->badges ?? [];
    }

    // STATS


    public function getAverageRating(): float
    {
        $feedbacks = Feedback::where('target_type', 'user')
            ->where('target_id', $this->id)
            ->whereNotNull('rating')
            ->pluck('rating');

        return $feedbacks->count() > 0 ? round($feedbacks->avg(), 1) : 0;
    }

    public function getCompletedSessionsCount(): int
    {
        return $this->requestsMade()->where('status', 'completed')->count()
            + $this->requestsReceived()->where('status', 'completed')->count();
    }

    // EMAIL VERIFICATION


    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }
}
