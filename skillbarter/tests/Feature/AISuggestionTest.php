<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Skill;
use App\Models\UserSkill;
use App\Services\AISuggestionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AISuggestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_ai_suggestion_suggests_related_skills_in_same_category()
    {
        // 1. Setup skills
        $programming = Skill::create([
            'title' => 'Python Programming',
            'description' => 'Learn Python from scratch.',
            'category' => 'Technology'
        ]);

        $webdev = Skill::create([
            'title' => 'Web Development',
            'description' => 'Build websites with HTML/CSS.',
            'category' => 'Technology'
        ]);

        // 2. Setup users
        $userA = User::factory()->create(); // The seeker
        $userB = User::factory()->create(); // The provider

        // User A wants Python
        UserSkill::create([
            'user_id' => $userA->id,
            'skill_id' => $programming->id,
            'type' => 'request',
            'level' => 'beginner'
        ]);

        // User B offers Web Development (same category, but different skill)
        UserSkill::create([
            'user_id' => $userB->id,
            'skill_id' => $webdev->id,
            'type' => 'offer',
            'level' => 'expert'
        ]);

        // 3. Run AI Suggestion
        $service = new AISuggestionService();
        $suggestions = $service->suggestMatches($userA);

        // 4. Assert
        $this->assertNotEmpty($suggestions);
        $firstSuggestion = $suggestions->first();
        $this->assertNotNull($firstSuggestion);
        $this->assertEquals($userB->id, $firstSuggestion->id);
        $this->assertTrue($firstSuggestion->is_ai_suggestion);
        $this->assertContains("Interest match: You both share an interest in Technology.", $firstSuggestion->ai_reasons);
    }
}
