<?php

namespace App\Services;

use App\Models\User;
use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AISuggestionService
{
    /**
     * Suggest potential matches for a user based on semantic-like logic.
     * This considers keyword overlap and category similarity.
     */
    public function suggestMatches(User $user): Collection
    {
        // 1. Get skills user wants to learn (requests)
        $wantedSkills = $user->skillsWanted()->with('skill')->get();
        if ($wantedSkills->isEmpty()) {
            return collect();
        }

        $wantedLevels = $wantedSkills->pluck('level', 'skill_id')->toArray();
        $wantedSkillModels = $wantedSkills->pluck('skill');
        $wantedCategories = $wantedSkillModels->pluck('category')->unique()->filter()->toArray();
        $wantedTitles = $wantedSkillModels->pluck('title')->toArray();

        // 2. Find users who offer skills that might be related
        // We look for:
        // - Skills in the same categories
        // - Skills with similar keywords in title/description
        
        $suggestions = User::where('id', '!=', $user->id)
            ->where('is_active', true)
            ->whereHas('userSkills', function ($query) use ($wantedCategories, $wantedTitles) {
                $query->where('type', 'offer')
                    ->where(function ($q) use ($wantedCategories, $wantedTitles) {
                        // Category match
                        $q->whereHas('skill', function ($sq) use ($wantedCategories) {
                            $sq->whereIn('category', $wantedCategories);
                        });
                        
                        // Keyword match (fuzzy titles)
                        foreach ($wantedTitles as $title) {
                            $keywords = explode(' ', strtolower($title));
                            foreach ($keywords as $word) {
                                if (strlen($word) > 3) { // Only meaningful words
                                    $q->orWhereHas('skill', function ($sq) use ($word) {
                                        $sq->where('title', 'LIKE', '%' . $word . '%')
                                           ->orWhere('description', 'LIKE', '%' . $word . '%');
                                    });
                                }
                            }
                        }
                    });
            })
            ->with(['userSkills.skill', 'receivedFeedback' => function($q) {
                $q->whereNotNull('rating');
            }])
            ->get();

        // 3. Score and Filter Suggestions
        $scoredSuggestions = $suggestions->map(function ($suggestedUser) use ($user, $wantedSkillModels, $wantedCategories) {
            $score = 0;
            $reasons = [];

            $offeredSkills = $suggestedUser->skillsOffered()->with('skill')->get();
            
            foreach ($offeredSkills as $offer) {
                $offerSkill = $offer->skill;
                
                // Exact Match (handled by regular matching too, but we keep it for completeness in AI logic)
                $isExactMatch = $wantedSkillModels->contains('id', $offerSkill->id);
                if ($isExactMatch) {
                    $score += 30;
                    $reasons[] = "Exact match: They teach '" . $offerSkill->title . "'.";
                    continue; // No need to check semantic for exact match
                }

                // Category match
                if (in_array($offerSkill->category, $wantedCategories)) {
                    $score += 15;
                    $reasons[] = "Interest match: You both share an interest in " . $offerSkill->category . ".";
                }

                // Keyword/Semantic match simulation
                foreach ($wantedSkillModels as $wanted) {
                    $wantedWords = explode(' ', strtolower($wanted->title));
                    $offerWords = explode(' ', strtolower($offerSkill->title));
                    
                    $intersect = array_intersect($wantedWords, $offerWords);
                    $intersect = array_filter($intersect, function($w) { return strlen($w) > 3; });

                    if (count($intersect) > 0) {
                        $score += 10 * count($intersect);
                        $reasons[] = "Related topic: They teach '" . $offerSkill->title . "' which relates to '" . $wanted->title . "'.";
                    }
                }
            }

            // Rating Bonus
            $avgRating = $suggestedUser->receivedFeedback->avg('rating') ?? 0;
            if ($avgRating >= 4.0) {
                $score += 10;
                $reasons[] = "High community rating.";
            }

            $suggestedUser->ai_score = $score;
            $suggestedUser->ai_reasons = array_unique($reasons);
            $suggestedUser->is_ai_suggestion = true;

            return $suggestedUser;
        });

        // 4. Return top suggestions (excluding things already in exact match if preferred, 
        // but here we just return them sorted by AI score)
        return $scoredSuggestions->filter(function($u) {
            return $u->ai_score > 0;
        })->sortByDesc('ai_score')->values();
    }
}
