<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentRole
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
{
    $user = auth()->user();

    if (!$user->isStudent()) {
        abort(403);
    }

    if (!$user->is_active) {
        abort(403, 'Account disabled.');
    }

    return $next($request);
}
}
