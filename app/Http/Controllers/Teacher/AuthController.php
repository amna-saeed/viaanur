<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Support\LmsAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', [
            'loginAction' => route('teacher.login'),
            'pageHeading' => 'Teacher sign in',
            'showRegisterLink' => false,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::guard('teacher')->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::guard('teacher')->user();

        if (! $user->isTeacher()) {
            Auth::guard('teacher')->logout();
            throw ValidationException::withMessages([
                'email' => ['This account is not registered as a teacher.'],
            ]);
        }

        LmsAuth::syncRoleToSession($request, $user, 'teacher');

        return redirect()->intended(route('teacher.dashboard'));
    }

    public function logout(Request $request)
    {
        LmsAuth::logoutGuard($request, 'teacher');

        return redirect()->route('teacher.login');
    }
}
