<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Citas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .header {
            margin-bottom: 20px;
        }

        .header p {
            margin: 2px 0;
        }

        .logo {
            text-align: right;
            margin-bottom: 10px;
        }

        .logo img {
            height: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .status-warning {
            background-color: #fff3cd;
        }

        .status-danger {
            background-color: #f8d7da;
        }

        .status-success {
            background-color: #d4edda;
        }

        .status-dark {
            background-color: #dee2e6;
        }

        .totales-table td {
            padding: 5px;
        }

        .totales-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .totales {
            margin-top: 30px;
        }
    </style>
</head>
<body>



    <h2>Reporte de Citas</h2>

    <div class="header">
        @php
            $hayDesde = !empty($desde);
            $hayHasta = !empty($hasta);
        @endphp

        @if($hayDesde && $hayHasta)
            <p>Rango: {{ $desde }} al {{ $hasta }}</p>
        @elseif($hayDesde)
            <p>Desde: {{ $desde }}</p>
        @elseif($hayHasta)
            <p>Hasta: {{ $hasta }}</p>
        @else
            <p>Todas las fechas</p>
        @endif

        <p>Estado: {{ $estado ? ucfirst($estado) : 'Todos' }}</p>
        <p>Encargado: {{ $encargadoNombre ?? 'Todos' }}</p>
        <p>Total de citas: {{ $citas->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Encargado</th>
                <th>Servicios</th>
                <th>Total ($)</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
                @php
                    $monto = $cita->servicios->sum('precio');
                    $estadoClass = match($cita->estado) {
                        'pendiente', 'confirmada' => 'status-warning',
                        'cancelada', 'rechazada', 'no_asistió' => 'status-danger',
                        'finalizada' => 'status-success',
                        'olvidada' => 'status-dark',
                        default => ''
                    };
                @endphp
                <tr>
                    <td>{{ $cita->fecha }}</td>
                    <td>{{ $cita->hora }}</td>
                    <td>{{ $cita->cliente->name }}</td>
                    <td>{{ $cita->encargado->name ?? '-' }}</td>
                    <td>
                        @foreach($cita->servicios as $servicio)
                            • {{ $servicio->nombre }}<br>
                        @endforeach
                    </td>
                    <td>${{ number_format($monto, 2) }}</td>
                    <td class="{{ $estadoClass }}">{{ ucfirst($cita->estado) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <h4>Totales</h4>
        <table class="totales-table">
            <tr>
                <td><strong>Ingresos reales (citas finalizadas):</strong></td>
                <td>${{ number_format($ingresos, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Ingresos potenciales (pendientes o confirmadas):</strong></td>
                <td>${{ number_format($ingresosPotenciales, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Pérdidas (canceladas, rechazadas, no asistió):</strong></td>
                <td>${{ number_format($perdidas, 2) }}</td>
            </tr>
            <tr>
                <td><strong>No etiquetados (sin categoría):</strong></td>
                <td>${{ number_format($noEtiquetados, 2) }}</td>
            </tr>
        </table>
    </div>

</body>
</html>
