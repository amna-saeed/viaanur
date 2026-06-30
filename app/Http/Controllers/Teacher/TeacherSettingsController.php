<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeacherSettingsController extends Controller
{
    public function edit(): View
    {
        return view('teacher.settings.edit', [
            'teacherUser' => Auth::guard('teacher')->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $teacherUser = Auth::guard('teacher')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($teacherUser->id)],
            'current_password' => ['nullable', 'required_with:password', 'current_password:teacher'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $teacherUser->name = $validated['name'];
        $teacherUser->email = $validated['email'];

        if (! empty($validated['password'])) {
            $teacherUser->password = Hash::make($validated['password']);
        }

        $teacherUser->save();

        if ($teacherUser->teacherProfile) {
            $teacherUser->teacherProfile->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
        }

        return redirect()
            ->route('teacher.settings.edit')
            ->with('success', 'Your account settings have been updated.');
    }
}
