<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Support\LmsAuth;
use App\Support\StudentRoute;
use App\Support\StudentSessionPool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', [
            'loginAction' => route('student.login'),
            'pageHeading' => 'Student sign in',
            'showRegisterLink' => true,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $student = Student::where('email', $credentials['email'])->first();

        if ($student === null) {
            throw ValidationException::withMessages([
                'email' => ['You are not registered yet. Please register first to continue.'],
            ]);
        }

        if (! Hash::check($credentials['password'], $student->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $user = LmsAuth::applyPostAuthRoleRules($student);

        if ($user->isAdmin()) {
            throw ValidationException::withMessages([
                'email' => ['This account has admin access. Please sign in at the admin login page.'],
            ]);
        }

        $pool = app(StudentSessionPool::class);
        $token = $pool->add($user);

        Auth::guard('student')->login($user, $request->boolean('remember'));
        LmsAuth::syncRoleToSession($request, $user, 'student');
        $request->session()->put('student_active_context', $token);

        return redirect()->intended(route('student.dashboard', StudentRoute::params($token)));
    }

    public function logout(Request $request)
    {
        $pool = app(StudentSessionPool::class);
        $token = $request->route('studentContext')
            ?? $request->input('as')
            ?? $request->session()->get('student_active_context');

        $pool->remove($token);
        Auth::guard('student')->logout();
        $request->session()->forget('auth.role.student');
        $request->session()->forget('student_active_context');

        if ($pool->hasAny()) {
            $nextToken = $pool->firstToken();

            return redirect()->route('student.dashboard', StudentRoute::params($nextToken));
        }

        if (! Auth::guard('admin')->check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('student.login');
    }
}
