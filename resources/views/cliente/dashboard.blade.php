@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-info-emphasis">👋 Bienvenido, {{ auth()->user()->name }}</h2>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-4 bg-info-subtle">
                <div class="card-body">
                    <h5 class="card-title">📆 Mis Citas</h5>
                    <p class="card-text">Consulta tus próximas reservas o historial de atención.</p>
                    <a href="{{ route('cliente.citas.index') }}" class="btn btn-outline-primary rounded-pill px-4">Ver mis citas</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow rounded-4 bg-success-subtle">
                <div class="card-body">
                    <h5 class="card-title">📝 Agendar Cita</h5>
                    <p class="card-text">Selecciona servicios, barbero y elige la hora perfecta.</p>
                    <a href="{{ route('cliente.citas.create') }}" class="btn btn-outline-success rounded-pill px-4">Agendar ahora</a>
                </div>
            </div>
        </div>

        {{-- NUEVA TARJETA --}}
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-4 bg-warning-subtle">
                <div class="card-body">
                    <h5 class="card-title">💈 Servicios</h5>
                    <p class="card-text">Consulta los servicios disponibles, sus precios y duración.</p>
                    <a href="{{ route('cliente.servicios') }}" class="btn btn-outline-warning rounded-pill px-4">Ver catálogo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
