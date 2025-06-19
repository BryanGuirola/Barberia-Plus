@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4 text-primary-emphasis">📋 Citas asignadas</h2>
    {{-- Filtros: fecha (sincrónico) y estado (JS dinámico) --}}
    <form id="filtro-form" method="GET" action="{{ route('personal.citas.index') }}" class="mb-4 row g-2 align-items-end">
        <div class="col-md-3">
            <label for="fecha" class="form-label">Filtrar por fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control rounded-pill" value="{{ request('fecha') }}">
        </div>
        <div class="col-md-6 d-flex align-items-end gap-2 flex-wrap">
            <button type="submit" class="btn btn-outline-primary rounded-pill">Filtrar</button>
            <a href="{{ route('personal.citas.index', ['fecha' => 'todas', 'estado' => request('estado')]) }}" class="btn btn-outline-secondary rounded-pill">Ver todas</a>
            <a id="btn-hoy" href="{{ route('personal.citas.index', ['fecha' => now()->toDateString()]) }}" class="btn btn-outline-dark rounded-pill">Hoy</a>
            <a id="btn-futuras" href="{{ route('personal.citas.index', ['fecha' => now()->toDateString(), 'futuras' => 1]) }}" class="btn btn-outline-success rounded-pill">Futuras</a>
        </div>
        <div class="col-md-3">
            <label for="estado" class="form-label">Estado</label>
            <select id="estado" class="form-select rounded-pill">
                <option value="">Todos</option>
                @foreach(\App\Models\Cita::estadosPermitidos() as $estadoCita)
                <option value="{{ $estadoCita }}">{{ ucfirst($estadoCita) }}</option>
                @endforeach
            </select>
        </div>
    </form>

    @if(session('success'))
    <div class="alert alert-success rounded-pill">{{ session('success') }}</div>
    @endif

    @if($citas->isEmpty())
    <div class="alert alert-info text-center rounded-3">
        <p class="mb-0">No tienes citas asignadas.</p>
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle bg-white shadow-sm rounded-4">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Servicios</th>
                    <th>Duración</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody id="citas-tbody">
                @foreach($citas as $cita)
                <tr data-estado="{{ $cita->estado }}">
                    <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                    <td>{{ substr($cita->hora, 0, 5) }}</td>
                    <td>{{ $cita->cliente->name }}</td>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach($cita->servicios as $servicio)
                            <li>• {{ $servicio->nombre }} ({{ $servicio->duracion_min }} min)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $cita->duracionTotal() }} min</td>
                    <td>${{ number_format($cita->precioTotal(), 2) }}</td>
                    <td>
                        @php
                        $estilos = [
                        'pendiente' => 'bg-warning-subtle text-warning-emphasis',
                        'confirmada' => 'bg-info-subtle text-info-emphasis',
                        'finalizada' => 'bg-success-subtle text-success-emphasis',
                        'rechazada' => 'bg-danger-subtle text-danger-emphasis',
                        'cancelada' => 'bg-secondary-subtle text-secondary-emphasis',
                        'no_asistió' => 'bg-dark-subtle text-dark-emphasis',
                        ];
                        $clase = $estilos[$cita->estado] ?? 'bg-light text-muted';
                        @endphp
                        <span class="badge {{ $clase }} rounded-pill px-3 py-1">{{ ucfirst($cita->estado) }}</span>
                    </td>
                    <td class="text-center">
                        {{-- Acciones según estado --}}
                        @if($cita->estado === 'pendiente')
                        <form method="POST" action="{{ route('personal.citas.confirmar', $cita) }}" class="d-inline">
                            @csrf @method('PUT')
                            <button class="btn btn-sm btn-outline-primary rounded-pill">Confirmar</button>
                        </form>
                        <form method="POST" action="{{ route('personal.citas.rechazar', $cita) }}" class="d-inline">
                            @csrf @method('PUT')
                            <button class="btn btn-sm btn-outline-danger rounded-pill">Rechazar</button>
                        </form>
                        @elseif($cita->estado === 'confirmada')
                        <form method="POST" action="{{ route('personal.citas.finalizar', $cita) }}" class="d-inline">
                            @csrf @method('PUT')
                            <button class="btn btn-sm btn-outline-success rounded-pill">Finalizar</button>
                        </form>
                        <form method="POST" action="{{ route('personal.citas.no_asistio', $cita) }}" class="d-inline">
                            @csrf @method('PUT')
                            <button class="btn btn-sm btn-outline-warning rounded-pill">No asistió</button>
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
{{-- Filtro dinámico solo para estado --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const estadoSelect = document.getElementById('estado');
        const tbody = document.getElementById('citas-tbody');
        if (estadoSelect && tbody) {
            estadoSelect.addEventListener('change', () => {
                const estado = estadoSelect.value;
                const filas = tbody.querySelectorAll('tr');
                filas.forEach(fila => {
                    const estadoFila = fila.getAttribute('data-estado');
                    fila.style.display = (estado === '' || estadoFila === estado) ? '' : 'none';
                });
            });
        }
    });
</script>

{{-- para obtener la fecha de hoy del boton hoy --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnHoy = document.getElementById('btn-hoy');
        const fechaInput = document.getElementById('fecha');
        const filtroForm = fechaInput.closest('form');

        btnHoy.addEventListener('click', function(e) {
            e.preventDefault();

            // Obtener la fecha local del navegador
            const hoy = new Date();
            const yyyy = hoy.getFullYear();
            const mm = String(hoy.getMonth() + 1).padStart(2, '0');
            const dd = String(hoy.getDate()).padStart(2, '0');
            const fechaLocal = `${yyyy}-${mm}-${dd}`;

            fechaInput.value = fechaLocal;
            filtroForm.submit();
        });

        const btnFuturas = document.getElementById('btn-futuras');

        btnFuturas.addEventListener('click', function(e) {
            e.preventDefault();
            // Borra el valor del campo de fecha
            fechaInput.value = '';
            filtroForm.submit();
        });
        const btnTodas = document.getElementById('btn-todas');
     
    });
</script>
@endsection