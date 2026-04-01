<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Skill;
use App\Models\UserSkill;
use App\Services\RecommendationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationTest extends TestCase
{
    use RefreshDatabase;

    public function test_recommendation_suggests_related_skills_in_same_category()
    {
        // 1. Setup skills
        $programming = Skill::create([
            'title' => 'Python Programming',
            'slug' => 'python-programming',
            'description' => 'Learn Python from scratch.',
            'category' => 'Technology'
        ]);

        $webdev = Skill::create([
            'title' => 'Web Development',
            'slug' => 'web-development',
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
            'level' => 'advanced'
        ]);

        // 3. Run Recommendation Service
        $service = new RecommendationService();
        $recommendations = $service->suggestMatches($userA);

        // 4. Assert
        $this->assertNotEmpty($recommendations);
        /** @var \App\Models\User $firstRec */
        $firstRec = $recommendations->first();
        $this->assertNotNull($firstRec);
        $this->assertEquals($userB->id, $firstRec->id);
        $this->assertTrue($firstRec->is_recommendation);
        $this->assertContains("Interest match: You both share an interest in Technology.", $firstRec->match_reasons);
    }
}
