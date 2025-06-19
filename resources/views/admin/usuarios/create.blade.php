@extends('layouts.app')

@section('content')

<div class="container py-4"> <h2 class="mb-4 text-success-emphasis">➕ Nuevo Usuario</h2>
@if($errors->any())
    <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>❗ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.usuarios.store') }}" method="POST" class="bg-white p-4 shadow-sm rounded-4">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control rounded-pill" required value="{{ old('name') }}">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" name="email" class="form-control rounded-pill" required value="{{ old('email') }}">
    </div>

    <div class="mb-3">
        <label for="rol" class="form-label">Rol</label>
        <select name="rol" class="form-select rounded-pill" required>
            <option value="">Seleccione un rol</option>
            <option value="administrador" @if(old('rol') == 'administrador') selected @endif>Administrador</option>
            <option value="encargado" @if(old('rol') == 'encargado') selected @endif>Encargado</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control rounded-pill" required>
    </div>

    <div class="text-end">
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary rounded-pill">Cancelar</a>
        <button type="submit" class="btn btn-success rounded-pill px-4">Crear</button>
    </div>
</form>
</div>
@endsection