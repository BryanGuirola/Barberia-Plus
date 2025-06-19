@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4 text-secondary-emphasis">🕒 Horarios del Personal</h2>

    @if(session('success'))
        <div class="alert alert-success rounded-pill">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('admin.horarios.create') }}" class="btn btn-secondary rounded-pill px-4">➕ Agregar Horario</a>
    </div>
     <form method="GET" action="{{ route('admin.horarios.index') }}" class="mb-4 row">
    <div class="col-md-4">
        <select name="encargado_id" class="form-select rounded-pill" onchange="this.form.submit()">
            <option value="">🔍 Filtrar por encargado</option>
            @foreach($encargados as $encargado)
                <option value="{{ $encargado->id }}" @if(request('encargado_id') == $encargado->id) selected @endif>
                    {{ $encargado->name }}
                </option>
            @endforeach
        </select>
    </div>
</form>
    @if($horarios->isEmpty())
        <div class="alert alert-info rounded text-center">
            No hay horarios registrados aún.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white shadow-sm rounded align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Encargado</th>
                        <th>Día</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Estado</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($horarios as $horario)
                        <tr>
                            <td>{{ $horario->encargado->name }}</td>
                            <td>{{ ucfirst($horario->dia_semana) }}</td>
                            <td>{{ substr($horario->hora_inicio, 0, 5) }}</td>
                            <td>{{ substr($horario->hora_fin, 0, 5) }}</td>
                            <td>
                                @if($horario->activo)
                                    <span class="badge bg-success rounded-pill">Activo</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.horarios.edit', $horario) }}" class="btn btn-sm btn-outline-primary rounded-pill">Editar</a>

                                <form action="{{ route('admin.horarios.destroy', $horario) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este horario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Eliminar</button>
                                </form>

                                <form action="{{ route('admin.horarios.toggle', $horario) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm rounded-pill {{ $horario->activo ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                        {{ $horario->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
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
