<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * Switch the active role for users with multiple roles
     */
    public function switchRole(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'role' => 'required|string|in:teacher,student'
        ]);

        $user = auth()->user();
        $role = $validated['role'];

        // Check if user has the requested role
        if (!$user->hasRole($role)) {
            return response()->json([
                'success' => false,
                'message' => 'User does not have the requested role'
            ], 403);
        }

        // Store the active role in session
        session(['active_role' => $role]);

        return response()->json([
            'success' => true,
            'role' => $role,
            'message' => 'Role switched successfully'
        ]);
    }

    /**
     * Get the current active role
     */
    public function getActiveRole(): JsonResponse
    {
        $user = auth()->user();

        // Get active role from session, or default to user's first available role
        $activeRole = session('active_role');

        // Validate that the user still has this role
        if ($activeRole && !$user->hasRole($activeRole)) {
            $activeRole = null;
            session()->forget('active_role');
        }

        // Auto-detect role if not set
        if (!$activeRole) {
            if ($user->hasRole('teacher')) {
                $activeRole = 'teacher';
            } elseif ($user->hasRole('student')) {
                $activeRole = 'student';
            }
        }

        return response()->json([
            'active_role' => $activeRole,
            'has_teacher_role' => $user->hasRole('teacher'),
            'has_student_role' => $user->hasRole('student'),
            'has_both_roles' => $user->hasRole('teacher') && $user->hasRole('student')
        ]);
    }
}
