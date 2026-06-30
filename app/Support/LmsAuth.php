<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Single place for LMS role-based auth after login/register (no duplicate redirect logic).
 */
class LmsAuth
{
    /**
     * Optional env overrides: admin-only site, ADMIN_EMAILS promotion.
     */
    public static function applyPostAuthRoleRules(User $user): User
    {
        if (config('viaanoor.admin_only_mode')) {
            if (! $user->isAdmin()) {
                $user->update(['role' => User::ROLE_ADMIN]);
            }
            return $user->fresh();
        }

        $user->promoteIfConfiguredAdminEmail();

        return $user->fresh();
    }

    public static function dashboardRouteName(User $user): string
    {
        if ($user->isAdmin()) {
            return 'admin.dashboard';
        }

        if ($user->isTeacher()) {
            return 'teacher.dashboard';
        }

        return 'student.dashboard';
    }

    public static function syncRoleToSession(Request $request, User $user, string $guard): void
    {
        $request->session()->put("auth.role.{$guard}", $user->role);
    }

    /**
     * Log out one guard without destroying sessions for other guards.
     */
    public static function logoutGuard(Request $request, string $guard): void
    {
        Auth::guard($guard)->logout();
        $request->session()->forget("auth.role.{$guard}");

        $otherGuardsStillLoggedIn = collect(['admin', 'student', 'teacher'])
            ->reject(fn (string $name) => $name === $guard)
            ->contains(fn (string $name) => Auth::guard($name)->check());

        if (! $otherGuardsStillLoggedIn) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}
