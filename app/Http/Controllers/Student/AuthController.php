<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Support\LmsAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (! Student::where('email', $credentials['email'])->exists()) {
            throw ValidationException::withMessages([
                'email' => ['You are not registered yet. Please register first to continue.'],
            ]);
        }

        if (! Auth::guard('student')->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::guard('student')->user();
        $user = LmsAuth::applyPostAuthRoleRules($user);

        if ($user->isAdmin()) {
            Auth::guard('student')->logout();

            throw ValidationException::withMessages([
                'email' => ['This account has admin access. Please sign in at the admin login page.'],
            ]);
        }

        Auth::guard('student')->setUser($user);
        LmsAuth::syncRoleToSession($request, $user);

        return redirect()->intended(route('student.dashboard'));
    }

    public function logout(Request $request)
    {
        LmsAuth::logoutGuard($request, 'student');

        return redirect()->route('student.login');
    }
}
