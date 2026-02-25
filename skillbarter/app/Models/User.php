<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\TeacherProfile;
use App\Models\StudentProfile;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
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
        'role' => 'string', // Single role: 'teacher' or 'student'
        'is_active' => 'boolean',
    ];

    public function userSkills() { return $this->hasMany(UserSkill::class); }
    public function skillsOffered() { return $this->hasMany(UserSkill::class)->where('type', 'offer'); }
    public function skillsWanted() { return $this->hasMany(UserSkill::class)->where('type', 'request'); }
    public function matchesAsSeeker() { return $this->hasMany(MatchModel::class,'seeker_id'); }
    public function matchesAsProvider() { return $this->hasMany(MatchModel::class,'provider_id'); }
    public function requestsMade() { return $this->hasMany(RequestModel::class,'requester_id'); }
    public function requestsReceived() { return $this->hasMany(RequestModel::class,'responder_id'); }
    public function sessions() { return $this->hasMany(SessionModel::class, 'organiser_id'); }
    public function resources() { return $this->hasMany(Resource::class); }
    public function gamification() { return $this->hasOne(Gamification::class); }
    public function premiumMembership() { return $this->hasOne(PremiumMembership::class); }
    public function feedbackGiven() { return $this->hasMany(Feedback::class, 'author_id'); }

    public function isPremium(): bool
    {
        return $this->premiumMembership &&
               $this->premiumMembership->status === 'active' &&
               $this->premiumMembership->expires_at > now();
    }

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
        return $this->requestsMade()->where('status', 'completed')->count() +
               $this->requestsReceived()->where('status', 'completed')->count();
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

    public function teacherProfile()
    {
        return $this->hasOne(TeacherProfile::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role): bool
    {
        return (string)$this->role === (string)$role;
    }

    /**
     * Check if user is a teacher
     */
    public function isTeacher(): bool
    {
        return $this->hasRole('teacher');
    }

    /**
     * Check if user is a student
     */
    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    /**
     * Add a role to user
     */
    public function addRole($role): void
    {
        // Enforce single-role policy: replace existing role
        $this->update(['role' => $role]);
    }

    /**
     * Remove a role from user
     */
    public function removeRole($role): void
    {
        if ((string)$this->role === (string)$role) {
            $this->update(['role' => null]);
        }
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }
}
