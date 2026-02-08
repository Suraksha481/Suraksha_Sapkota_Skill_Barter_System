<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\UserSkill;
use App\Models\SessionModel;

class HomeController extends Controller
{
    public function index()
    {
        // Platform stats
        $totalUsers = User::count();
        $totalSkills = Skill::count();
        $totalSessions = SessionModel::where('status', 'completed')->count();

        // Trending skills (most taught)
        $trendingSkills = Skill::withCount('userSkills')
            ->orderByDesc('user_skills_count')
            ->take(6)
            ->get();

        // Latest skills
        $latestSkills = Skill::latest()->take(6)->get();

        // Categories
        $categories = Skill::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->get();

        return view('home', compact(
            'totalUsers',
            'totalSkills',
            'totalSessions',
            'trendingSkills',
            'latestSkills',
            'categories'
        ));
    }
}
