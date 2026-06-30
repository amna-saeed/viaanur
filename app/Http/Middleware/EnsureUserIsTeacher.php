<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsTeacher
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('teacher')->user();

        if (! $user || ! $user->isTeacher()) {
            return redirect()->route('teacher.login');
        }

        return $next($request);
    }
}
