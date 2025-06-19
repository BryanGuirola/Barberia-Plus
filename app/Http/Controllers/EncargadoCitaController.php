<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\User;
use App\Models\Horario;



class EncargadoCitaController extends Controller
{
    public function index(Request $request)
    {
        $rawFecha = $request->input('fecha');
        $estado = $request->input('estado');
        $fecha = ($rawFecha === 'todas') ? 'todas' : $rawFecha;

        $citas = Cita::filtradas(auth()->id(), 'encargado', $fecha, $estado);
        return view('personal.citas.index', [
            'citas' => $citas,
            'fecha' => $rawFecha // para mantener el input de fecha visible
        ]);
    }

    public function confirmar(Cita $cita)
    {
        $this->authorize('update', $cita);
        $cita->confirmar();
        return back()->with('success', 'La cita fue confirmada.');
    }

    public function finalizar(Cita $cita)
    {
        $this->authorize('update', $cita);
        $cita->finalizar();
        return back()->with('success', 'La cita fue finalizada.');
    }


    public function rechazar(Cita $cita)
    {
        $this->authorize('update', $cita); // el encargado puede rechazar si le pertenece
        if ($cita->estado === 'pendiente') {
            $cita->rechazarPorEncargado();
            return back()->with('success', 'La cita fue rechazada.');
        }

        return back()->with('error', 'Solo puedes rechazar citas pendientes.');
    }

    public function noAsistio(Cita $cita)
    {
        $this->authorize('update', $cita); // debe ser del encargado
        if ($cita->estado === 'confirmada') {
            $cita->marcarNoAsistio();
            return back()->with('success', 'Se marcó como no asistió.');
        }

        return back()->with('error', 'Solo puedes marcar como no asistió una cita confirmada.');
    }





    public function guardarCitaManual(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'nullable|exists:users,id',
            'name' => 'required_without:cliente_id|nullable|string|max:100',
            'email' => 'required_without:cliente_id|nullable|email|unique:users,email',
            'fecha' => 'required|date',
            'hora' => 'required',
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'exists:servicios,id',
        ]);

        try {
            Cita::agendarManual($validated, auth()->id());
            return redirect()->route('personal.citas.index')->with('success', 'Cita creada correctamente');
        } catch (\Exception $e) {
            return back()->withErrors(['hora' => $e->getMessage()])->withInput();
        }
    }


    public function crearManual()
    {
        return view('personal.citas.manual', [
            'servicios' => Servicio::todos()
        ]);
    }

    public function buscarCliente(Request $request)
    {
        return User::buscarClientes($request->query('query'));
    }

    public function diasTrabajo($encargadoId)
    {
        return Horario::diasActivosDe($encargadoId);
    }

    public function horasDisponibles(Request $request)
    {
        $request->validate([
            'encargado_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
        ]);

        return response()->json(Cita::horasDisponiblesPara($request->encargado_id, $request->fecha));
    }
}
