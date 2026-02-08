<?php

namespace App\Http\Controllers;

use App\Services\GamificationService;
use Illuminate\Http\Request;

class RewardsController extends Controller
{
    protected $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $gamification = $this->gamificationService->getOrCreateGamification($user);
        $this->gamificationService->checkAndAwardBadges($user);

        $userBadgesRaw = $this->gamificationService->getUserBadgesWithDetails($user);
        $allBadgesRaw = $this->gamificationService->getAllBadges();
        $leaderboard = $this->gamificationService->getLeaderboard(10);

        $points = $gamification->points;
        $level = $gamification->level;

        $currentLevelPoints = GamificationService::LEVELS[$level] ?? 0;
        $nextLevel = $level + 1;
        $nextLevelPoints = GamificationService::LEVELS[$nextLevel] ?? $currentLevelPoints;
        $range = max(1, $nextLevelPoints - $currentLevelPoints);
        $progress = $points - $currentLevelPoints;
        $percentage = isset(GamificationService::LEVELS[$nextLevel])
            ? min(100, (int)(($progress / $range) * 100))
            : 100;

        $levelProgress = [
            'current_points' => $progress,
            'level_points' => $range,
            'percentage' => $percentage,
        ];

        $pointsToNext = $this->gamificationService->getPointsToNextLevel($points);

        $userBadges = [];
        foreach ($userBadgesRaw as $key => $badge) {
            $badge['key'] = $key;
            $userBadges[] = $badge;
        }

        $allBadges = [];
        foreach ($allBadgesRaw as $key => $badge) {
            $badge['key'] = $key;
            $allBadges[] = $badge;
        }

        $userRank = null;
        foreach ($leaderboard as $index => $entry) {
            if ($entry->user_id === $user->id) {
                $userRank = $index + 1;
                break;
            }
        }

        $stats = [
            'sessions_taught' => $user->requestsReceived()->where('status', 'completed')->count(),
            'sessions_learned' => $user->requestsMade()->where('status', 'completed')->count(),
            'skills_count' => $user->userSkills()->count(),
            'feedback_given' => $user->feedbackGiven()->count(),
        ];

        return view('rewards.index', compact(
            'user',
            'gamification',
            'userBadges',
            'allBadges',
            'leaderboard',
            'points',
            'level',
            'levelProgress',
            'pointsToNext',
            'userRank',
            'stats'
        ));
    }
}
