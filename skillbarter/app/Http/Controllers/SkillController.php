<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * FIND SKILLS (SEARCH + FILTER)
     */
    public function index(Request $request)
{
    $query = Skill::query();

    // Search by keyword
    if ($request->filled('q')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->q . '%')
              ->orWhere('description', 'like', '%' . $request->q . '%')
              ->orWhere('category', 'like', '%' . $request->q . '%');
        });
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
        return view('skill-detail', compact('skill'));
    }
}
