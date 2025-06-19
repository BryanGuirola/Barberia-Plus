<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

    // Si no es cliente o no ha iniciado sesión, continuar
    if (!$user || $user->rol !== 'cliente') {
        return $next($request);
    }

    // Rutas que deben quedar accesibles incluso si debe cambiar contraseña
    $exceptRoutes = [
        'cliente.profile.password',
        'cliente.profile.password.update',
    ];

    if ($user->must_change_password && !in_array($request->route()->getName(), $exceptRoutes)) {
        return redirect()->route('cliente.profile.password');
    }

    return $next($request);
    }
}
