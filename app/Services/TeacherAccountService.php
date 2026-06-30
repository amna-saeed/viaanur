<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherAccountService
{
    public function createOrUpdateAccount(Teacher $teacher, array $data, ?string $password = null): User
    {
        $userData = [
            'name' => $data['name'] ?? $teacher->name,
            'email' => $data['email'] ?? $teacher->email,
            'phone' => $data['phone'] ?? $teacher->phone,
            'role' => User::ROLE_TEACHER,
        ];

        if ($password) {
            $userData['password'] = Hash::make($password);
        }

        if ($teacher->user_id) {
            $user = User::query()->findOrFail($teacher->user_id);
            $user->update($userData);

            return $user->fresh();
        }

        $user = User::query()->create(array_merge($userData, [
            'password' => Hash::make($password ?? str()->random(16)),
        ]));

        $teacher->update(['user_id' => $user->id]);

        return $user;
    }

    public function deleteAccount(Teacher $teacher): void
    {
        if (! $teacher->user_id) {
            return;
        }

        User::query()
            ->where('id', $teacher->user_id)
            ->where('role', User::ROLE_TEACHER)
            ->delete();

        $teacher->update(['user_id' => null]);
    }
}
