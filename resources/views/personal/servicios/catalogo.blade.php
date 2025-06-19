@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">🧴 Catálogo de Servicios</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($servicios as $servicio)
            <div class="col">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        {{-- Icono personalizado con Bootstrap Icons --}}
                        <div class="mb-3">
                            <i class="bi bi-scissors text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="card-title">{{ $servicio->nombre }}</h5>
                        <p class="card-text text-muted">{{ $servicio->descripcion }}</p>
                        <p class="mb-1"><strong>Duración:</strong> {{ $servicio->duracion_min }} min</p>
                        <p class="mb-0"><strong>Precio:</strong> ${{ number_format($servicio->precio, 2) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection