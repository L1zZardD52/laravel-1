<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Администратор может открывать страницы для всех ролей.
        if ($user?->role?->name === 'admin') {
            return $next($request);
        }

        // Остальным разрешён доступ только при совпадении роли.
        abort_unless(
            $user && in_array($user->role?->name, $roles, true),
            403
        );

        return $next($request);
    }
}