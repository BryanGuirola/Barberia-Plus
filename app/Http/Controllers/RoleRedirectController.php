<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RoleRedirectController extends Controller
{
    public function redirect()
    {
        $role = Auth::user()->rol; // ← corrección aquí 
        switch ($role) {
            case 'administrador':
                return redirect('/admin/dashboard');
            case 'encargado':
                return redirect('/personal/agenda');
            case 'cliente':
                return redirect('/cliente/perfil');
            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Rol no autorizado.');
        }
    }
}
