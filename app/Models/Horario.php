<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $fillable = [
        'encargado_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'activo',
    ];

    public function encargado()
    {
        return $this->belongsTo(User::class, 'encargado_id');
    }
    public static function diasLaboralesDeEncargado($encargadoId)
    {
        return self::where('encargado_id', $encargadoId)
            ->pluck('dia_semana') // ejemplo: ['lunes', 'sabado']
            ->unique()
            ->values();
    }

    // Devuelve todos los horarios con la relación al encargado
    public static function conEncargado()
    {
        return self::with('encargado')->get();
    }

    // Reglas de validación para crear/editar horario
    public static function validacion()
    {
        return [
            'encargado_id' => 'required|exists:users,id',
            'dia_semana' => 'required|string',
            'hora_inicio' => 'required',
            'hora_fin' => 'required'
        ];
    }

    // Crea un nuevo horario
    public static function crear($datos)
    {
        return self::create($datos);
    }

    // Actualiza esta instancia de horario
    public function actualizar($datos)
    {
        return $this->update($datos);
    }

    // Elimina este horario
    public function eliminar()
    {
        return $this->delete();
    }

    public static function diasActivosDe($encargadoId)
    {
        return self::where('encargado_id', $encargadoId)
            ->where('activo', true)
            ->pluck('dia_semana')
            ->unique()
            ->values();
    }

    public static function tieneConflicto($datos, $idExcluir = null)
    {
        return self::where('encargado_id', $datos['encargado_id'])
            ->where('dia_semana', $datos['dia_semana'])
            ->when($idExcluir, fn($q) => $q->where('id', '!=', $idExcluir))
            ->where(function ($query) use ($datos) {
                $query->whereBetween('hora_inicio', [$datos['hora_inicio'], $datos['hora_fin']])
                    ->orWhereBetween('hora_fin', [$datos['hora_inicio'], $datos['hora_fin']])
                    ->orWhere(function ($q) use ($datos) {
                        $q->where('hora_inicio', '<', $datos['hora_inicio'])
                            ->where('hora_fin', '>', $datos['hora_fin']);
                    });
            })
            ->exists();
    }
}
