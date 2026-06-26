<?php

use App\Support\StudentRoute;

if (! function_exists('student_route_params')) {
    function student_route_params(?string $token = null): array
    {
        return StudentRoute::params($token);
    }
}

if (! function_exists('student_redirect')) {
    function student_redirect(string $route, array $parameters = [], int $status = 302)
    {
        return StudentRoute::redirect($route, $parameters, $status);
    }
}
