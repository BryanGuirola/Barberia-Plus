<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Servicio;

class ServicioController extends Controller
{
    public function index()
    {
        // Llama a Servicio::todos() para obtener todos los servicios desde el modelo Servicio
        $servicios = Servicio::todos();
        return view('admin.servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('admin.servicios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Servicio::validacion());
        Servicio::crear($validated);
        return redirect()->route('admin.servicios.index')->with('success', 'Servicio creado.');
    }

    public function edit(Servicio $servicio)
    {
        return view('admin.servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $validated = $request->validate(Servicio::validacion());
        $servicio->actualizar($validated);
        return redirect()->route('admin.servicios.index')->with('success', 'Servicio actualizado.');
    }

public function destroy(Servicio $servicio)
{
    $servicio->eliminar();
    return redirect()->route('admin.servicios.index')->with('success', 'Servicio eliminado correctamente.');
}

    public function catalogoCliente()
    {
        $servicios = Servicio::todos();
        return view('cliente.servicios.catalogo', compact('servicios'));
    }

    public function catalogoEncargado()
    {
        $servicios = Servicio::todos();
        return view('personal.servicios.catalogo', compact('servicios'));
    }
}
