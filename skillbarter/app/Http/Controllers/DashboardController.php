<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\UserSkill;
use App\Models\RequestModel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $teachSkills = $user->skillsOffered()->with('skill')->get();
        $learnSkills = $user->skillsWanted()->with('skill')->get();

        $pendingRequests = RequestModel::where('responder_id', $user->id)
            ->where('status', 'open')
            ->with(['requester', 'userSkill.skill'])
            ->latest()
            ->take(5)
            ->get();

        $myRequests = RequestModel::where('requester_id', $user->id)
            ->whereIn('status', ['open', 'accepted', 'in_progress'])
            ->with(['responder', 'userSkill.skill'])
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'teach_skills' => $teachSkills->count(),
            'learn_skills' => $learnSkills->count(),
            'pending_requests' => $pendingRequests->count(),
            'total_requests' => RequestModel::where('requester_id', $user->id)
                ->orWhere('responder_id', $user->id)
                ->count(),
        ];

        return view('dashboard.index', compact(
            'user',
            'teachSkills',
            'learnSkills',
            'pendingRequests',
            'myRequests',
            'stats'
        ));
    }
}
