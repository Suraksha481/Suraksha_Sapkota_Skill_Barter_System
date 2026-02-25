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
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        $admin = auth('admin')->user();
        if (! $admin) {
            abort(403);
        }

        $stats = [
            'users' => User::count(),
            'teachers' => User::where('role','teacher')->count(),
            'students' => User::where('role','student')->count(),
            'requests' => RequestModel::count(),
            'messages' => Message::count(),
            'skills' => \App\Models\Skill::count(),
            'premium_members' => \App\Models\PremiumMembership::where('status','active')->count(),
            'revenue' => \App\Models\PremiumMembership::where('status','active')->sum('price'),
        ];

        // Load recent items for management panels on the single admin dashboard
        $recentUsers = User::latest()->take(12)->get();
        $recentSkills = \App\Models\Skill::latest()->take(12)->get();
        $recentRequests = RequestModel::latest()->take(12)->get();
        $recentFeedbacks = \App\Models\Feedback::latest()->take(12)->get();
        $recentSubscriptions = \App\Models\PremiumMembership::latest()->take(12)->get();

        return view('admin.dashboard', compact('stats','recentUsers','recentSkills','recentRequests','recentFeedbacks','recentSubscriptions'));
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
        $this->authorizeAdmin();
        $request->validate(['role' => 'nullable|string|in:admin,teacher,student']);
        $user = User::findOrFail($id);
        $user->update(['role' => $request->input('role')]);
        return back()->with('status', 'User role updated.');
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

    protected function authorizeAdmin()
    {
        $user = auth()->user();
        if (! $user || ! $user->hasRole('admin')) {
            abort(403);
        }
    }
}
