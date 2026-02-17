<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\Feedback;

class TeacherAnalyticsController extends Controller
{
    /**
     * Show teacher analytics
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get all completed sessions
        $completedSessions = RequestModel::where('responder_id', $user->id)
            ->where('status', 'completed')
            ->with(['requester', 'userSkill.skill'])
            ->latest()
            ->get();

        // Get all feedback received
        $allFeedback = Feedback::where('target_type', 'teaching')
            ->where('target_id', $user->id)
            ->with('author')
            ->latest()
            ->get();

        // Calculate statistics
        $stats = [
            'total_students_taught' => $completedSessions->unique('requester_id')->count(),
            'total_sessions_completed' => $completedSessions->count(),
            'total_feedback_received' => $allFeedback->count(),
            'average_rating' => $allFeedback->whereNotNull('rating')->avg('rating') ?? 0,
            'rating_count' => $allFeedback->whereNotNull('rating')->count(),
        ];

        // Get skills statistics
        $skillStats = $completedSessions->groupBy('userSkill.skill.title')
            ->map(fn($group) => [
                'skill' => $group->first()->userSkill->skill->title,
                'count' => $group->count(),
            ])
            ->values()
            ->sortByDesc('count')
            ->take(5);

        return view('teacher.analytics', compact(
            'user',
            'completedSessions',
            'allFeedback',
            'stats',
            'skillStats'
        ));
    }
}
