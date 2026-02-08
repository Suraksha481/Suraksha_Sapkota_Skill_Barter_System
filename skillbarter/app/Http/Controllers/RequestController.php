<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\User;

class RequestController extends Controller
{
    // Send barter request
    public function sendRequest(Request $request)
    {
        RequestModel::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'skill_offered' => $request->skill_offered,
            'skill_requested' => $request->skill_requested,
            'status' => 'pending',
            'note' => $request->note
        ]);

        return redirect()->back()->with('success', 'Request sent successfully!');
    }

    // Accept request and schedule session
    public function acceptRequest($id)
    {
        $requestModel = RequestModel::findOrFail($id);
        $requestModel->status = 'accepted';
        $requestModel->save();

        return redirect()->back()->with('success', 'Request accepted!');
    }
}
