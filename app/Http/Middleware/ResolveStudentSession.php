<?php

namespace App\Http\Middleware;

use App\Support\StudentSessionPool;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class ResolveStudentSession
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->routeIs('student.login', 'student.login.submit')) {
            return $next($request);
        }

        $pool = app(StudentSessionPool::class);

        if (! $pool->hasAny()) {
            $pool->importLegacyGuardSession();
        }

        $token = $request->route('studentContext');

        if (($token === null || $token === '') && $request->query('as')) {
            $legacyToken = $request->query('as');
            $legacyName = $request->route()->getName();

            if ($legacyName && strpos($legacyName, 'student.') === 0) {
                return redirect()->route($legacyName, array_merge(
                    ['studentContext' => $legacyToken],
                    collect($request->route()->parameters())->except('studentContext')->all()
                ));
            }
        }

        if ($token === null || $token === '') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('student.login');
        }

        $user = $pool->userForToken($token);

        if ($user === null) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()
                ->route('student.login')
                ->with('error', 'This student session expired. Please sign in again.');
        }

        Auth::guard('student')->setUser($user);
        $request->attributes->set('student_session_token', $token);
        URL::defaults(['studentContext' => $token]);

        view()->share('studentSessionToken', $token);
        view()->share('studentSessionAccounts', $pool->all());

        return $next($request);
    }
}
