<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\RequestModel;
use App\Services\GamificationService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    protected $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $receivedFeedback = Feedback::where('target_type', 'user')
            ->where('target_id', $user->id)
            ->with('author')
            ->latest()
            ->get();

        $givenFeedback = Feedback::where('author_id', $user->id)
            ->latest()
            ->get();

        $averageRating = $receivedFeedback->avg('rating');
        $totalReviews = $receivedFeedback->count();

        return view('feedback.index', compact('receivedFeedback', 'givenFeedback', 'averageRating', 'totalReviews'));
    }

    public function create(Request $request)
    {
        $requestId = $request->get('request');
        $sessionRequest = null;
        $targetUser = null;

        if ($requestId) {
            $sessionRequest = RequestModel::with(['requester', 'responder', 'userSkill.skill'])
                ->findOrFail($requestId);

            $user = $request->user();
            if ($sessionRequest->requester_id === $user->id) {
                $targetUser = $sessionRequest->responder;
            } else {
                $targetUser = $sessionRequest->requester;
            }
        }

        return view('feedback.create', compact('sessionRequest', 'targetUser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_type' => 'required|in:user,session',
            'target_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        $existingFeedback = Feedback::where('author_id', $user->id)
            ->where('target_type', $request->target_type)
            ->where('target_id', $request->target_id)
            ->first();

        if ($existingFeedback) {
            return back()->with('error', 'You have already submitted feedback for this.');
        }

        Feedback::create([
            'author_id' => $user->id,
            'target_type' => $request->target_type,
            'target_id' => $request->target_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $this->gamificationService->addPoints(
            $user,
            GamificationService::POINTS_GIVE_FEEDBACK,
            'Gave feedback'
        );

        if ($request->rating == 5 && $request->target_type === 'user') {
            $targetUser = \App\Models\User::find($request->target_id);
            if ($targetUser) {
                $this->gamificationService->addPoints(
                    $targetUser,
                    GamificationService::POINTS_RECEIVE_5_STAR,
                    'Received 5-star rating'
                );
                $this->gamificationService->checkAndAwardBadges($targetUser);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Thank you for your feedback!');
    }
}
