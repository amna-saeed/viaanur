<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    public function edit(): View
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.settings.edit', compact('admin'));
    }

    public function update(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($admin->id),
            ],
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'password.min' => 'The new password must be at least 8 characters.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ]);

        $emailChanged = $validated['email'] !== $admin->email;
        $passwordChanging = filled($validated['password'] ?? null);

        if ($emailChanged || $passwordChanging) {
            $request->validate([
                'current_password' => ['required', 'string'],
            ], [
                'current_password.required' => 'Enter your current password to change email or password.',
            ]);

            if (! Hash::check($request->input('current_password'), $admin->password)) {
                return back()
                    ->withInput($request->except('password', 'password_confirmation', 'current_password'))
                    ->withErrors(['current_password' => 'The current password is incorrect.']);
            }
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($passwordChanging) {
            $data['password'] = Hash::make($validated['password']);
        }

        User::query()
            ->whereKey($admin->id)
            ->where('role', User::ROLE_ADMIN)
            ->update($data);

        $admin = $admin->fresh();
        Auth::guard('admin')->setUser($admin);

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', $passwordChanging
                ? 'Your account settings and password were updated successfully.'
                : 'Your account settings were updated successfully.');
    }
}
