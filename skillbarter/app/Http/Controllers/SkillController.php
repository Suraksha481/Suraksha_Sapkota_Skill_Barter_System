<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * FIND SKILLS (SEARCH + FILTER)
     */
    public function index(Request $request)
{
    $query = Skill::query();

    // Search by keyword (Precision Search)
    if ($request->filled('q')) {
        $q = $request->q;
        if (strlen($q) < 2) {
            // If just a letter, don't show any results as requested
            $query->where('id', 0); 
        } else {
            $query->where(function ($sub) use ($q) {
                // Focus primarily on title and category for precision
                $sub->where('title', 'like', '%' . $q . '%')
                  ->orWhere('category', 'like', '%' . $q . '%');
            });
        }
    }

    // Filter by category
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    $skills = $query->orderBy('title')->paginate(12);

    // Categories for dropdown
    $categories = Skill::select('category')
        ->whereNotNull('category')
        ->distinct()
        ->orderBy('category')
        ->pluck('category');

    return view('find-skill', compact('skills', 'categories'));
}


    /**
     * SKILL DETAIL PAGE
     */
    public function show(Skill $skill)
    {
        $user = auth()->user();
        
        // Fetch teachers who have this skill and are approved/active
        $teachersQuery = User::where('role','teacher')
            ->whereHas('userSkills', function($q) use ($skill) {
                $q->where('skill_id', $skill->id);
            });

        // 1. Exclude the current user from the mentors list
        if ($user) {
            $teachersQuery->where('id', '!=', $user->id);
        }

        $teachers = $teachersQuery->with('userSkills.skill')->get();

        $isAdded = false;
        if ($user) {
            $isAdded = $user->userSkills()
                ->where('skill_id', $skill->id)
                ->exists();
        }

        return view('skill-detail', compact('skill','teachers', 'isAdded'));
    }
}
