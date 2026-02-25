<?php

namespace App\Http\Controllers;

use App\Models\RequestModel;
use App\Models\UserSkill;
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

    // SECURITY CHECKS
    if (!$user->canTeach()) {
        abort(403, 'You are not authorized to accept sessions.');
    }

    if ($requestModel->responder_id !== $user->id) {
        abort(403);
    }

    if ($requestModel->status !== 'pending') {
        return back()->with('error', 'Request is not pending.');
    }

    $requestModel->update([
        'status' => 'accepted'
    ]);

    return back()->with('success', 'Session accepted successfully.');
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
}
