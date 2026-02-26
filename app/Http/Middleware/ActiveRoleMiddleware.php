<?php

namespace App\Http\Middleware;

use App\Helpers\MenuHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $requiredRole): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $activeRole = MenuHelper::getActiveRole();

        // If user has both roles, check active role
        if ($user->hasRole('teacher') && $user->hasRole('student')) {
            // If no active role is set, default to the required role for this route
            if (!$activeRole) {
                session(['active_role' => $requiredRole]);
                return $next($request);
            }

            // Check if active role matches the required role for this route
            if ($activeRole !== $requiredRole) {
                // Redirect to the appropriate dashboard based on active role
                if ($activeRole === 'teacher') {
                    return redirect()->route('teacher.index')
                        ->with('error', 'You are currently in Teacher mode. Switch to Student mode to access this page.');
                } else {
                    return redirect()->route('student.index')
                        ->with('error', 'You are currently in Student mode. Switch to Teacher mode to access this page.');
                }
            }
        }

        // User doesn't have both roles, just check they have the required role
        if (!$user->hasRole($requiredRole) && !$user->hasRole('admin')) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
