<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_servicio');
    }


     protected $fillable = ['nombre', 'descripcion', 'duracion_min', 'precio'];

    // Devuelve todos los servicios registrados
    public static function todos()
    {
        return self::all();
    }

    // Devuelve las reglas de validación para crear/editar un servicio
    public static function validacion()
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion_min' => 'required|integer',
            'precio' => 'required|numeric'
        ];
    }

    // Crea un nuevo servicio en la base de datos
    public static function crear($datos)
    {
        return self::create($datos);
    }

    // Actualiza esta instancia de servicio con los datos dados
    public function actualizar($datos)
    {
        return $this->update($datos);
    }

    // Elimina esta instancia de servicio de la base de datos
    public function eliminar()
    {
        return $this->delete();
    }

}
