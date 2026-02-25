<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTeacherRole
{
    /**
     * Handle an incoming request.
     */
   public function handle($request, Closure $next)
{
    $user = auth()->user();

    if (!$user->isTeacher()) {
        abort(403);
    }

    if (!$user->is_teacher_approved) {
        return redirect()->route('dashboard')
            ->with('error','Waiting for admin approval.');
    }

    if (!$user->is_active) {
        abort(403, 'Account disabled.');
    }

    return $next($request);
}
}
