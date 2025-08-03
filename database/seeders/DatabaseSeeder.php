<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\Horario;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Insertar el admin siempre, manualmente (sin Faker)
        DB::table('users')->insert([
            'name'                  => 'Admin',
            'email'                 => 'admin@barberiaplus.com',
            'password'              => Hash::make('password'),
            'rol'                   => 'administrador',
            'must_change_password'  => true,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);
        // 3) Si quieres, dejar aquí otros inserciones estáticas que no usen Faker...
    }
}