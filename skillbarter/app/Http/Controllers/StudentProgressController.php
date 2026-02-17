<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\Feedback;

class StudentProgressController extends Controller
{
    /**
     * Show student's overall progress
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get all learning requests
        $allRequests = RequestModel::where('requester_id', $user->id)
            ->with(['responder', 'userSkill.skill'])
            ->latest()
            ->get();

        // Calculate statistics
        $stats = [
            'total_courses_taken' => $allRequests->count(),
            'completed_courses' => $allRequests->where('status', 'completed')->count(),
            'in_progress_courses' => $allRequests->where('status', 'in_progress')->count(),
            'pending_courses' => $allRequests->where('status', 'open')->count(),
        ];

        // Get feedback received
        $feedbackReceived = Feedback::where('target_type', 'learning')
            ->where('target_id', $user->id)
            ->with('author')
            ->latest()
            ->get();

        // Get learning hours (estimated)
        $totalHours = $allRequests->where('status', 'completed')->count() * 1.5; // Assume 1.5 hours per session

        $learningSkills = $user->skillsWanted()->with('skill')->get();

        return view('student.progress', compact(
            'user',
            'allRequests',
            'feedbackReceived',
            'stats',
            'totalHours',
            'learningSkills'
        ));
    }
}
