<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\Horario;


class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'encargados' => User::where('rol', 'encargado')->count(),
            'servicios' => Servicio::count(),
            'citas' => Cita::count()
        ]);
    }
    /**
     * Muestra la lista de todos los usuarios administradores o encargados.
     */
    public function index()
    {
        $usuarios = User::whereIn('rol', ['administrador', 'encargado'])->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }
    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(User::validacion());
        User::crearUsuario($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario de edición para un usuario.
     */
    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualiza un usuario en la base de datos.
     */
    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate(User::validacion(true, $usuario->id));
        $usuario->actualizarUsuario($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(User $usuario)
    {
        $usuario->eliminarUsuario();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }


public function crearCitaManualForm()
{
    return view('admin.citas.manual', [
        'servicios' => Servicio::todos(),
        'encargados' => User::where('rol', 'encargado')->get()
    ]);
}

public function diasEncargado($id)
{
    return Horario::diasActivosDe($id);
}

public function horasDisponibles(Request $request)
{
    $request->validate([
        'encargado_id' => 'required|exists:users,id',
        'fecha' => 'required|date'
    ]);

    return response()->json(Cita::horasDisponiblesPara($request->encargado_id, $request->fecha));
}

public function buscarCliente(Request $request)
{
    return User::buscarClientes($request->query('query'));
}




    public function guardarCitaManual(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'nullable|exists:users,id',
            'name' => 'required_without:cliente_id|nullable|string|max:100',
            'email' => 'required_without:cliente_id|nullable|email|unique:users,email',
            'fecha' => 'required|date',
            'hora' => 'required',
            'encargado_id' => 'required|exists:users,id',
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'exists:servicios,id',
        ]);

        try {
            Cita::agendarManual($validated, $validated['encargado_id']);
            return redirect()->route('admin.dashboard')->with('success', 'Cita creada correctamente');
        } catch (\Exception $e) {
            return back()->withErrors(['hora' => $e->getMessage()])->withInput();
        }
    }
}
