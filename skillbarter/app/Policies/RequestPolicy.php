<?php

namespace App\Policies;

use App\Models\RequestModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RequestModel  $requestModel
     * @return bool
     */
    public function view(User $user, RequestModel $requestModel)
    {
        return $user->id === $requestModel->requester_id || $user->id === $requestModel->responder_id;
    }

    /**
     * Determine whether the user can update the request (accept/decline).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RequestModel  $requestModel
     * @return bool
     */
    public function update(User $user, RequestModel $requestModel)
    {
        return $user->id === $requestModel->responder_id;
    }
}
