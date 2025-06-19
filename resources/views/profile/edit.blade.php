@extends('layouts.app')

@section('header')
<h2 class="h4 font-weight-bold mb-0 text-dark">
    {{ __('Perfil de Usuario') }}
</h2>
@endsection

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 space-y-4"> {{-- Formulario para actualizar información del perfil --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body"> @include('profile.partials.update-profile-information-form') </div>
            </div>

            {{-- Formulario para actualizar contraseña --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Formulario para eliminar cuenta --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div> @endsection