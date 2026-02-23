<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Channel for chat related to a specific request (only participants may listen)
Broadcast::channel('request.{requestId}', function ($user, $requestId) {
    // Minimal check: user must be participant (requester or responder)
    $request = \App\Models\RequestModel::find($requestId);
    if (! $request) return false;
    return (int)$user->id === (int)$request->requester_id || (int)$user->id === (int)$request->responder_id;
});
