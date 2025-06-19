@extends('layouts.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4 text-secondary-emphasis">➕ Nuevo Horario</h2>

    @if($errors->any())
    <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>❗ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if($errors->has('conflicto'))
    <div class="alert alert-warning rounded-3">
        {{ $errors->first('conflicto') }}
    </div>
    @endif

    <form action="{{ route('admin.horarios.store') }}" method="POST" class="bg-white p-4 shadow-sm rounded-4">
        @csrf

        <div class="mb-3">
            <label for="encargado_id" class="form-label">Encargado</label>
            <select name="encargado_id" class="form-select rounded-pill" required>
                <option value="">Seleccione un encargado</option>
                @foreach($encargados as $encargado)
                <option value="{{ $encargado->id }}" @if(old('encargado_id')==$encargado->id) selected @endif>
                    {{ $encargado->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="dia_semana" class="form-label">Día de la semana</label>
            <select name="dia_semana" class="form-select rounded-pill" required>
                <option value="">Seleccione un día</option>
                @foreach(['lunes','martes','miércoles','jueves','viernes','sábado','domingo'] as $dia)
                <option value="{{ $dia }}" @if(old('dia_semana')==$dia) selected @endif>{{ ucfirst($dia) }}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="hora_inicio" class="form-label">Desde</label>
                <input type="time" name="hora_inicio" class="form-control rounded-pill" required value="{{ old('hora_inicio') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="hora_fin" class="form-label">Hasta</label>
                <input type="time" name="hora_fin" class="form-control rounded-pill" required value="{{ old('hora_fin') }}">
            </div>
        </div>

        <div class="text-end">
            <a href="{{ route('admin.horarios.index') }}" class="btn btn-outline-secondary rounded-pill">Cancelar</a>
            <button type="submit" class="btn btn-secondary rounded-pill px-4">Guardar</button>
        </div>
    </form>
</div>

@endsection