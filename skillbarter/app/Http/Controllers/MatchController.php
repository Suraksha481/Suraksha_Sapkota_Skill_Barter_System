<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\User;

class MatchController extends Controller
{
    public function index(Request $request, \App\Services\RecommendationService $recoService)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // If not logged in, just redirect to find-skill
        if (!$user) {
            return redirect()->route('find-skill');
        }

        // --- REGULAR MATCHING ---
        $skillsWantedIds = $user->skillsWanted()->pluck('skill_id')->toArray();
        $skillsOfferedIds = $user->skillsOffered()->pluck('skill_id')->toArray();

        $potentialMatches = User::where('id', '!=', $user->id)
            ->where('is_active', true)
            ->where(function ($query) use ($skillsWantedIds, $skillsOfferedIds) {
                $query->whereHas('userSkills', function ($q) use ($skillsWantedIds) {
                    $q->whereIn('skill_id', $skillsWantedIds)->where('type', 'offer');
                })
                ->orWhereHas('userSkills', function ($q) use ($skillsOfferedIds) {
                    $q->whereIn('skill_id', $skillsOfferedIds)->where('type', 'request');
                });
            })
            ->with(['userSkills.skill', 'receivedFeedback' => function($q) {
                $q->whereNotNull('rating');
            }])
            ->get();

        $scoredMatches = $potentialMatches->map(function ($matchUser) use ($skillsWantedIds, $skillsOfferedIds) {
            $score = 0;
            $matchReasons = [];

            $matchOffers = $matchUser->skillsOffered()->pluck('skill_id')->toArray();
            $matchWants = $matchUser->skillsWanted()->pluck('skill_id')->toArray();

            $mutualOffers = array_intersect($skillsWantedIds, $matchOffers);
            $mutualWants = array_intersect($skillsOfferedIds, $matchWants);

            if (count($mutualOffers) > 0 && count($mutualWants) > 0) {
                $score += 50 * (count($mutualOffers) + count($mutualWants));
                $matchReasons[] = "Perfect two-way barter match!";
            } else if (count($mutualOffers) > 0) {
                $score += 20 * count($mutualOffers);
                $matchReasons[] = "They teach a skill you want to learn.";
            } else if (count($mutualWants) > 0) {
                $score += 20 * count($mutualWants);
                $matchReasons[] = "They want to learn a skill you teach.";
            }

            $avgRating = $matchUser->receivedFeedback->avg('rating') ?? 0;
            if ($avgRating > 0) {
                $score += ($avgRating * 5);
                $matchReasons[] = "Highly rated user (" . number_format($avgRating, 1) . " ★)";
            }

            $completedSessions = \App\Models\RequestModel::where(function($q) use ($matchUser) {
                $q->where('requester_id', $matchUser->id)->orWhere('responder_id', $matchUser->id);
            })->where('status', 'completed')->count();
            
            $score += min($completedSessions, 10);
            if ($completedSessions > 5) {
               $matchReasons[] = "Very active community member.";
            }

            $matchUser->match_score = round($score);
            $matchUser->match_reasons = $matchReasons;
            $matchUser->avg_rating = $avgRating;
            $matchUser->is_recommendation = false;

            return $matchUser;
        })->sortByDesc('match_score')->values();

        // --- RECOMMENDATIONS ---
        $recommendations = $recoService->suggestMatches($user);

        // Filter recommendations that aren't already in regular matches
        $regularMatchIds = $scoredMatches->pluck('id')->toArray();
        $recommendations = $recommendations->reject(function ($recoUser) use ($regularMatchIds) {
            return in_array($recoUser->id, $regularMatchIds);
        });

        return view('match.index', [
            'matches' => $scoredMatches,
            'recommendations' => $recommendations
        ]);
    }
}
