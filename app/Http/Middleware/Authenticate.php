<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * The guard names from the current middleware invocation.
     *
     * @var array<int, string>
     */
    protected $guards = [];

    public function handle($request, \Closure $next, ...$guards)
    {
        $this->guards = $guards;

        return parent::handle($request, $next, ...$guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        if (in_array('admin', $this->guards, true)) {
            return route('admin.login');
        }

        if (in_array('student', $this->guards, true)) {
            return route('student.login');
        }

        if (in_array('teacher', $this->guards, true)) {
            return route('teacher.login');
        }

        return route('login');
    }
}
