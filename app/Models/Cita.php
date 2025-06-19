<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $fillable = ['cliente_id', 'encargado_id', 'fecha', 'hora', 'estado'];

    // Relación muchos a muchos entre citas y servicios
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cita_servicio');
    }

    // Relación: una cita pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    // Relación: una cita pertenece a un encargado
    public function encargado()
    {
        return $this->belongsTo(User::class, 'encargado_id');
    }

    // Reglas de validación para agendar una cita
    public static function validacion()
    {
        return [
            'encargado_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'servicios' => 'required|array|min:1'
        ];
    }

    // validacion para ver si puede ser modificada
    public function puedeSerModificada()
    {
        return $this->estado === 'pendiente' || $this->estado === 'confirmada';
    }

    // Crea una cita nueva con servicios asociados
    public static function crearConServicios($clienteId, $datos)
    {
        // Verifica si ya hay una cita ocupando la misma hora con el mismo encargado
        $conflicto = self::where('encargado_id', $datos['encargado_id'])
            ->where('fecha', $datos['fecha'])
            ->where('hora', $datos['hora'])
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->exists();

        if ($conflicto) {
            throw new \Exception('El encargado ya tiene una cita en ese horario');
        }

        // Crea la cita
        $cita = self::create([
            'cliente_id' => $clienteId,
            'encargado_id' => $datos['encargado_id'],
            'fecha' => $datos['fecha'],
            'hora' => $datos['hora'],
            'estado' => 'pendiente'
        ]);

        // Asocia los servicios
        $cita->servicios()->attach($datos['servicios']);

        return $cita;
    }

    // Devuelve todas las citas de un cliente con sus relaciones
    public static function delCliente($clienteId)
    {
        return self::with('encargado', 'servicios')
            ->where('cliente_id', $clienteId)
            ->get();
    }

    // Devuelve todas las citas del encargado actual en la fecha actual
    public static function delEncargadoHoy($encargadoId)
    {
        return self::with('cliente', 'servicios')
            ->where('encargado_id', $encargadoId)
            ->where('fecha', today())
            ->get();
    }

    // Marca la cita como confirmada
    public function confirmar()
    {
        return $this->update(['estado' => 'confirmada']);
    }

    // Marca la cita como finalizada
    public function finalizar()
    {
        return $this->update(['estado' => 'finalizada']);
    }

    // Elimina esta cita
    public function eliminar()
    {
        return $this->delete();
    }

    // Calcula las horas disponibles para un encargado en un día
    public static function horasDisponiblesPara($encargadoId, $fecha)
    {
        // Mapeo manual del día de la semana (Carbon devuelve 0 = domingo, 1 = lunes, ...)
        $dias = [
            0 => 'domingo',
            1 => 'lunes',
            2 => 'martes',
            3 => 'miércoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sábado'
        ];
        $carbonFecha = \Carbon\Carbon::parse($fecha);
        $diaSemana = $dias[$carbonFecha->dayOfWeek]; // ejemplo: 'lunes'

        $hoy = now()->startOfDay();
        // Si es una fecha pasada, no hay horas disponibles
        if ($carbonFecha->lt($hoy)) {
            return [];
        }
        // Buscar horarios registrados para ese encargado y ese día
        $horarios = \App\Models\Horario::where('encargado_id', $encargadoId)
            ->where('dia_semana', $diaSemana)
            ->where('activo', true)
            ->get();

        if ($horarios->isEmpty()) {
            return [];
        }

        // Obtener todas las citas de ese día, con sus servicios
        $citas = self::with('servicios')
            ->where('encargado_id', $encargadoId)
            ->whereDate('fecha', $fecha)
            ->whereNotIn('estado', ['cancelada', 'rechazada']) // ❗ solo consideramos citas activas
            ->get();

        // Construir rangos ocupados según duración de cada cita
        $ocupados = [];
        foreach ($citas as $cita) {
            $inicio = strtotime($cita->hora);
            $fin = $inicio + ($cita->duracionTotal() * 60); // duraciónTotal() ya existe
            $ocupados[] = ['inicio' => $inicio, 'fin' => $fin];
        }

        $disponibles = [];

        foreach ($horarios as $horario) {
            $inicio = strtotime($horario->hora_inicio);
            $fin = strtotime($horario->hora_fin);

            while ($inicio + 1800 <= $fin) {
                $bloqueInicio = $inicio;
                $bloqueFin = $bloqueInicio + 1800;
                // Si la fecha es hoy, descarta bloques anteriores a la hora actual
                if ($carbonFecha->isToday() && $bloqueInicio < time()) {
                    $inicio += 1800;
                    continue;
                }
                // Verificar si se solapa con algún rango ocupado
                $superpuesto = false;
                foreach ($ocupados as $ocupado) {
                    if (
                        ($bloqueInicio >= $ocupado['inicio'] && $bloqueInicio < $ocupado['fin']) ||
                        ($bloqueFin > $ocupado['inicio'] && $bloqueFin <= $ocupado['fin']) ||
                        ($bloqueInicio <= $ocupado['inicio'] && $bloqueFin >= $ocupado['fin'])
                    ) {
                        $superpuesto = true;
                        break;
                    }
                }

                if (!$superpuesto) {
                    $disponibles[] = date('H:i:s', $bloqueInicio);
                }

                $inicio += 1800;
            }
        }

        return $disponibles;
    }




    // Total de minutos de la cita (suma de duración de servicios)
    public function duracionTotal()
    {
        return $this->servicios->sum('duracion_min');
    }

    // Total en dinero de los servicios
    public function precioTotal()
    {
        return $this->servicios->sum('precio');
    }

    public static function estadosPermitidos()
    {
        return [
            'pendiente',
            'confirmada',
            'cancelada',
            'rechazada',
            'finalizada',
            'no_asistió',
            'olvidada',
        ];
    }

    // Cambia el estado a "cancelada", llamado desde el cliente
    public function cancelarPorCliente()
    {
        $this->update(['estado' => 'cancelada']);
    }

    // Cambia el estado a "rechazada", llamado desde el encargado
    public function rechazarPorEncargado()
    {
        $this->update(['estado' => 'rechazada']);
    }

    // Cambia el estado a "no_asistió", llamado desde el encargado
    public function marcarNoAsistio()
    {
        $this->update(['estado' => 'no_asistió']);
    }

    // Citas futuras del encargado, opcionalmente filtradas por fecha
    public static function delEncargadoPorFecha($encargadoId, $fecha = null)
    {
        return self::with('cliente', 'servicios')
            ->where('encargado_id', $encargadoId)
            ->when($fecha, function ($query) use ($fecha) {
                $query->whereDate('fecha', $fecha);
            }, function ($query) {
                $query->whereDate('fecha', '>=', now()->toDateString());
            })
            ->orderBy('fecha')->orderBy('hora')
            ->get();
    }


    // Agebdar la cita de forma manual
    public static function agendarManual(array $datos, $encargadoId)
    {
        // Validación en controlador antes de llamar este método

        // Usar cliente existente o crear uno nuevo
        if (!empty($datos['cliente_id'])) {
            $clienteId = $datos['cliente_id'];
        } else {
            $cliente = User::crearClienteRapido([
                'name' => $datos['name'],
                'email' => $datos['email'],

            ]);
            $clienteId = $cliente->id;
        }

        // Validar si la hora sigue disponible
        $disponibles = self::horasDisponiblesPara($encargadoId, $datos['fecha']);
        if (!in_array($datos['hora'], $disponibles)) {
            throw new \Exception('Hora no disponible');
        }

        // Crear la cita
        return self::crearConServicios($clienteId, [
            'fecha' => $datos['fecha'],
            'hora' => $datos['hora'],
            'encargado_id' => $encargadoId,
            'servicios' => $datos['servicios'],
        ]);
    }


    public static function filtradas($usuarioId, $rol, $fecha = null, $estado = null)
    {
        return self::with('cliente', 'encargado', 'servicios')
            ->when($rol === 'encargado', function ($query) use ($usuarioId) {
                $query->where('encargado_id', $usuarioId);
            })
            ->when($rol === 'cliente', function ($query) use ($usuarioId) {
                $query->where('cliente_id', $usuarioId);
            })
            ->when(!is_null($fecha) && $fecha !== 'todas', function ($query) use ($fecha) {
                $query->whereDate('fecha', $fecha);
            }, function ($query) use ($fecha) {
                // Solo aplicar filtro ≥ hoy si $fecha no es 'todas' ni null
                if (is_null($fecha)) {
                    $query->whereDate('fecha', '>=', now()->toDateString());
                }
            })
            ->when($estado && $estado !== 'todos', function ($query) use ($estado) {
                $query->where('estado', $estado);
            })
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();
    }



    public function actualizar($datos)
    {
        $this->update([
            'fecha' => $datos['fecha'],
            'hora' => $datos['hora'],
            'encargado_id' => $datos['encargado_id']
        ]);
        $this->servicios()->sync($datos['servicios'] ?? []);
    }


    public function scopePorEstado($query, $estado)
    {
        if ($estado && $estado !== 'todos') {
            return $query->where('estado', $estado);
        }
        return $query;
    }

    public function scopePorEncargado($query, $encargadoId)
    {
        if ($encargadoId && $encargadoId !== 'todos') {
            return $query->where('encargado_id', $encargadoId);
        }
        return $query;
    }

    public function scopeEntreFechas($query, $desde, $hasta)
    {
        if ($desde && $hasta) {
            return $query->whereBetween('fecha', [$desde, $hasta]);
        } elseif ($desde) {
            return $query->where('fecha', '>=', $desde);
        } elseif ($hasta) {
            return $query->where('fecha', '<=', $hasta);
        }
        return $query;
    }
    public static function colorEstado($estado)
    {
        return match ($estado) {
            'pendiente' => 'pendiente',
            'aprobada' => 'aprobada',
            'cancelada' => 'cancelada',
            'rechazada' => 'rechazada',
            'atendida' => 'atendida',
            'olvidada' => 'olvidada',
            default => 'secondary',
        };
    }
    public static function clasificarEstados()
    {
        return [
            'ingresos' => ['finalizada'],
            'ingresos_potenciales' => ['pendiente', 'confirmada'],
            'perdidas' => ['cancelada', 'rechazada', 'no_asistió'],
            'no_etiquetados' => ['olvidada'],
        ];
    }

    public static function calcularTotalesPorCategoria($citas)
    {
        $clasificacion = self::clasificarEstados();
        $totales = [
            'ingresos' => 0,
            'ingresos_potenciales' => 0,
            'perdidas' => 0,
            'no_etiquetados' => 0,
        ];

        foreach ($citas as $cita) {
            $monto = $cita->servicios->sum('precio');
            foreach ($clasificacion as $categoria => $estados) {
                if (in_array($cita->estado, $estados)) {
                    $totales[$categoria] += $monto;
                    break;
                }
            }
        }

        return $totales;
    }
}
