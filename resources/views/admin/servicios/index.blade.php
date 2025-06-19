@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-warning-emphasis">💇‍♂️ Servicios Disponibles</h2>

    @if(session('success'))
        <div class="alert alert-success rounded-pill">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('admin.servicios.create') }}" class="btn btn-warning rounded-pill px-4">➕ Agregar Servicio</a>
    </div>

    @if($servicios->isEmpty())
        <div class="alert alert-info rounded text-center">
            No hay servicios registrados aún.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white rounded shadow-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Duración</th>
                        <th>Precio</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->descripcion ?? '—' }}</td>
                            <td>{{ $servicio->duracion_min }} min</td>
                            <td>${{ number_format($servicio->precio, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.servicios.edit', $servicio) }}" class="btn btn-sm btn-outline-primary rounded-pill">Editar</a>
                                <form action="{{ route('admin.servicios.destroy', $servicio) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este servicio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
