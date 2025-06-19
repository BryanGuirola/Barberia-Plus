<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;// se necesita importar para que funcione Auth

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            $role = Auth::user()->role;
            switch ($role) {
                case 'administrador':
                    return redirect('/admin/dashboard');
                case 'encargado':
                    return redirect('/personal/dashboard');
                case 'cliente':
                    return redirect('/cliente/dashboard');
            }
        }


        return $next($request);
    }
}
