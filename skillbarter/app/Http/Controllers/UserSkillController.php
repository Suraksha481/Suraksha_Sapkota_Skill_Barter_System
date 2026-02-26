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

    // Skills user teaches (pivot type = offer)
    $teachSkills = $user->teachSkills()->get();

    // Skills user wants to learn (pivot type = request)
    $learnSkills = $user->learnSkills()->get();

    // All available skills for dropdown
    $allSkills = Skill::orderBy('title')->get();

    return view('my-skills.index', compact(
        'teachSkills',
        'learnSkills',
        'allSkills'
    ));
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
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'You already have this skill listed.'], 422);
            }

            return back()->with('error', 'You already have this skill listed.');
        }

        $userSkill = UserSkill::create([
            'user_id' => $user->id,
            'skill_id' => $request->skill_id,
            'type' => $request->type,
            'level' => $request->level ?? 'beginner',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            $userSkill->load('skill');
            return response()->json([
                'message' => 'Skill added successfully!',
                'user_skill' => $userSkill,
            ], 201);
        }

        return redirect()->route('my.skills')->with('success', 'Skill added successfully!');
    }

    public function destroy($id)
{
    $userSkill = UserSkill::findOrFail($id);

    if ($userSkill->user_id !== auth()->id()) {
        abort(403);
    }

    $userSkill->delete();

    return redirect()->route('my.skills')->with('success', 'Skill removed successfully!');
}
}
