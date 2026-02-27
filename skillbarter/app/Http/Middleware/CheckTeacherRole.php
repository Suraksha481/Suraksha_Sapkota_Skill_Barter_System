<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTeacherRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        if (!$user->isTeacher()) {
            abort(403, 'Access denied.');
        }

        if (!$user->is_teacher_approved) {
            return redirect()->route('home')
                ->with('error', 'Your teacher account is pending admin approval.');
        }

        if (!$user->is_active) {
            abort(403, 'Your account has been disabled.');
        }

        return $next($request);
    }
}
