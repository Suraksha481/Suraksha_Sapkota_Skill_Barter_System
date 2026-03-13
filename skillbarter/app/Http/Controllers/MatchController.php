<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\User;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // If not logged in, just redirect to find-skill
        if (!$user) {
            return redirect()->route('find-skill');
        }

        // Get the skills the current user wants to learn (requests)
        $skillsWantedIds = $user->skillsWanted()->pluck('skill_id')->toArray();
        
        // Get the skills the current user can teach (offers)
        $skillsOfferedIds = $user->skillsOffered()->pluck('skill_id')->toArray();

        // Find potential matches: users who teach what I want OR want what I teach
        // We exclude the current user
        $potentialMatches = User::where('id', '!=', $user->id)
            ->where('is_active', true)
            ->where(function ($query) use ($skillsWantedIds, $skillsOfferedIds) {
                // Users who offer what I want to learn
                $query->whereHas('userSkills', function ($q) use ($skillsWantedIds) {
                    $q->whereIn('skill_id', $skillsWantedIds)->where('type', 'offer');
                })
                // Users who want what I offer
                ->orWhereHas('userSkills', function ($q) use ($skillsOfferedIds) {
                    $q->whereIn('skill_id', $skillsOfferedIds)->where('type', 'request');
                });
            })
            ->with(['userSkills.skill', 'receivedFeedback' => function($q) {
                $q->whereNotNull('rating');
            }])
            ->get();

        // Calculate Match Score for each potential match
        // Scoring logic:
        // +50 points for each exactly matched mutual skill (I want X, they teach X AND I teach Y, they want Y)
        // +20 points for a one-way match (I want X, they teach X)
        // + (average_rating * 5) points (max 25 points)
        // + min(activity_count, 10) points
        
        $scoredMatches = $potentialMatches->map(function ($matchUser) use ($skillsWantedIds, $skillsOfferedIds) {
            $score = 0;
            $matchReasons = [];

            // Get match's skills
            $matchOffers = $matchUser->skillsOffered()->pluck('skill_id')->toArray();
            $matchWants = $matchUser->skillsWanted()->pluck('skill_id')->toArray();

            $mutualOffers = array_intersect($skillsWantedIds, $matchOffers); // What they offer that I want
            $mutualWants = array_intersect($skillsOfferedIds, $matchWants);   // What they want that I offer

            if (count($mutualOffers) > 0 && count($mutualWants) > 0) {
                // Two-way mutual match (The holy grail of skill barter)
                $score += 50 * (count($mutualOffers) + count($mutualWants));
                $matchReasons[] = "Perfect two-way barter match!";
            } else if (count($mutualOffers) > 0) {
                // They teach what I want
                $score += 20 * count($mutualOffers);
                $matchReasons[] = "They teach a skill you want to learn.";
            } else if (count($mutualWants) > 0) {
                // They want what I teach
                $score += 20 * count($mutualWants);
                $matchReasons[] = "They want to learn a skill you teach.";
            }

            // Rating bonus
            $avgRating = $matchUser->receivedFeedback->avg('rating') ?? 0;
            if ($avgRating > 0) {
                $score += ($avgRating * 5);
                $matchReasons[] = "Highly rated user (" . number_format($avgRating, 1) . " ★)";
            }

            // Activity bonus (Completed sessions)
            $completedSessions = \App\Models\RequestModel::where(function($q) use ($matchUser) {
                $q->where('requester_id', $matchUser->id)->orWhere('responder_id', $matchUser->id);
            })->where('status', 'completed')->count();
            
            $score += min($completedSessions, 10); // Cap at 10 points
            if ($completedSessions > 5) {
               $matchReasons[] = "Very active community member.";
            }

            $matchUser->match_score = round($score);
            $matchUser->match_reasons = $matchReasons;
            $matchUser->avg_rating = $avgRating;
            
            return $matchUser;
        });

        // Sort by highest score first
        $scoredMatches = $scoredMatches->sortByDesc('match_score')->values();

        return view('match.index', [
            'matches' => $scoredMatches
        ]);
    }
}
