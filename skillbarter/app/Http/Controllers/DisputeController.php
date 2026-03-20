<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use App\Models\RequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisputeController extends Controller
{
    /**
     * Show the dispute filing form for a specific session request.
     */
    public function create($requestId)
    {
        $sessionRequest = RequestModel::findOrFail($requestId);

        // Only the requester (student) may file a dispute
        abort_if(Auth::id() !== $sessionRequest->requester_id, 403);

        return view('disputes.create', compact('sessionRequest'));
    }

    /**
     * Store a new dispute.
     */
    public function store(Request $request, $requestId)
    {
        $sessionRequest = RequestModel::findOrFail($requestId);

        abort_if(Auth::id() !== $sessionRequest->requester_id, 403);

        $validated = $request->validate([
            'reason' => 'required|string|min:10|max:2000',
        ]);

        // Prevent duplicate open dispute
        $existing = Dispute::where('session_request_id', $requestId)
            ->where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();

        if ($existing) {
            return back()->with('error', 'You already have an open dispute for this session.');
        }

        Dispute::create([
            'session_request_id' => $requestId,
            'user_id'            => Auth::id(),
            'reason'             => $validated['reason'],
        ]);

        return redirect()->route('requests.index')
            ->with('success', 'Your dispute has been filed. Our admin team will review it shortly.');
    }
}
