<?php

namespace App\Support;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Multiple independent student sessions in one browser (tab per ?as=token).
 */
class StudentSessionPool
{
    public const SESSION_KEY = 'student_session_pool';

    /**
     * @return array<string, array{user_id: int, name: string, email: string}>
     */
    public function all(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public function hasAny(): bool
    {
        return $this->all() !== [];
    }

    public function add(User $user): string
    {
        $contexts = $this->all();

        foreach ($contexts as $token => $meta) {
            if ((int) $meta['user_id'] === (int) $user->id) {
                return $token;
            }
        }

        $token = Str::random(40);
        $contexts[$token] = [
            'user_id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        session([self::SESSION_KEY => $contexts]);

        return $token;
    }

    public function remove(?string $token): void
    {
        if ($token === null || $token === '') {
            return;
        }

        $contexts = $this->all();
        unset($contexts[$token]);
        session([self::SESSION_KEY => $contexts]);
    }

    public function firstToken(): ?string
    {
        $keys = array_keys($this->all());

        return $keys[0] ?? null;
    }

    public function tokenForUserId(int $userId): ?string
    {
        foreach ($this->all() as $token => $meta) {
            if ((int) $meta['user_id'] === $userId) {
                return $token;
            }
        }

        return null;
    }

    public function userForToken(?string $token): ?User
    {
        if ($token === null || $token === '') {
            return null;
        }

        $meta = $this->all()[$token] ?? null;
        if ($meta === null) {
            return null;
        }

        return Student::find($meta['user_id']);
    }

    public function importLegacyGuardSession(): ?string
    {
        if (! Auth::guard('student')->check()) {
            return null;
        }

        return $this->add(Auth::guard('student')->user());
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }
}
