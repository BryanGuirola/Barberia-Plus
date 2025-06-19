<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleRedirectController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ClienteCitaController;
use App\Http\Controllers\EncargadoCitaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReporteController;
// Página principal
Route::get('/', function () {
    return view('welcome');
});

// Redireccionamiento general
Route::get('/dashboard', function () {
    return redirect('/role-redirect');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas comunes autenticadas
Route::middleware('auth')->group(function () {

    Route::get('/role-redirect', [RoleRedirectController::class, 'redirect']);
});

// Rutas para Administrador
Route::middleware(['auth', 'role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('servicios', ServicioController::class);
    Route::resource('horarios', HorarioController::class);
    Route::resource('usuarios', AdminController::class);
    Route::get('/citas/manual', [AdminController::class, 'crearCitaManualForm'])->name('citas.manual');
    Route::post('/citas/manual', [AdminController::class, 'guardarCitaManual'])->name('citas.manual.guardar');
    Route::get('/clientes/buscar', [AdminController::class, 'buscarCliente'])->name('clientes.buscar'); // para AJAX
    Route::get('/encargado-dias/{id}', [AdminController::class, 'diasEncargado']);
    Route::get('/horas-disponibles', [AdminController::class, 'horasDisponibles'])->name('horas');
    Route::get('/reportes/citas', [AdminReporteController::class, 'citas'])->name('reportes.citas');
    Route::get('/reportes/citas_pdf', [AdminReporteController::class, 'exportarPdf'])->name('reportes.citas.pdf');
    Route::patch('/horarios/{horario}/toggle', [HorarioController::class, 'toggleEstado'])->name('horarios.toggle');



});

// Rutas para Personal (Encargado)
Route::middleware(['auth', 'role:encargado'])->prefix('personal')->name('personal.')->group(function () {
    Route::get('/agenda', fn() => view('personal.dashboard'))->name('dashboard');
    Route::get('/citas', [EncargadoCitaController::class, 'index'])->name('citas.index');
    Route::put('/citas/{cita}/confirmar', [EncargadoCitaController::class, 'confirmar'])->name('citas.confirmar');
    Route::put('/citas/{cita}/finalizar', [EncargadoCitaController::class, 'finalizar'])->name('citas.finalizar');
    Route::put('/citas/{cita}/rechazar', [EncargadoCitaController::class, 'rechazar'])->name('citas.rechazar');
    Route::put('/citas/{cita}/no-asistio', [EncargadoCitaController::class, 'noAsistio'])->name('citas.no_asistio');
    Route::get('/citas/manual', [EncargadoCitaController::class, 'crearManual'])->name('citas.manual');
    Route::get('/clientes/buscar', [EncargadoCitaController::class, 'buscarCliente'])->name('clientes.buscar');
    Route::post('/citas/manual', [EncargadoCitaController::class, 'guardarCitaManual'])->name('citas.manual.guardar');
    Route::get('/dias-trabajo/{id}', [EncargadoCitaController::class, 'diasTrabajo'])->name('encargado.dias');
    Route::get('/horas-disponibles', [EncargadoCitaController::class, 'horasDisponibles'])->name('horas');
    Route::get('/servicios', [ServicioController::class, 'catalogoEncargado'])
    ->middleware(['auth', 'role:encargado'])
    ->name('servicios.catalogo');
    Route::get('/servicios', [ServicioController::class, 'catalogoEncargado'])->name('servicios');
   
});

// Rutas para Cliente
Route::middleware(['auth', 'role:cliente', 'must.change.password'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/perfil', fn() => view('cliente.dashboard'))->name('dashboard');

    Route::get('/citas', [ClienteCitaController::class, 'index'])->name('citas.index');
    Route::get('/citas/create', [ClienteCitaController::class, 'create'])->name('citas.create');
    Route::post('/citas', [ClienteCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{cita}/editar', [ClienteCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{cita}', [ClienteCitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{cita}', [ClienteCitaController::class, 'destroy'])->name('citas.destroy');
    Route::put('/citas/{cita}/cancelar', [ClienteCitaController::class, 'cancelar'])->name('citas.cancelar');

    Route::get('/horas-disponibles', [ClienteCitaController::class, 'horasDisponibles'])->name('citas.horas');
    Route::get('/encargado-dias/{id}', [ClienteCitaController::class, 'diasLaborales'])->name('encargado.dias');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::get('/servicios', [ServicioController::class, 'catalogoCliente'])
    ->middleware(['auth', 'role:cliente'])
    ->name('servicios.catalogo');
    Route::get('/servicios', [ServicioController::class, 'catalogoCliente'])->name('servicios');

    // Rutas de cambio de contraseña obligatorio
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

require __DIR__ . '/auth.php';
