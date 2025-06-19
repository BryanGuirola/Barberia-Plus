@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4 text-primary-emphasis">📅 Mis Citas Agendadas</h2>
    {{-- Filtros: fecha (sincrónico) y estado (JS dinámico) --}}
    <form id="filtro-form" method="GET" action="{{ route('cliente.citas.index') }}" class="mb-4 row g-2 align-items-end">
        <div class="col-md-3">
            <label for="fecha" class="form-label">Filtrar por fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control rounded-pill" value="{{ request('fecha') }}">
        </div>
        <div class="col-md-6 d-flex align-items-end gap-2 flex-wrap">
            <button type="submit" class="btn btn-outline-primary rounded-pill">Filtrar</button>
            <a href="{{ route('cliente.citas.index', ['fecha' => 'todas', 'estado' => request('estado')]) }}" class="btn btn-outline-secondary rounded-pill">Ver todas</a>
            <a href="#" id="btn-hoy" class="btn btn-outline-dark rounded-pill">Hoy</a>
            <a href="#" id="btn-futuras" class="btn btn-outline-success rounded-pill">Futuras</a>
        </div>
        <div class="col-md-3">
            <label for="estado" class="form-label">Estado</label>
            <select id="estado" class="form-select rounded-pill">
                <option value="">Todos</option>
                @foreach(\App\Models\Cita::estadosPermitidos() as $estadoCita)
                <option value="{{ $estadoCita }}" {{ request('estado') === $estadoCita ? 'selected' : '' }}>
                    {{ ucfirst($estadoCita) }}
                </option>
                @endforeach
            </select>
        </div>
    </form>

    @if(session('success'))
    <div class="alert alert-success rounded-pill">{{ session('success') }}</div>
    @endif

    @if($citas->isEmpty())
    <div class="alert alert-info text-center">
        <p class="mb-2">No se encontraron citas con los filtros seleccionados.</p>
        <a href="{{ route('cliente.citas.create') }}" class="btn btn-outline-success btn-sm rounded-pill">Agendar una nueva cita</a>
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm bg-white rounded-4 overflow-hidden">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Encargado</th>
                    <th>Servicios</th>
                    <th>Estado</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody id="tabla-citas">
                @foreach($citas as $cita)
                <tr data-estado="{{ $cita->estado }}">
                    <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                    <td>{{ substr($cita->hora, 0, 5) }}</td>
                    <td>{{ $cita->encargado->name }}</td>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach($cita->servicios as $servicio)
                            <li>• {{ $servicio->nombre }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @php
                        $estilos = [
                        'pendiente' => 'bg-warning-subtle text-warning-emphasis',
                        'confirmada' => 'bg-info-subtle text-info-emphasis',
                        'finalizada' => 'bg-success-subtle text-success-emphasis',
                        'cancelada' => 'bg-secondary-subtle text-secondary-emphasis',
                        'rechazada' => 'bg-danger-subtle text-danger-emphasis',
                        'no_asistió' => 'bg-dark-subtle text-dark-emphasis',
                        ];
                        $clase = $estilos[$cita->estado] ?? 'bg-light text-muted';
                        @endphp
                        <span class="badge {{ $clase }} rounded-pill px-3 py-1">{{ ucfirst($cita->estado) }}</span>
                    </td>
                    <td class="text-center">
                        @if(in_array($cita->estado, ['pendiente', 'confirmada']))
                        @if($cita->estado === 'pendiente')
                        <a href="{{ route('cliente.citas.edit', $cita) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1">Editar</a>
                        @endif
                        <form method="POST" action="{{ route('cliente.citas.cancelar', $cita) }}" onsubmit="return confirm('¿Cancelar esta cita?')" class="d-inline">
                            @csrf @method('PUT')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Cancelar</button>
                        </form>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
{{-- JS para filtro asincrónico de estado --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const estadoSelect = document.getElementById('estado');
        const tbody = document.getElementById('tabla-citas');
        if (estadoSelect && tbody) {
            estadoSelect.addEventListener('change', () => {
                const estado = estadoSelect.value;
                const filas = tbody.querySelectorAll('tr');
                filas.forEach(fila => {
                    const estadoFila = fila.getAttribute('data-estado');
                    fila.style.display = (estado === '' || estadoFila === estado) ? '' : 'none';
                });
            });
        } // Botones de fecha 
        const fechaInput = document.getElementById('fecha');
        const filtroForm = document.getElementById('filtro-form');
        document.getElementById('btn-hoy').addEventListener('click', function(e) {
            e.preventDefault();
            const hoy = new Date().toISOString().split('T')[0];
            fechaInput.value = hoy;
            filtroForm.submit();
        });
        document.getElementById('btn-futuras').addEventListener('click', function(e) {
            e.preventDefault();
            fechaInput.value = '';
            filtroForm.submit();
        });
        document.getElementById('btn-todas').addEventListener('click', function(e) {
            fecha = todas
        });
    });
</script>
@endsection