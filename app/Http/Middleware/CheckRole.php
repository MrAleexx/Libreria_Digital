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
            case 'librarian':
                if (!$user->isLibrarian() && !$user->isAdmin()) {
                    abort(403, 'No tienes permisos de bibliotecario.');
                }
                break;
            case 'user':
                if (!$user->isUser()) {
                    abort(403, 'Acceso no autorizado.');
                }
                break;
            case 'staff':
                if (!$user->isStaff()) {
                    abort(403, 'No tienes permisos de staff.');
                }
                break;
        }

        return $next($request);
    }
}
