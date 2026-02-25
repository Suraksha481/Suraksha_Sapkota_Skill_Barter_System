<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RequestModel;
use App\Models\Message;

class AdminController extends Controller
{
    public function __construct()
    {
        // Use admin middleware (checks admin guard). Route group also applies this,
        // but adding here ensures controller actions require admin auth.
        $this->middleware(['admin']);
    }

    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => \App\Models\User::count(),
            'totalTeachers' => \App\Models\User::where('role','teacher')->count(),
            'totalStudents' => \App\Models\User::where('role','student')->count(),
            'totalSessions' => \App\Models\RequestModel::count(),
            'totalPremium' => \App\Models\PremiumMembership::where('status','active')->count(),
        ]);
    }

    public function users()
    {
        $this->authorizeAdmin();
        $users = User::orderBy('created_at','desc')->paginate(25);
        return view('admin.users', compact('users'));
    }

    public function toggleUserActive($id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        $user->update(['is_active' => ! $user->is_active]);
        return back()->with('status', 'User status updated.');
    }

   public function changeRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:student,teacher,admin'
        ]);

        $user = User::findOrFail($id);

        $user->role = $request->role;

        if ($request->role !== 'teacher') {
        $user->is_teacher_approved = false;
        }

        $user->save();

        return back()->with('success','Role updated successfully.');
    }

    public function destroyUser($id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('status', 'User deleted.');
    }

    public function skills()
    {
        $this->authorizeAdmin();
        $skills = \App\Models\Skill::latest()->paginate(25);
        return view('admin.skills', compact('skills'));
    }

    public function destroySkill($id)
    {
        $this->authorizeAdmin();
        $skill = \App\Models\Skill::findOrFail($id);
        $skill->delete();
        return back()->with('status', 'Skill deleted.');
    }

    public function requests()
    {
        $this->authorizeAdmin();
        $requests = RequestModel::latest()->paginate(25);
        return view('admin.requests', compact('requests'));
    }

    public function updateRequestStatus(Request $request, $id)
    {
        $this->authorizeAdmin();
        $request->validate(['status' => 'required|string|in:pending,accepted,declined,completed,cancelled']);
        $r = RequestModel::findOrFail($id);
        $r->update(['status' => $request->input('status')]);
        return back()->with('status', 'Request updated.');
    }

    public function feedbacks()
    {
        $this->authorizeAdmin();
        $feedbacks = \App\Models\Feedback::latest()->paginate(25);
        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function destroyFeedback($id)
    {
        $this->authorizeAdmin();
        $f = \App\Models\Feedback::findOrFail($id);
        $f->delete();
        return back()->with('status', 'Feedback deleted.');
    }

    public function subscriptions()
    {
        $this->authorizeAdmin();
        $subs = \App\Models\PremiumMembership::latest()->paginate(25);
        $revenue = \App\Models\PremiumMembership::where('status','active')->sum('price');
        return view('admin.subscriptions', compact('subs','revenue'));
    }

    public function cancelSubscription($id)
    {
        $this->authorizeAdmin();
        $s = \App\Models\PremiumMembership::findOrFail($id);
        $s->update(['status' => 'cancelled']);
        return back()->with('status', 'Subscription cancelled.');
    }

    // Teacher administration: pending, approved, approve/reject actions
    public function pendingTeachers()
    {
        $this->authorizeAdmin();
        $teachers = User::where('role', 'teacher')
            ->where(function ($q) {
                $q->whereNull('is_approved_teacher')->orWhere('is_approved_teacher', false);
            })
            ->latest()
            ->paginate(25);

        return view('admin.teachers', ['teachers' => $teachers, 'title' => 'Pending Teachers']);
    }

    public function approvedTeachers()
    {
        $this->authorizeAdmin();
        $teachers = User::where('role', 'teacher')
            ->where('is_approved_teacher', true)
            ->latest()
            ->paginate(25);

        return view('admin.teachers', ['teachers' => $teachers, 'title' => 'Approved Teachers']);
    }

    public function allTeachers()
    {
        $this->authorizeAdmin();
        $teachers = User::where('role', 'teacher')->latest()->paginate(25);
        return view('admin.teachers', ['teachers' => $teachers, 'title' => 'All Teachers']);
    }

   public function approveTeacher($id)
    {
        $user = User::findOrFail($id);

        if (!$user->isTeacher()) {
            abort(400);
        }

        $user->update([
            'is_teacher_approved' => true
        ]);

    return back()->with('success', 'Teacher approved successfully.');
}

   public function rejectTeacher($id)
{
    $user = User::findOrFail($id);

    if (!$user->isTeacher()) {
        abort(400);
    }

    $user->update([
        'is_teacher_approved' => false
    ]);

    return back()->with('success', 'Teacher rejected successfully.');
}

    protected function authorizeAdmin()
    {
        // Only allow access when authenticated via the admin guard (admins are separate)
        if (! auth('admin')->check()) {
            abort(403);
        }
    }
}
