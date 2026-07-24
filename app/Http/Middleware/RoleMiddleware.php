<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthenticated');
        }

        $userTypeId = auth()->user()->user_type_id;

        $allowed = array_map('intval', $roles);

        if (!in_array($userTypeId, $allowed)) {
            abort(403, 'Unauthorized. Required role: ' . implode(', ', $roles));
        }

        return $next($request);
    }
}
