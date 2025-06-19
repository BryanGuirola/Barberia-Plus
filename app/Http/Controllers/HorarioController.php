<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\User;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        $encargados = User::soloEncargados();
        $filtroEncargado = $request->input('encargado_id');

        $horarios = Horario::with('encargado')
            ->when($filtroEncargado, fn($q) => $q->where('encargado_id', $filtroEncargado))
            ->get();

        return view('admin.horarios.index', compact('horarios', 'encargados', 'filtroEncargado'));
    }


    public function create()
    {
        $encargados = User::soloEncargados();
        return view('admin.horarios.create', compact('encargados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Horario::validacion());

        if (Horario::tieneConflicto($validated)) {
            return back()->withErrors(['conflicto' => '⚠️ El horario se superpone con otro existente para el mismo encargado.'])->withInput();
        }

        Horario::crear($validated);
        return redirect()->route('admin.horarios.index')->with('success', 'Horario creado.');
    }


    public function edit(Horario $horario)
    {
        $encargados = User::soloEncargados();
        return view('admin.horarios.edit', compact('horario', 'encargados'));
    }

    public function update(Request $request, Horario $horario)
    {
        $validated = $request->validate(Horario::validacion());

        if (Horario::tieneConflicto($validated, $horario->id)) {
            return back()->withErrors(['conflicto' => '⚠️ El horario se superpone con otro existente para el mismo encargado.'])->withInput();
        }

        $horario->actualizar($validated);
        return redirect()->route('admin.horarios.index')->with('success', 'Horario actualizado.');
    }


    public function destroy(Horario $horario){
        $horario->delete();

        return redirect()->route('admin.horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }

    public function toggleEstado(Horario $horario)
    {
        $horario->activo = !$horario->activo;
        $horario->save();

        return redirect()->route('admin.horarios.index')->with('success', 'Estado del horario actualizado.');
    }
}
