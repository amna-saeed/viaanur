<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoteConfiguredAdmin
{
    /**
     * Admin-only site: everyone is admin; student dashboard URL redirects to admin.
     * Or: promote users whose email is in ADMIN_EMAILS.
     *
     * Only evaluates the guard that matches the current route area so admin
     * sessions never affect public/student auth checks.
     */
    public function handle(Request $request, Closure $next)
    {
        $guard = $this->guardForRequest($request);

        if ($guard === null || ! Auth::guard($guard)->check()) {
            return $next($request);
        }

        $user = Auth::guard($guard)->user();

        if (config('viaanoor.admin_only_mode')) {
            if (! $user->isAdmin()) {
                $user->update(['role' => User::ROLE_ADMIN]);
                Auth::guard($guard)->setUser($user->fresh());
            }
            if ($request->routeIs('student.dashboard')) {
                return redirect()->route('admin.dashboard');
            }

            return $next($request);
        }

        if ($user->promoteIfConfiguredAdminEmail()) {
            Auth::guard($guard)->setUser($user->fresh());
            if ($request->routeIs('student.dashboard')) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }

    private function guardForRequest(Request $request): ?string
    {
        if ($request->is('student/*') || $request->routeIs('student.*')) {
            return 'student';
        }

        if ($request->is('admin/*') || $request->routeIs('admin.*')) {
            return 'admin';
        }

        if (Auth::guard('web')->check()) {
            return 'web';
        }

        return null;
    }
}
