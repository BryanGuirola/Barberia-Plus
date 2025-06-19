@extends('layouts.app')

@section('content')
{{-- Flatpickr CSS --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div class="container py-4">
    <h2 class="mb-4 text-success-emphasis">📝 Agendar Nueva Cita</h2>

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

    <form method="POST" action="{{ route('cliente.citas.store') }}" class="bg-white p-4 shadow-sm rounded-4">
        @csrf

        <div class="mb-3">
            <label for="encargado_id" class="form-label">Barbero</label>
            <select name="encargado_id" id="encargado_id" class="form-select rounded-pill" required>
                <option value="">Seleccione un barbero</option>
                @foreach($encargados as $encargado)
                <option value="{{ $encargado->id }}">{{ $encargado->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="text" name="fecha" id="fecha" class="form-control rounded-pill" required disabled>
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora disponible</label>
            <select name="hora" id="hora" class="form-select rounded-pill" required>
                <option value="">Seleccione una hora</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Servicios</label>
            <div class="row">
                @foreach($servicios as $servicio)
                <div class="col-md-6">
                    <div class="form-check rounded p-2 bg-light mb-2 shadow-sm">
                        <input class="form-check-input" type="checkbox" name="servicios[]" value="{{ $servicio->id }}" id="servicio{{ $servicio->id }}">
                        <label class="form-check-label" for="servicio{{ $servicio->id }}">
                            {{ $servicio->nombre }} ({{ $servicio->duracion_min }} min)
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success rounded-pill px-4">Agendar cita</button>
        </div>
    </form>
</div>
{{-- Flatpickr JS --}}

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const encargadoSelect = document.getElementById('encargado_id');
        const fechaInput = document.getElementById('fecha');
        const horaSelect = document.getElementById('hora');
        let diasPermitidos = [];
        let fechaPicker = null;
        const diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];

        function inicializarFlatpickr() {
            if (fechaPicker) {
                fechaPicker.destroy(); // reiniciar si ya existe
            }
            fechaPicker = flatpickr(fechaInput, {
                dateFormat: "Y-m-d",
                minDate: "today", // ❗ no permitir fechas anteriores a hoy 
                disable: [function(date) {
                    const diaNombre = diasSemana[date.getDay()];
                    return !diasPermitidos.includes(diaNombre);
                }],
                onChange: function() {
                    fetchHorasDisponibles();
                }
            });
            fechaInput.disabled = false;
        }

        function fetchDiasPermitidos(encargadoId) {
            fetch(`/cliente/encargado-dias/${encargadoId}`).then(res => res.json()).then(dias => {
                diasPermitidos = dias;
                fechaInput.value = '';
                horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';
                inicializarFlatpickr();
            });
        }

        function fetchHorasDisponibles() {
            const encargadoId = encargadoSelect.value;
            const fecha = fechaInput.value;
            if (encargadoId && fecha) {
                fetch(`/cliente/horas-disponibles?encargado_id=${encargadoId}&fecha=${fecha}`).then(response => response.json()).then(data => {
                    horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';
                    data.forEach(hora => {
                        const option = document.createElement('option');
                        option.value = hora;
                        option.textContent = hora;
                        horaSelect.appendChild(option);
                    });
                });
            }
        }
        encargadoSelect.addEventListener('change', function() {
            const encargadoId = encargadoSelect.value;
            if (encargadoId) {
                fetchDiasPermitidos(encargadoId);
            }
        });
    });
</script>
@endsection