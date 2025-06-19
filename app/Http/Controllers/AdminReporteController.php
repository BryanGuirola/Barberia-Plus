<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use Barryvdh\DomPDF\Facade\Pdf;
use app\Models\User;

class AdminReporteController extends Controller
{

public function exportarPDF(Request $request)
{
    $desde = $request->input('fecha_inicio');
    $hasta = $request->input('fecha_fin');
    $estado = $request->input('estado');
    $encargado = $request->input('encargado');

    $query = Cita::with(['cliente', 'encargado', 'servicios']);

    if ($desde) {
        $query->whereDate('fecha', '>=', $desde);
    }

    if ($hasta) {
        $query->whereDate('fecha', '<=', $hasta);
    }

    if ($estado) {
        $query->where('estado', $estado);
    }

    if ($encargado) {
        $query->where('encargado_id', $encargado);
        $encargadoNombre = User::find($encargado)?->name ?? 'Desconocido';
    } else {
        $encargadoNombre = null;
    }

    $citas = $query->orderBy('fecha')->orderBy('hora')->get();

    // ✅ Calculamos totales usando tu función ya existente
    $totales = Cita::calcularTotalesPorCategoria($citas);

    // ✅ Renderizamos la vista y mostramos vista previa
    $pdf = Pdf::loadView('admin.reportes.citas_pdf', [
        'citas' => $citas,
        'desde' => $desde,
        'hasta' => $hasta,
        'estado' => $estado,
        'encargadoNombre' => $encargadoNombre,

        // Totales según tu helper
        'ingresos' => $totales['ingresos'],
        'ingresosPotenciales' => $totales['ingresos_potenciales'],
        'perdidas' => $totales['perdidas'],
        'noEtiquetados' => $totales['no_etiquetados'],
    ]);

    return $pdf->stream('reporte-citas.pdf'); // ✅ Vista previa
}

    public function citas(Request $request)
{
    $desde = $request->input('fecha_inicio');
    $hasta = $request->input('fecha_fin');
    $estado = $request->input('estado');
    $encargado = $request->input('encargado');

    $citas = Cita::with(['cliente', 'encargado', 'servicios'])
        ->porEstado($estado)
        ->porEncargado($encargado)
        ->entreFechas($desde, $hasta)
        ->orderBy('fecha')
        ->orderBy('hora')
        ->get();

    // 👤 Para dropdown de encargados
    $encargados = User::where('rol', 'encargado')->get();

    // 💵 Calculamos los totales clasificados por categoría de ingreso
    $totales = Cita::calcularTotalesPorCategoria($citas);

    // 🔁 Devolvemos los datos y filtros a la vista
    return view('admin.reportes.citas', compact(
        'citas',
        'desde',
        'hasta',
        'estado',
        'encargado',
        'encargados',
        'totales' // 👈 Asegúrate de incluirlo aquí
    ));
}

}
