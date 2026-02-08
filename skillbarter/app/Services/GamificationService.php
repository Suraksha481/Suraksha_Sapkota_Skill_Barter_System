<?php

namespace App\Services;

use App\Models\User;
use App\Models\Gamification;

class GamificationService
{
    const POINTS_COMPLETE_SESSION = 50;
    const POINTS_GIVE_FEEDBACK = 10;
    const POINTS_RECEIVE_5_STAR = 25;
    const POINTS_FIRST_SKILL_ADDED = 20;
    const POINTS_PROFILE_COMPLETE = 30;

    const BADGES = [
        'newcomer' => ['name' => 'Newcomer', 'description' => 'Welcome to SkillBarter!', 'icon' => '🌟'],
        'first_session' => ['name' => 'First Steps', 'description' => 'Completed your first session', 'icon' => '🎯'],
        'helper' => ['name' => 'Helper', 'description' => 'Completed 5 sessions as teacher', 'icon' => '🤝'],
        'learner' => ['name' => 'Quick Learner', 'description' => 'Completed 5 sessions as student', 'icon' => '📚'],
        'superstar' => ['name' => 'Superstar', 'description' => 'Received 10 five-star ratings', 'icon' => '⭐'],
        'mentor' => ['name' => 'Mentor', 'description' => 'Completed 25 teaching sessions', 'icon' => '🎓'],
        'explorer' => ['name' => 'Explorer', 'description' => 'Added 5 different skills', 'icon' => '🧭'],
        'trusted' => ['name' => 'Trusted Member', 'description' => 'Maintained 4.5+ rating for 10 sessions', 'icon' => '✅'],
        'veteran' => ['name' => 'Veteran', 'description' => 'Been active for 6 months', 'icon' => '🏆'],
        'premium' => ['name' => 'Premium Member', 'description' => 'Upgraded to premium', 'icon' => '💎'],
    ];

    const LEVELS = [
        1 => 0,
        2 => 100,
        3 => 250,
        4 => 500,
        5 => 1000,
        6 => 2000,
        7 => 3500,
        8 => 5500,
        9 => 8000,
        10 => 12000,
    ];

    public function getOrCreateGamification(User $user): Gamification
    {
        $gamification = $user->gamification;

        if (!$gamification) {
            $gamification = Gamification::create([
                'user_id' => $user->id,
                'points' => 0,
                'badges' => ['newcomer'],
                'level' => 1,
            ]);
        }

        return $gamification;
    }

    public function addPoints(User $user, int $points, string $reason = ''): Gamification
    {
        $gamification = $this->getOrCreateGamification($user);
        $gamification->points += $points;
        $gamification->level = $this->calculateLevel($gamification->points);
        $gamification->save();

        return $gamification;
    }

    public function calculateLevel(int $points): int
    {
        $level = 1;
        foreach (self::LEVELS as $lvl => $requiredPoints) {
            if ($points >= $requiredPoints) {
                $level = $lvl;
            }
        }
        return $level;
    }

    public function getPointsToNextLevel(int $currentPoints): int
    {
        $currentLevel = $this->calculateLevel($currentPoints);
        $nextLevel = $currentLevel + 1;

        if (!isset(self::LEVELS[$nextLevel])) {
            return 0;
        }

        return self::LEVELS[$nextLevel] - $currentPoints;
    }

    public function getLevelProgress(int $currentPoints): array
    {
        $currentLevel = $this->calculateLevel($currentPoints);
        $nextLevel = $currentLevel + 1;

        if (!isset(self::LEVELS[$nextLevel])) {
            return [
                'current_points' => $currentPoints,
                'level_points' => self::LEVELS[$currentLevel],
                'percentage' => 100,
            ];
        }

        $currentLevelPoints = self::LEVELS[$currentLevel];
        $nextLevelPoints = self::LEVELS[$nextLevel];
        $range = $nextLevelPoints - $currentLevelPoints;
        $progress = $currentPoints - $currentLevelPoints;

        return [
            'current_points' => $progress,
            'level_points' => $range,
            'percentage' => min(100, (int)(($progress / $range) * 100)),
        ];
    }

    public function awardBadge(User $user, string $badgeKey): bool
    {
        if (!isset(self::BADGES[$badgeKey])) {
            return false;
        }

        $gamification = $this->getOrCreateGamification($user);
        $badges = $gamification->badges ?? [];

        if (in_array($badgeKey, $badges)) {
            return false;
        }

        $badges[] = $badgeKey;
        $gamification->badges = $badges;
        $gamification->save();

        return true;
    }

    public function hasBadge(User $user, string $badgeKey): bool
    {
        $gamification = $user->gamification;
        if (!$gamification) return false;

        return in_array($badgeKey, $gamification->badges ?? []);
    }

    public function checkAndAwardBadges(User $user): array
    {
        $awarded = [];

        $teachingSessions = $user->requestsReceived()->where('status', 'completed')->count();
        $learningSessions = $user->requestsMade()->where('status', 'completed')->count();
        $totalSessions = $teachingSessions + $learningSessions;
        $skillsCount = $user->userSkills()->count();
        $fiveStarCount = \App\Models\Feedback::where('target_type', 'user')
            ->where('target_id', $user->id)
            ->where('rating', 5)
            ->count();

        if ($totalSessions >= 1 && $this->awardBadge($user, 'first_session')) {
            $awarded[] = 'first_session';
        }

        if ($teachingSessions >= 5 && $this->awardBadge($user, 'helper')) {
            $awarded[] = 'helper';
        }

        if ($learningSessions >= 5 && $this->awardBadge($user, 'learner')) {
            $awarded[] = 'learner';
        }

        if ($teachingSessions >= 25 && $this->awardBadge($user, 'mentor')) {
            $awarded[] = 'mentor';
        }

        if ($skillsCount >= 5 && $this->awardBadge($user, 'explorer')) {
            $awarded[] = 'explorer';
        }

        if ($fiveStarCount >= 10 && $this->awardBadge($user, 'superstar')) {
            $awarded[] = 'superstar';
        }

        if ($user->isPremium() && $this->awardBadge($user, 'premium')) {
            $awarded[] = 'premium';
        }

        return $awarded;
    }

    public function getBadgeDetails(string $badgeKey): ?array
    {
        return self::BADGES[$badgeKey] ?? null;
    }

    public function getAllBadges(): array
    {
        $badges = [];
        foreach (self::BADGES as $key => $badgeData) {
            $badges[] = array_merge($badgeData, ['key' => $key]);
        }
        return $badges;
    }

    public function getUserBadgesWithDetails(User $user): array
    {
        $gamification = $user->gamification;
        if (!$gamification) return [];

        $userBadges = $gamification->badges ?? [];
        $details = [];

        foreach ($userBadges as $badgeKey) {
            if (isset(self::BADGES[$badgeKey])) {
                $details[] = array_merge(
                    self::BADGES[$badgeKey],
                    ['key' => $badgeKey]
                );
            }
        }

        return $details;
    }

    public function getLeaderboard(int $limit = 10): \Illuminate\Support\Collection
    {
        return Gamification::with('user')
            ->orderBy('points', 'desc')
            ->limit($limit)
            ->get();
    }
}
