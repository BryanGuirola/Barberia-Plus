<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\User;
use App\Models\Horario;


class ClienteCitaController extends Controller
{
    public function index(Request $request)
    {
        $rawFecha = $request->input('fecha');
        $estado = $request->input('estado');
        $fecha = ($rawFecha === 'todas') ? 'todas' : $rawFecha;

        $citas = Cita::filtradas(auth()->id(), 'cliente', $fecha, $estado);

        return view('cliente.citas.index', [
            'citas' => $citas,
            'fecha' => $rawFecha,

        ]);
    }
    public function create()
    {
        $servicios = Servicio::todos();
        $encargados = User::soloEncargados();
        return view('cliente.citas.create', compact('servicios', 'encargados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Cita::validacion());

        // Verifica si la hora aún está disponible
        $horasValidas = Cita::horasDisponiblesPara($validated['encargado_id'], $validated['fecha']);

        if (!in_array($validated['hora'], $horasValidas)) {
            return back()->withErrors(['hora' => 'La hora seleccionada ya no está disponible.'])->withInput();
        }

        try {
            Cita::crearConServicios(auth()->id(), $validated);
            return redirect()->route('cliente.citas.index')->with('success', 'Cita agendada.');
        } catch (\Exception $e) {
            return back()->withErrors(['hora' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Cita $cita)
    {
        $this->authorize('delete', $cita);
        $cita->eliminar();
        return redirect()
            ->route('cliente.citas.index')
            ->with('success', 'Cita cancelada exitosamente.');
    }

    public function horasDisponibles(Request $request)
    {
        $request->validate([
            'encargado_id' => 'required|exists:users,id',
            'fecha' => 'required|date'
        ]);

        $horas = Cita::horasDisponiblesPara($request->encargado_id, $request->fecha);
        return response()->json($horas);
    }

    public function diasLaborales($id)
    {
        $dias = Horario::diasLaboralesDeEncargado($id);
        return response()->json($dias);
    }

    public function cancelar(Cita $cita)
    {
        $this->authorize('delete', $cita); // Solo el dueño puede cancelar

        if ($cita->cliente_id !== auth()->id()) {
            abort(403, 'No puedes cancelar esta cita.');
        }

        if ($cita->estado === 'pendiente' || $cita->estado === 'confirmada') {
            $cita->cancelarPorCliente();
            return back()->with('success', 'La cita fue cancelada.');
        }

        return back()->with('error', 'No puedes cancelar una cita en estado ' . $cita->estado);
    }

    public function edit(Cita $cita)
    {
        $this->authorize('update', $cita); // El cliente debe ser dueño de la cita
        if ($cita->estado !== 'pendiente') {
            return back()->with('error', 'Solo puedes modificar citas pendientes.');
        }

        $servicios = Servicio::todos();
        $encargados = User::soloEncargados();
        return view('cliente.citas.edit', compact('cita', 'servicios', 'encargados'));
    }

    public function update(Request $request, Cita $cita)
    {
        $this->authorize('update', $cita);
        if ($cita->estado !== 'pendiente') {
            return back()->with('error', 'Solo puedes modificar citas pendientes.');
        }

        $validated = $request->validate(Cita::validacion());

        $horasValidas = Cita::horasDisponiblesPara($validated['encargado_id'], $validated['fecha']);
        if (!in_array($validated['hora'], $horasValidas)) {
            return back()->withErrors(['hora' => 'La hora seleccionada ya no está disponible.'])->withInput();
        }

        try {
            $cita->actualizar($validated); // crea este método en el modelo
            return redirect()->route('cliente.citas.index')->with('success', 'Cita actualizada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['hora' => $e->getMessage()])->withInput();
        }
    }
}
