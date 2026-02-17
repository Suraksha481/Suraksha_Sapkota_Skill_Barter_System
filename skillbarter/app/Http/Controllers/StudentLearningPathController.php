<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;

class StudentLearningPathController extends Controller
{
    /**
     * Show student's learning path
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $enrolledCourses = RequestModel::where('requester_id', $user->id)
            ->whereIn('status', ['accepted', 'in_progress', 'completed'])
            ->with(['responder', 'userSkill.skill'])
            ->latest()
            ->paginate(12);

        $learningSkills = $user->skillsWanted()->with('skill')->get();

        return view('student.learning-path', compact(
            'enrolledCourses',
            'learningSkills'
        ));
    }

    /**
     * Show progress on a specific skill
     */
    public function showProgress(Request $request, $skillId)
    {
        $user = $request->user();

        $coursesForSkill = RequestModel::where('requester_id', $user->id)
            ->whereHas('userSkill.skill', fn($q) => $q->where('id', $skillId))
            ->with(['responder', 'userSkill.skill'])
            ->latest()
            ->get();

        $completedCount = $coursesForSkill->where('status', 'completed')->count();
        $inProgressCount = $coursesForSkill->where('status', 'in_progress')->count();

        $skill = $coursesForSkill->first()?->userSkill->skill;

        return view('student.skill-progress', compact(
            'skill',
            'coursesForSkill',
            'completedCount',
            'inProgressCount'
        ));
    }
}
