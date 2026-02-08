<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Http\Request;

class UserSkillController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $teachSkills = $user->skillsOffered()->with('skill')->get();
        $learnSkills = $user->skillsWanted()->with('skill')->get();
        $allSkills = Skill::orderBy('title')->get();
        $categories = Skill::distinct()->pluck('category')->filter();

        return view('dashboard.skills', compact('teachSkills', 'learnSkills', 'allSkills', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'type' => 'required|in:offer,request',
            'level' => 'nullable|in:beginner,intermediate,advanced',
        ]);

        $user = $request->user();

        $exists = UserSkill::where('user_id', $user->id)
            ->where('skill_id', $request->skill_id)
            ->where('type', $request->type)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have this skill listed.');
        }

        UserSkill::create([
            'user_id' => $user->id,
            'skill_id' => $request->skill_id,
            'type' => $request->type,
            'level' => $request->level ?? 'beginner',
        ]);

        return redirect()->route('my.skills')->with('success', 'Skill added successfully!');
    }

    public function destroy(UserSkill $skill)
    {
        if ($skill->user_id !== auth()->id()) {
            abort(403);
        }

        $skill->delete();

        return redirect()->route('my.skills')->with('success', 'Skill removed successfully!');
    }
}
