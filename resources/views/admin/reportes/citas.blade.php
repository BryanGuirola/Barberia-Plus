@extends('layouts.app')

@php
$conteoEstados = $citas->groupBy('estado')->map->count();
$pieChartData = [
$totales['ingresos'],
$totales['ingresos_potenciales'],
$totales['perdidas'],
$totales['no_etiquetados'],
];
@endphp

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container py-4">
    <h2 class="mb-4 text-dark">📊 Reporte de Citas</h2>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('admin.reportes.citas') }}" class="row g-3 align-items-end mb-4">
        <!-- filtros -->
        <div class="col-md-3">
            <label for="fecha_inicio" class="form-label">Desde</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control rounded-pill">
        </div>
        <div class="col-md-3">
            <label for="fecha_fin" class="form-label">Hasta</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control rounded-pill">
        </div>
        <div class="col-md-3">
            <label for="estado" class="form-label">Estado</label>
            <select id="estado" name="estado" class="form-select rounded-pill">
                <option value="">Todos</option>
                @foreach(\App\Models\Cita::estadosPermitidos() as $estado)
                <option value="{{ $estado }}" {{ request('estado') === $estado ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $estado)) }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="encargado" class="form-label">Encargado</label>
            <select id="encargado" name="encargado" class="form-select rounded-pill">
                <option value="">Todos</option>
                @foreach($encargados as $e)
                <option value="{{ $e->id }}" {{ request('encargado') == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-dark rounded-pill">Filtrar</button>
            <a href="{{ route('admin.reportes.citas') }}" class="btn btn-secondary rounded-pill">Reset</a>
        </div>
    </form>

    {{-- Gráficos en paralelo --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="bg-light shadow-sm rounded-4 p-4 h-100">
                <h5 class="text-secondary">Distribución por estado</h5>
                <div style="height: 300px;">
                    <canvas id="estadoChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-light shadow-sm rounded-4 p-4 h-100">
                <h5 class="text-secondary">Distribución de ingresos</h5>
                <div style="height: 300px;">
                    <canvas id="ingresosChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla con scroll interno y cabecera fija --}}
<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
    <table class="table table-bordered table-hover rounded shadow-sm mb-0">
        <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 1;">
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Encargado</th>
                <th>Servicios</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($citas as $cita)
            <tr>
                <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                <td>{{ substr($cita->hora, 0, 5) }}</td>
                <td>{{ $cita->cliente->name }}</td>
                <td>{{ $cita->encargado->name }}</td>
                <td>
                    <ul class="mb-0 ps-3">
                        @foreach($cita->servicios as $servicio)
                        <li>{{ $servicio->nombre }}</li>
                        @endforeach
                    </ul>
                </td>
                <td class="text-end">${{ number_format($cita->servicios->sum('precio'), 2) }}</td>
                <td>
                    @php
                    $estado = $cita->estado;
                    $colores = [
                        'pendiente' => 'warning',
                        'confirmada' => 'warning',
                        'cancelada' => 'danger',
                        'rechazada' => 'danger',
                        'finalizada' => 'success',
                        'no_asistió' => 'danger',
                        'olvidada' => 'dark'
                    ];
                    @endphp
                    <span class="badge rounded-pill text-bg-{{ $colores[$estado] ?? 'dark' }}">
                        {{ ucfirst(str_replace('_', ' ', $estado)) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No se encontraron resultados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

      {{-- Totales --}}
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="bg-success text-white rounded-4 p-3 shadow-sm">
                    <h6 class="mb-1">💰 Ingresos reales</h6>
                    <strong>${{ number_format($totales['ingresos'], 2) }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-warning text-dark rounded-4 p-3 shadow-sm">
                    <h6 class="mb-1">💵 Ingresos potenciales</h6>
                    <strong>${{ number_format($totales['ingresos_potenciales'], 2) }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-danger text-white rounded-4 p-3 shadow-sm">
                    <h6 class="mb-1">❌ Pérdidas</h6>
                    <strong>${{ number_format($totales['perdidas'], 2) }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-secondary text-white rounded-4 p-3 shadow-sm">
                    <h6 class="mb-1">⚠️ No etiquetado</h6>
                    <strong>${{ number_format($totales['no_etiquetados'], 2) }}</strong>
                </div>
            </div>
        </div>

    {{-- Exportar --}}
    <div class="text-end mt-4 d-flex flex-wrap justify-content-end align-items-center gap-2">
        <form action="{{ route('admin.reportes.citas.pdf') }}" method="GET" target="_blank" class="mb-0">
            <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">
            <input type="hidden" name="estado" value="{{ request('estado') }}">
            <input type="hidden" name="encargado" value="{{ request('encargado') }}">
            <button type="submit" class="btn btn-outline-primary rounded-pill px-4">📄 Exportar PDF</button>
        </form>

    </div>
</div>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rawData = @json($conteoEstados);
        const labels = Object.keys(rawData);
        const data = Object.values(rawData);

        const estadoColors = {
            pendiente: '#FFC107',
            confirmada: '#0DCAF0',
            cancelada: '#DC3545',
            rechazada: '#FD7E14',
            finalizada: '#28A745',
            no_asistió: '#6C757D',
            olvidada: '#343A40'
        };

        const backgroundColors = labels.map(label => estadoColors[label] || '#000');

        const ctx = document.getElementById('estadoChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Citas por estado',
                    data: data,
                    backgroundColor: backgroundColors,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        const pieData = @json($pieChartData);
        const pieCtx = document.getElementById('ingresosChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Reales', 'Potenciales', 'Pérdidas', 'No etiquetado'],
                datasets: [{
                    data: pieData,
                    backgroundColor: ['#28A745', '#FFC107', '#DC3545', '#6C757D']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endsection