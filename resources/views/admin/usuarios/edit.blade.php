@extends('layouts.app')

@section('content')

<div class="container py-4"> <h2 class="mb-4 text-warning-emphasis">✏️ Editar Usuario</h2>
@if($errors->any())
    <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>❗ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="bg-white p-4 shadow-sm rounded-4">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control rounded-pill" required value="{{ old('name', $usuario->name) }}">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" name="email" class="form-control rounded-pill" required value="{{ old('email', $usuario->email) }}">
    </div>

    <div class="mb-3">
        <label for="rol" class="form-label">Rol</label>
        <select name="rol" class="form-select rounded-pill" required>
            <option value="">Seleccione un rol</option>
            <option value="administrador" @if(old('rol', $usuario->rol) === 'administrador') selected @endif>Administrador</option>
            <option value="encargado" @if(old('rol', $usuario->rol) === 'encargado') selected @endif>Encargado</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña (opcional)</label>
        <input type="password" name="password" class="form-control rounded-pill" placeholder="Dejar en blanco para no cambiar">
    </div>

    <div class="text-end">
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary rounded-pill">Cancelar</a>
        <button type="submit" class="btn btn-warning rounded-pill px-4">Actualizar</button>
    </div>
</form>
</div>
@endsection