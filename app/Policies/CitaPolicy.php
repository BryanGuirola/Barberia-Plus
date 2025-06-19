<?php

namespace App\Policies;

use App\Models\Cita;
use App\Models\User;

class CitaPolicy
{
    /** * Permite a un cliente eliminar solo sus propias citas. */ public function delete(User $user, Cita $cita): bool
    {
        return $user->rol === 'cliente' && $user->id === $cita->cliente_id;
    }
    /** * Permite a un encargado confirmar/finalizar solo sus citas asignadas. */ public function update(User $user, Cita $cita): bool
    {
        if ($user->rol === 'encargado' && $user->id === $cita->encargado_id) {
        return true;
    }

    if ($user->rol === 'cliente' && $user->id === $cita->cliente_id && $cita->estado === 'pendiente') {
        return true;
    }

    return false;
    }
}
