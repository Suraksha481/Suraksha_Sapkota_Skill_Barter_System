<?php

namespace App\Http\Controllers;

use App\Models\RequestModel;
use App\Models\UserSkill;
use App\Models\SessionModel;
use App\Models\SessionMaterial;
use App\Models\SessionAssignment;
use App\Services\GamificationService;
use Illuminate\Http\Request;

class SessionRequestController extends Controller
{
    protected $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        // Default tab depends on user role: teachers see received by default, students see sent
        $tab = $request->get('tab', $user->isTeacher() ? 'received' : 'sent');

        // Ensure non-teachers cannot view the received tab
        if (! $user->isTeacher() && $tab === 'received') {
            $tab = 'sent';
        }

        $received = RequestModel::where('responder_id', $user->id)
            ->with(['requester', 'userSkill.skill'])
            ->latest()
            ->get();

        $sent = RequestModel::where('requester_id', $user->id)
            ->with(['responder', 'userSkill.skill'])
            ->latest()
            ->get();

        return view('requests.index', compact('received', 'sent', 'tab'));
    }

    public function create(UserSkill $userSkill)
    {
        $userSkill->load(['user', 'skill']);

        if ($userSkill->user_id === auth()->id()) {
            return back()->with('error', 'You cannot request your own skill.');
        }

        return view('requests.create', compact('userSkill'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_skill_id' => 'required|exists:user_skills,id',
            'message' => 'nullable|string|max:1000',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $userSkill = UserSkill::findOrFail($request->user_skill_id);
        $user = $request->user();

        if ($userSkill->user_id === $user->id) {
            return back()->with('error', 'You cannot request your own skill.');
        }

        // Limit checking logic
        $requestsThisMonth = RequestModel::where('requester_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $limit = 1;
        $membership = $user->premiumMembership()->where('status', 'active')->first();
        if ($membership) {
            $limit = $membership->plan === 'monthly' ? 3 : 5;
        }

        if ($requestsThisMonth >= $limit) {
            $upgradeUrl = route('premium.index', ['ref' => $userSkill->user_id]);
            $upgradeMsg = $membership 
                ? "You have reached your premium limit of {$limit} requests per month." 
                : "Free users can only make 1 request per month. <a href=\"{$upgradeUrl}\" style=\"color:blue; text-decoration:underline;\">Upgrade to Premium</a> for more!";
            return back()->with('error', $upgradeMsg);
        }

        $existingRequest = RequestModel::where('requester_id', $user->id)
            ->where('user_skill_id', $request->user_skill_id)
            ->whereIn('status', ['open', 'accepted', 'in_progress'])
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You already have a pending request for this skill.');
        }

        $requestModel = RequestModel::create([
            'requester_id' => $user->id,
            'responder_id' => $userSkill->user_id,
            'user_skill_id' => $request->user_skill_id,
            'message' => $request->message,
            'status' => 'open',
            'scheduled_at' => $request->scheduled_at,
        ]);

        // Notify the teacher (responder)
        try {
            $userSkill->user->notify(new \App\Notifications\RequestReceived($requestModel));
        } catch (\Throwable $e) {
            // swallow notification errors so request creation is not blocked
        }

        return redirect()->route('requests.index', ['tab' => 'sent'])
            ->with('success', 'Request sent successfully!');
    }

    public function accept($requestModelId)
    {
        $requestModel = RequestModel::findOrFail($requestModelId);
        $user = auth()->user();

        if ($requestModel->responder_id !== $user->id) {
            abort(403, 'You are not authorized to accept this request.');
        }

        if (! in_array($requestModel->status, ['open', 'pending'])) {
            return back()->with('error', 'Request is not pending or open.');
        }

        $requestModel->update([
            'status' => 'accepted'
        ]);

        // notify requester about acceptance
        try {
            $requestModel->requester->notify(new \App\Notifications\RequestAccepted($requestModel));
        } catch (\Throwable $e) {
            // ignore
        }

        return back()->with('success', 'Request accepted! Now you can schedule the session.');
    }

    public function schedule(Request $request, RequestModel $requestModel)
    {
        if ($requestModel->responder_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'start_time' => 'required|date|after:now',
            'meeting_link' => 'nullable|url',
        ]);

        // Create or Update Session
        $session = SessionModel::updateOrCreate(
            ['request_id' => $requestModel->id],
            [
                'organiser_id' => $requestModel->responder_id,
                'participant_id' => $requestModel->requester_id,
                'skill_id' => $requestModel->userSkill->skill_id,
                'start_time' => $request->start_time,
                'status' => 'scheduled',
                'meeting_link' => $request->meeting_link
            ]
        );

        $requestModel->update(['status' => 'scheduled']);

        return back()->with('success', 'Session scheduled successfully.');
    }

    public function decline(RequestModel $requestModel)
    {
        if ($requestModel->responder_id !== auth()->id()) {
            abort(403);
        }

        $requestModel->update(['status' => 'declined']);

        // Notify requester that their request was declined
        try {
            $requestModel->requester->notify(new \App\Notifications\RequestDeclined($requestModel));
        } catch (\Throwable $e) {
            // ignore notification errors
        }

        return back()->with('success', 'Request declined.');
    }

    public function complete(RequestModel $requestModel)
    {
        if ($requestModel->responder_id !== auth()->id() && $requestModel->requester_id !== auth()->id()) {
            abort(403);
        }

        $requestModel->update(['status' => 'completed']);

        $this->gamificationService->addPoints(
            $requestModel->responder,
            GamificationService::POINTS_COMPLETE_SESSION,
            'Completed a teaching session'
        );

        $this->gamificationService->addPoints(
            $requestModel->requester,
            GamificationService::POINTS_COMPLETE_SESSION / 2,
            'Completed a learning session'
        );

        $this->gamificationService->checkAndAwardBadges($requestModel->responder);
        $this->gamificationService->checkAndAwardBadges($requestModel->requester);

        return redirect()->route('feedback.create', ['request' => $requestModel->id])
            ->with('success', 'Session marked as complete! Please leave feedback.');
    }

    public function cancel(RequestModel $requestModel)
    {
        if ($requestModel->requester_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($requestModel->status, ['open', 'accepted'])) {
            return back()->with('error', 'Cannot cancel this request.');
        }

        $requestModel->update(['status' => 'cancelled']);

        return back()->with('success', 'Request cancelled.');
    }

    public function show(RequestModel $requestModel)
    {
        $requestModel->load(['requester', 'responder', 'userSkill.skill', 'userSkill.user']);

        return view('requests.show', ['requestModel' => $requestModel]);
    }

    public function classroom($id)
    {

        $session = SessionModel::with(['teacher','student','materials','assignments'])->findOrFail($id);

        return view('sessions.classroom',compact('session'));

    }

    public function updateLink(Request $request, SessionModel $session)
    {
        if ($session->organiser_id !== auth()->id()) abort(403);
        $request->validate(['meeting_link' => 'required|url']);
        $session->update(['meeting_link' => $request->meeting_link]);
        return back()->with('success', 'Meeting link updated successfully.');
    }

    public function uploadMaterial(Request $request, SessionModel $session)
    {
        if ($session->organiser_id !== auth()->id()) abort(403);
        $request->validate(['title' => 'required|string', 'file' => 'required|file|max:10240']);
        
        $path = $request->file('file')->store('materials', 'public');
        
        SessionMaterial::create([
            'session_id' => $session->id,
            'title' => $request->title,
            'file_path' => $path,
            'file_url' => asset('storage/' . $path)
        ]);
        return back()->with('success', 'Material uploaded.');
    }

    public function submitPractice(Request $request, SessionModel $session)
    {
        if ($session->participant_id !== auth()->id()) abort(403);
        $request->validate(['title' => 'required|string', 'file' => 'nullable|file|max:10240', 'details' => 'nullable|string']);
        
        $path = $request->hasFile('file') ? $request->file('file')->store('assignments', 'public') : null;
        $url = $path ? asset('storage/' . $path) : null;
        
        SessionAssignment::create([
            'session_id' => $session->id,
            'student_id' => auth()->id(),
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $path,
            'file_url' => $url
        ]);
        return back()->with('success', 'Practice submitted.');
    }

    public function completeSession(SessionModel $session)
    {
        if ($session->organiser_id !== auth()->id()) abort(403);
        $session->update(['status' => 'completed']);
        
        // Find the associated request using the new request_id or fallback to ids
        $requestModel = $session->request ?? RequestModel::where('requester_id', $session->participant_id)
            ->where('responder_id', $session->organiser_id)
            ->whereIn('status', ['accepted', 'scheduled'])
            ->first();
            
        if($requestModel) {
            return $this->complete($requestModel);
        }
        
        return back()->with('success', 'Session completed.');
    }

    public function sessions(Request $request)
    {
        $user = $request->user();
        
        $teachingSessions = SessionModel::where('organiser_id', $user->id)
            ->with(['student', 'skill'])
            ->latest()
            ->get();
            
        $learningSessions = SessionModel::where('participant_id', $user->id)
            ->with(['teacher', 'skill'])
            ->latest()
            ->get();
            
        return view('sessions.index', [
            'teachingSessions' => $teachingSessions,
            'learningSessions' => $learningSessions
        ]);
    }

    public function toggleLive(SessionModel $session)
    {
        $user = auth()->user();
        if ($session->organiser_id !== $user->id) {
            abort(403);
        }

        $session->update([
            'is_live' => !$session->is_live
        ]);

        $status = $session->is_live ? 'Live session started!' : 'Live session stopped.';
        return back()->with('success', $status);
    }
}
