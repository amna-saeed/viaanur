<?php

use Illuminate\Http\Request;

/**
 * @return array<string, string>
 */
function student_route_params(?string $token = null): array
{
    if ($token !== null && $token !== '') {
        return ['studentContext' => $token];
    }

    $token = request()->route('studentContext')
        ?? request()->attributes->get('student_session_token');

    return ($token !== null && $token !== '') ? ['studentContext' => $token] : [];
}

/**
 * Redirect to a named student route preserving the active session token.
 *
 * @param  array<string, mixed>  $parameters
 */
function student_redirect(string $route, array $parameters = [], int $status = 302)
{
    return redirect()->route($route, array_merge(student_route_params(), $parameters), $status);
}
