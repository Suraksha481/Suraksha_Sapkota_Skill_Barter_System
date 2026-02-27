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
            // allow access to the dashboard itself but show a simple notice
            if ($request->routeIs('teacher.dashboard')) {
                return response()->view('teacher.pending');
            }

            return redirect()->route('home')
                ->with('error', 'Your teacher account is pending admin approval.');
        }

        if (!$user->is_active) {
            abort(403, 'Your account has been disabled.');
        }

        return $next($request);
    }
}
