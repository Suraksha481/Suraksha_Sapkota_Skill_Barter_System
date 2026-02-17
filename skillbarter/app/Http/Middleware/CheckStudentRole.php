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
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isStudent()) {
            return $next($request);
        }

        return redirect()->route('dashboard')
            ->with('error', 'You need Student role to access this page.');
    }
}
