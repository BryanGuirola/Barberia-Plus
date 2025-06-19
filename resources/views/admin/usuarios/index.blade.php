@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4 text-primary-emphasis">👥 Gestión de Usuarios</h2>
    @if(session('success'))
    <div class="alert alert-success rounded-pill">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-secondary rounded-pill px-4">➕ Nuevo Usuario</a>
    </div>

    @if($usuarios->isEmpty())
    <div class="alert alert-info text-center rounded-3">
        No hay usuarios registrados aún.
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm bg-white rounded-4 overflow-hidden">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <span class="badge {{ $usuario->rol === 'administrador' ? 'bg-primary-subtle text-primary-emphasis' : 'bg-info-subtle text-info-emphasis' }}">
                            {{ ucfirst($usuario->rol) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-primary rounded-pill">Editar</a>
                        <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este usuario?')">
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