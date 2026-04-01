<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\RequestModel;
use App\Models\PremiumMembership;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // Revenue Stats
        $totalRevenue = \App\Models\Transaction::sum('amount');
        $adminShare = \App\Models\Transaction::sum('admin_share');
        $teacherShare = \App\Models\Transaction::sum('teacher_share');

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalTeachers' => $totalTeachers,
            'totalStudents' => $totalStudents,
            'totalSkills' => $totalSkills,
            'totalRequests' => $totalRequests,
            'totalSessions' => $totalSessions,
            'totalPremium' => $totalPremium,
            'totalFeedbacks' => $totalFeedbacks,
            'totalRevenue' => $totalRevenue,
            'adminShare' => $adminShare,
            'teacherShare' => $teacherShare,
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
     * Show detailed user profile
     */
    public function showUser($id)
    {
        $user = User::with(['teacherProfile', 'studentProfile', 'skillsOffered.skill', 'skillsWanted.skill'])->findOrFail($id);
        return view('admin.user-show', compact('user'));
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
     * Store a new skill (with optional image upload)
     */
    public function storeSkill(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:4096',
        ]);

        $data = $request->only(['title', 'description', 'category']);
        $data['slug'] = \Illuminate\Support\Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/skills', 'public');
            $data['image'] = 'storage/' . $path;
        }

        Skill::create($data);

        return back()->with('success', 'Skill "' . $data['title'] . '" added successfully.');
    }

    /**
     * Update a skill's image
     */
    public function updateSkill(Request $request, $id)
    {
        $request->validate(['image' => 'required|image|max:4096']);

        $skill = Skill::findOrFail($id);

        $path = $request->file('image')->store('images/skills', 'public');
        $skill->update(['image' => 'storage/' . $path]);

        return back()->with('success', 'Image updated for "' . $skill->title . '".');
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
        $subs = PremiumMembership::with('user')->latest()->paginate(15);
        $revenue = 0;
        
        // Handle missing column gracefully during migration transition
        if (\Illuminate\Support\Facades\Schema::hasColumn('premium_memberships', 'price')) {
            $revenue = PremiumMembership::where('status', 'active')->sum('price');
        }
        
        return view('admin.subscriptions', compact('subs', 'revenue'));
    }

    /**
     * Payouts management
     */
    public function payouts()
    {
        $transactions = \App\Models\Transaction::with(['student', 'teacher'])->latest()->paginate(15);
        return view('admin.payouts', compact('transactions'));
    }

    public function markPayoutPaid($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->update(['status' => 'paid_to_teacher']);
        return back()->with('success', 'Payout marked as paid to teacher.');
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

    /**
     * Services management
     */
    public function services()
    {
        $services = \App\Models\Service::latest()->paginate(10);
        return view('admin.services', compact('services'));
    }

    public function storeService(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
        ]);

        \App\Models\Service::create($request->only(['title', 'description', 'category']));

        return back()->with('success', 'Service added successfully.');
    }

    public function deleteService($id)
    {
        \App\Models\Service::findOrFail($id)->delete();
        return back()->with('success', 'Service deleted successfully.');
    }

    // ── DISPUTE MANAGEMENT ──────────────────────────────────────────────────

    public function disputes()
    {
        $disputes = \App\Models\Dispute::with(['filer', 'sessionRequest.requester', 'sessionRequest.responder'])
            ->latest()
            ->paginate(20);

        return view('admin.disputes', compact('disputes'));
    }

    public function resolveDispute(\Illuminate\Http\Request $request, $id)
    {
        $dispute = \App\Models\Dispute::findOrFail($id);
        $action  = $request->input('action'); // 'refund' or 'dismiss'

        if ($action === 'refund') {
            $dispute->update([
                'status'      => 'resolved_refunded',
                'admin_notes' => $request->input('admin_notes'),
            ]);
            // Optionally cancel the session
            if ($dispute->sessionRequest) {
                $dispute->sessionRequest->update(['status' => 'cancelled']);
            }
            return back()->with('success', 'Dispute resolved: session cancelled and marked as refunded.');
        }

        $dispute->update([
            'status'      => 'resolved_dismissed',
            'admin_notes' => $request->input('admin_notes'),
        ]);
        return back()->with('success', 'Dispute dismissed.');
    }
}

