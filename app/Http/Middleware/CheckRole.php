<?php
// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        switch ($role) {
            case 'admin':
                if (!$user->isAdmin()) {
                    abort(403, 'No tienes permisos de administrador.');
                }
                break;
            case 'moderator':
                if (!$user->isModerator() && !$user->isAdmin()) {
                    abort(403, 'No tienes permisos de moderador.');
                }
                break;
            case 'user':
                if (!$user->isUser()) {
                    abort(403, 'Acceso no autorizado.');
                }
                break;
        }

        return $next($request);
    }
}
