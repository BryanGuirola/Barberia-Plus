@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4 text-dark">🛠️ Panel de Administración</h2>
    <div class="row g-4"> {{-- Servicios --}}
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 bg-light-subtle text-center">
                <div class="card-body">
                    <h5 class="card-title">💇 Servicios</h5>
                    <p class="card-text">Agregar, editar o eliminar servicios.</p> <a href="{{ route('admin.servicios.index') }}" class="btn btn-outline-dark rounded-pill px-3">Gestionar</a>
                </div>
            </div>
        </div>
        {{-- Usuarios --}}
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 bg-light-subtle text-center">
                <div class="card-body">
                    <h5 class="card-title">🧑‍🔧 Encargados</h5>
                    <p class="card-text">Agregar, editar o eliminar encargados y administradores.</p>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-dark rounded-pill px-3">Gestionar</a>
                </div>
            </div>
        </div>

        {{-- Horarios --}}
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 bg-light-subtle text-center">
                <div class="card-body">
                    <h5 class="card-title">🕒 Horarios</h5>
                    <p class="card-text">Configura los días y horas de atención.</p>
                    <a href="{{ route('admin.horarios.index') }}" class="btn btn-outline-dark rounded-pill px-3">Gestionar</a>
                </div>
            </div>
        </div>

        {{-- Cita Manual --}}
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 bg-light-subtle text-center">
                <div class="card-body">
                    <h5 class="card-title">📆 Agendar Cita Manual</h5>
                    <p class="card-text">Buscar o registrar cliente y agendar cita desde aquí.</p>
                    <a href="{{ route('admin.citas.manual') }}" class="btn btn-outline-dark rounded-pill px-3">Agendar</a>
                </div>
            </div>
        </div>

        {{-- Reportes --}}
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 bg-light-subtle text-center">
                <div class="card-body">
                    <h5 class="card-title">📊 Reportes</h5>
                    <p class="card-text">Ver estadísticas y generar reportes en PDF.</p>
                    <a href="{{ route('admin.reportes.citas') }}" class="btn btn-outline-dark rounded-pill px-3">Ver reportes</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection