@extends('layouts.app')

@section('content')

<div class="container py-5"> <h2 class="mb-4 text-primary-emphasis">🔐 Cambiar Contraseña</h2>
@if ($errors->any())
    <div class="alert alert-danger rounded-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>❗ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success rounded-pill">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('cliente.profile.password.update') }}" class="bg-white p-4 shadow-sm rounded-4">
    @csrf
    @method('PATCH')

    <div class="mb-3">
        <label for="password" class="form-label">Nueva contraseña</label>
        <input type="password" name="password" id="password" class="form-control rounded-pill" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-pill" required>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary rounded-pill px-4">Actualizar</button>
    </div>
</form>
</div> @endsection