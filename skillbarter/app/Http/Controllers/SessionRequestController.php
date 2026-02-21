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
        $tab = $request->get('tab', 'received');

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

    public function accept(RequestModel $requestModel)
    {
        if ($requestModel->responder_id !== auth()->id()) {
            abort(403);
        }

        $requestModel->update(['status' => 'accepted']);

        // Notify requester that their request was accepted
        try {
            $requestModel->requester->notify(new \App\Notifications\RequestAccepted($requestModel));
        } catch (\Throwable $e) {
            // ignore
        }

        return back()->with('success', 'Request accepted! You can now schedule the session.');
    }

    public function decline(RequestModel $requestModel)
    {
        if ($requestModel->responder_id !== auth()->id()) {
            abort(403);
        }

        $requestModel->update(['status' => 'declined']);

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
}
