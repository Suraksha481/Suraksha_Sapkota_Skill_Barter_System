<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\RequestModel;
use App\Models\PremiumMembership;
use App\Models\Feedback;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
 public function dashboard()
{
    $totalUsers = \App\Models\User::count();

    $totalTeachers = \App\Models\User::where('role', 'teacher')->count();

    $totalStudents = \App\Models\User::where('role', 'student')->count();

    $totalSkills = \App\Models\Skill::count();

    $totalRequests = \App\Models\RequestModel::count();

    $totalSessions = \App\Models\SessionModel::count();

    $totalPremium = \App\Models\PremiumMembership::where('status', 'active')->count();

    $totalFeedbacks = \App\Models\Feedback::count();

    return view('admin.dashboard', [
        'totalUsers' => $totalUsers,
        'totalTeachers' => $totalTeachers,
        'totalStudents' => $totalStudents,
        'totalSkills' => $totalSkills,
        'totalRequests' => $totalRequests,
        'totalSessions' => $totalSessions,
        'totalPremium' => $totalPremium,
        'totalFeedbacks' => $totalFeedbacks,
    ]);
}

    /**
     * Users list
     */
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    /**
     * Toggle user active
     */
    public function toggleUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'User status updated.');
    }

    public function changeUserRole(\Illuminate\Http\Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role ?: null;
        $user->save();

        return back()->with('status', 'User role updated.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('status', 'User deleted.');
    }

    /**
     * Pending teachers
     */
    public function pendingTeachers()
    {
        // paginate so admin doesn't have a huge list at once
        $pending = User::with('teacherProfile')
                        ->where('role', 'teacher')
                        ->where('is_teacher_approved', false)
                        ->latest()
                        ->paginate(15);

        $all = User::with('teacherProfile')
                   ->where('role', 'teacher')
                   ->latest()
                   ->paginate(25);

        return view('admin.pending-teachers', compact('pending', 'all'));
    }

    /**
     * Approve teacher
     */
    public function approveTeacher($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->is_teacher_approved = true;
        $teacher->save();

        // clean up any pending‑approval notifications so they do not linger
        $teacher->notifications()
            ->where('data->type', 'teacher_pending')
            ->delete();

        // notify teacher of approval
        $teacher->notify(new \App\Notifications\TeacherApproved());

        return back()->with('success', 'Teacher approved.');
    }

    public function rejectTeacher($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->is_teacher_approved = false;
        $teacher->save();

        // optionally send notification or simply rollback approval
        return back()->with('success', 'Teacher unapproved.');
    }

    /**
     * Skills
     */
    public function skills()
    {
        $skills = Skill::latest()->paginate(15);
        return view('admin.skills', compact('skills'));
    }

    /**
     * Delete skill
     */
    public function deleteSkill($id)
    {
        Skill::findOrFail($id)->delete();
        return back()->with('success', 'Skill deleted.');
    }

    /**
     * Subscriptions
     */
    public function subscriptions()
    {
        $subs = PremiumMembership::latest()->paginate(15);
        $revenue = PremiumMembership::where('status', 'active')->sum('price');
        return view('admin.subscriptions', compact('subs', 'revenue'));
    }

    public function cancelSubscription($id)
    {
        $sub = PremiumMembership::findOrFail($id);
        $sub->update(['status' => 'cancelled']);
        return back()->with('status', 'Subscription cancelled.');
    }

    /**
     * Feedbacks
     */
    public function feedbacks()
    {
        $feedbacks = Feedback::latest()->paginate(15);
        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function deleteFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return back()->with('status', 'Feedback deleted.');
    }

    /**
     * Session Requests
     */
    public function requests()
    {
        $requests = RequestModel::with(['requester', 'responder'])->latest()->paginate(15);
        return view('admin.requests', compact('requests'));
    }

    public function updateRequestStatus(\Illuminate\Http\Request $request, $id)
    {
        $req = RequestModel::findOrFail($id);
        $req->status = $request->status;
        $req->save();

        return back()->with('status', 'Request status updated.');
    }
}
