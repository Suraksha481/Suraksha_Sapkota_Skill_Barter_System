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
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isTeacher()) {
            return $next($request);
        }

        return redirect()->route('dashboard')
            ->with('error', 'You need Teacher role to access this page.');
    }
}
