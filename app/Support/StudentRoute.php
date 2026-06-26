<?php

namespace App\Support;

class StudentRoute
{
    /**
     * @return array<string, string>
     */
    public static function params(?string $token = null): array
    {
        if ($token !== null && $token !== '') {
            return ['studentContext' => $token];
        }

        $token = request()->route('studentContext')
            ?? request()->attributes->get('student_session_token');

        return ($token !== null && $token !== '') ? ['studentContext' => $token] : [];
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    public static function redirect(string $route, array $parameters = [], int $status = 302)
    {
        return redirect()->route($route, array_merge(static::params(), $parameters), $status);
    }
}
