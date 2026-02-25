<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\SessionModel;
use App\Models\Feedback;

class TeacherDashboardController extends Controller
{
    /**
     * Show teacher-specific dashboard
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user->canTeach()) {
            return redirect()->route('dashboard')
                ->with('error', 'Awaiting admin approval.');
        }
        $user = $request->user();

        // Get teacher stats
        $teachingSkills = $user->skillsOffered()->with('skill')->get()->pluck('skill');

        $studentRequests = RequestModel::where('responder_id', $user->id)
            ->with(['requester', 'userSkill.skill'])
            ->latest()
            ->get();

        $completedSessions = RequestModel::where('responder_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $activeSessions = RequestModel::where('responder_id', $user->id)
            ->whereIn('status', ['accepted', 'in_progress'])
            ->count();

        // Get student feedback received
        $feedbackReceived = Feedback::where('target_type', 'teaching')
            ->where('target_id', $user->id)
            ->with('author')
            ->latest()
            ->take(5)
            ->get();

        // Get teacher's average rating
        $averageRating = Feedback::where('target_type', 'teaching')
            ->where('target_id', $user->id)
            ->whereNotNull('rating')
            ->avg('rating') ?? 0;

        $stats = [
            'teaching_skills' => $teachingSkills->count(),
            'student_requests' => $studentRequests->count(),
            'completed_sessions' => $completedSessions,
            'active_sessions' => $activeSessions,
            'average_rating' => round($averageRating, 1),
        ];

        return view('teacher.dashboard', compact(
            'user',
            'teachingSkills',
            'studentRequests',
            'feedbackReceived',
            'stats'
        ));
    }
}
