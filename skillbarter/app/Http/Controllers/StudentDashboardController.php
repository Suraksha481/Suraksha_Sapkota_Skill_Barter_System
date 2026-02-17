<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\SessionModel;
use App\Models\Feedback;

class StudentDashboardController extends Controller
{
    /**
     * Show student-specific dashboard
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get student stats
        $learningSkills = $user->skillsWanted()->with('skill')->get()->pluck('skill');

        $myRequests = RequestModel::where('requester_id', $user->id)
            ->with(['responder', 'userSkill.skill'])
            ->latest()
            ->get();

        $completedCourses = RequestModel::where('requester_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $activeCourses = RequestModel::where('requester_id', $user->id)
            ->whereIn('status', ['accepted', 'in_progress'])
            ->count();

        // Get feedback received from teachers
        $feedbackReceived = Feedback::where('target_type', 'learning')
            ->where('target_id', $user->id)
            ->with('author')
            ->latest()
            ->take(5)
            ->get();

        // Get student's average learning rating
        $averageRating = Feedback::where('target_type', 'learning')
            ->where('target_id', $user->id)
            ->whereNotNull('rating')
            ->avg('rating') ?? 0;

        $stats = [
            'learning_skills' => $learningSkills->count(),
            'my_requests' => $myRequests->count(),
            'completed_courses' => $completedCourses,
            'active_courses' => $activeCourses,
            'average_rating' => round($averageRating, 1),
        ];

        return view('student.dashboard', compact(
            'user',
            'learningSkills',
            'myRequests',
            'feedbackReceived',
            'stats'
        ));
    }
}
