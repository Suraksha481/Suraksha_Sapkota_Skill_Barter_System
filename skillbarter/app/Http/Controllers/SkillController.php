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
        // also fetch teachers who have this skill and are approved/active
        $teachers = User::where('role','teacher')
            ->where('is_teacher_approved', true)
            ->where('is_active', true)
            ->whereHas('userSkills', function($q) use ($skill) {
                $q->where('skill_id', $skill->id);
            })
            ->with('userSkills.skill')
            ->get();

        $isAdded = false;
        if (auth()->check()) {
            $isAdded = auth()->user()->userSkills()
                ->where('skill_id', $skill->id)
                ->exists();
        }

        return view('skill-detail', compact('skill','teachers', 'isAdded'));
    }
}
