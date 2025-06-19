@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4 text-primary-emphasis">✏️ Editar Servicio</h2>
    @if($errors->any())
    <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>❗ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.servicios.update', $servicio) }}" method="POST" class="bg-white p-4 shadow-sm rounded-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control rounded-pill" required value="{{ old('nombre', $servicio->nombre) }}">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control rounded-3" rows="3">{{ old('descripcion', $servicio->descripcion) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="duracion_min" class="form-label">Duración (minutos)</label>
                <input type="number" name="duracion_min" class="form-control rounded-pill" required min="5" value="{{ old('duracion_min', $servicio->duracion_min) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="precio" class="form-label">Precio (Q)</label>
                <input type="number" step="0.01" name="precio" class="form-control rounded-pill" required value="{{ old('precio', $servicio->precio) }}">
            </div>
        </div>

        <div class="text-end">
            <a href="{{ route('admin.servicios.index') }}" class="btn btn-outline-secondary rounded-pill">Cancelar</a>
            <button type="submit" class="btn btn-primary rounded-pill px-4">Actualizar</button>
        </div>
    </form>
</div> @endsection