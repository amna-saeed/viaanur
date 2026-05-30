<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsStudent
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('student')->check()) {
            return $next($request);
        }

        $user = Auth::guard('student')->user();
        if ($user->role !== User::ROLE_STUDENT) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Student access only.'], 403);
            }
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
