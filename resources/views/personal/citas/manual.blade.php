@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div class="container py-4">
    <h2 class="mb-4 text-primary-emphasis">📆 Agendar Cita a Cliente</h2>
    @if(session('success'))
    <div class="alert alert-success rounded-pill">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>❗ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('personal.citas.manual.guardar') }}" class="bg-white p-4 shadow-sm rounded-4" id="form-cita">
        @csrf

        {{-- Cliente --}}
        <div class="mb-4 border-start border-primary border-3 ps-3">
            <h5 class="text-primary-emphasis">👥 Cliente</h5>
            <div class="mb-3">
                <label class="form-label">Buscar por nombre o correo</label>
                <input type="text" id="cliente_buscar" class="form-control rounded-pill" placeholder="Ej: Ana, ana@mail.com">
                <input type="hidden" name="cliente_id" id="cliente_id">
                <div id="cliente_sugerencias" class="list-group mt-1"></div>
            </div>

            <div id="nuevo_cliente_form" style="display:none;">
                <h6 class="text-secondary-emphasis">➕ Nuevo Cliente</h6>
                <div class="mb-2">
                    <input type="text" name="name" class="form-control rounded-pill" placeholder="Nombre completo">
                </div>
                <div class="mb-2">
                    <input type="email" name="email" class="form-control rounded-pill" placeholder="Correo electrónico">
                </div>
            </div>
        </div>

        {{-- Fecha --}}
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="text" name="fecha" id="fecha" class="form-control rounded-pill" required disabled>
        </div>

        {{-- Hora --}}
        <div class="mb-3">
            <label for="hora" class="form-label">Hora disponible</label>
            <select name="hora" id="hora" class="form-select rounded-pill" required>
                <option value="">Seleccione una hora</option>
            </select>
        </div>

        {{-- Servicios --}}
        <div class="mb-3">
            <label class="form-label">Servicios</label>
            <div class="row">
                @foreach($servicios as $servicio)
                <div class="col-md-6">
                    <div class="form-check bg-light rounded p-2 mb-2 shadow-sm">
                        <input class="form-check-input" type="checkbox" name="servicios[]" value="{{ $servicio->id }}" id="servicio{{ $servicio->id }}">
                        <label class="form-check-label" for="servicio{{ $servicio->id }}">
                            {{ $servicio->nombre }} ({{ $servicio->duracion_min }} min)
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Botón --}}
        <div class="text-end">
            <button class="btn btn-primary rounded-pill px-4">Agendar Cita</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInput = document.getElementById('fecha');
        const horaSelect = document.getElementById('hora');
        const diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        let diasPermitidos = [];
        let fechaPicker = null;

        function initFlatpickr() {
            if (fechaPicker) fechaPicker.destroy();
            fechaPicker = flatpickr(fechaInput, {
                dateFormat: "Y-m-d",
                minDate: "today", // ❗ no permitir fechas anteriores a hoy 
                disable: [function(date) {
                    const diaNombre = diasSemana[date.getDay()];
                    return !diasPermitidos.includes(diaNombre);
                }],
                onChange: fetchHoras
            });
            fechaInput.disabled = false;
        }

        function fetchDiasPermitidos() {
            fetch(`/personal/dias-trabajo/{{ auth()->id() }}`).then(res => res.json()).then(data => {
                diasPermitidos = data;
                fechaInput.value = '';
                horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';
                initFlatpickr();
            });
        }

        function fetchHoras() {
            const fecha = fechaInput.value;
            if (!fecha) return;
            fetch(`/personal/horas-disponibles?encargado_id={{ auth()->id() }}&fecha=${fecha}`).then(res => res.json()).then(data => {
                horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';
                data.forEach(h => {
                    const opt = document.createElement('option');
                    opt.value = h;
                    opt.textContent = h;
                    horaSelect.appendChild(opt);
                });
            });
        }
        fetchDiasPermitidos();
        fechaInput.addEventListener('change', fetchHoras); // Autocompletado de cliente
        const buscarInput = document.getElementById('cliente_buscar');
        const clienteIdInput = document.getElementById('cliente_id');
        const sugerencias = document.getElementById('cliente_sugerencias');
        const nuevoForm = document.getElementById('nuevo_cliente_form');
        buscarInput.addEventListener('input', function() {
            const query = this.value.trim();
            clienteIdInput.value = '';
            nuevoForm.style.display = 'none';
            sugerencias.innerHTML = '';
            if (query.length < 2) return;
            fetch(`/personal/clientes/buscar?query=${encodeURIComponent(query)}`).then(res => res.json()).then(data => {
                if (data.length) {
                    data.forEach(cliente => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = `${cliente.name} (${cliente.email})`;
                        item.onclick = () => {
                            clienteIdInput.value = cliente.id;
                            buscarInput.value = cliente.name;
                            sugerencias.innerHTML = '';
                            nuevoForm.style.display = 'none';
                        };
                        sugerencias.appendChild(item);
                    });
                } else {
                    sugerencias.innerHTML = '<div class="list-group-item text-muted">No encontrado. Se creará nuevo cliente.</div>';
                    nuevoForm.style.display = 'block';
                }
            });
        });
    });
</script>
@endsection