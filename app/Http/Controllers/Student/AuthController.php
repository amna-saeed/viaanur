<?php

namespace App\Http\Controllers\Student;

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
            Auth::guard('admin')->login($user);
            Auth::guard('admin')->setUser($user);
            LmsAuth::syncRoleToSession($request, $user);

            return redirect()->intended(route('admin.dashboard'));
        }

        Auth::guard('student')->setUser($user);
        LmsAuth::syncRoleToSession($request, $user);

        return redirect()->intended(route('student.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }
}
