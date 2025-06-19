@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-secondary-emphasis">💈 Bienvenido, {{ auth()->user()->name }}</h2>
    <div class="row g-4">
        {{-- Citas del día --}}
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 bg-primary-subtle">
                <div class="card-body">
                    <h5 class="card-title">📅 Citas de Hoy</h5>
                    <p class="card-text">Consulta tus citas asignadas para hoy y gestiona cada una.</p>
                    <a href="{{ route('personal.citas.index', ['fecha' => now()->toDateString()]) }}" class="btn btn-outline-primary rounded-pill px-4">Ver mis citas</a>
                </div>
            </div>
        </div>

        {{-- Agendar cita manual --}}
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 bg-success-subtle">
                <div class="card-body">
                    <h5 class="card-title">📝 Agendar Cita</h5>
                    <p class="card-text">Registra una nueva cita para un cliente rápidamente.</p>
                    <a href="{{ route('personal.citas.manual') }}" class="btn btn-outline-success rounded-pill px-4">Nueva Cita</a>
                </div>
            </div>
        </div>

        {{-- Catálogo de servicios --}}
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-4 bg-warning-subtle">
                <div class="card-body">
                    <h5 class="card-title">💈 Servicios</h5>
                    <p class="card-text">Consulta todos los servicios ofrecidos, duración y precios.</p>
                    <a href="{{ route('personal.servicios') }}" class="btn btn-outline-warning rounded-pill px-4">Ver catálogo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
