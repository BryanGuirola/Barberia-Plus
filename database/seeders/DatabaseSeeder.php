<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\Horario;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear administrador
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@barberiaplus.com',
            'password' => Hash::make('password'),
            'rol' => 'administrador',
            'must_change_password' => true,
        ]);

        // Crear encargados fijos
        $encargados = collect();
        for ($i = 1; $i <= 5; $i++) {
            $encargados->push(User::factory()->create([
                'name' => "Encargado $i",
                'email' => "encargado$i@barberiaplus.com",
                'password' => Hash::make('password'),
                'rol' => 'encargado',
                'must_change_password' => true,
            ]));
        }

        // Crear 10 servicios fijos
        $servicios = [
            ['nombre' => 'Corte Clásico', 'duracion_min' => 30, 'precio' => 5.00],
            ['nombre' => 'Corte Degradado', 'duracion_min' => 40, 'precio' => 6.00],
            ['nombre' => 'Barba Completa', 'duracion_min' => 25, 'precio' => 4.00],
            ['nombre' => 'Perfilado de Cejas', 'duracion_min' => 15, 'precio' => 2.50],
            ['nombre' => 'Corte + Barba', 'duracion_min' => 60, 'precio' => 9.00],
            ['nombre' => 'Tinte Capilar', 'duracion_min' => 50, 'precio' => 7.50],
            ['nombre' => 'Alisado Exprés', 'duracion_min' => 45, 'precio' => 8.00],
            ['nombre' => 'Limpieza Facial', 'duracion_min' => 30, 'precio' => 6.00],
            ['nombre' => 'Tratamiento Capilar', 'duracion_min' => 35, 'precio' => 6.50],
            ['nombre' => 'Corte Infantil', 'duracion_min' => 25, 'precio' => 4.00],
        ];

        foreach ($servicios as $data) {
            Servicio::create($data);
        }

        // Crear 20 clientes
        $clientes = User::factory(20)->create([
            'rol' => 'cliente',
        ]);

        // Crear horarios lunes a viernes para cada encargado
        foreach ($encargados as $encargado) {
            foreach (['lunes', 'martes', 'miércoles', 'jueves', 'viernes'] as $dia) {
                Horario::create([
                    'encargado_id' => $encargado->id,
                    'dia_semana' => $dia,
                    'hora_inicio' => '08:00:00',
                    'hora_fin' => '16:00:00',
                    'activo' => true,
                ]);
            }
        }

        // Estados posibles
        $estados = ['pendiente', 'confirmada', 'cancelada', 'finalizada', 'rechazada', 'no_asistió', 'olvidada'];

        // Crear citas para los clientes con algunos datos pasados y con estados diversos
        foreach ($clientes as $cliente) {
            for ($i = 0; $i < rand(2, 5); $i++) {
                $encargado = $encargados->random();

                // 50% de probabilidad de que la cita esté en el pasado
                $esPasada = rand(0, 1) === 1;

                $fecha = $esPasada
                    ? Carbon::now()->subDays(rand(1, 15))->format('Y-m-d')
                    : Carbon::now()->addDays(rand(1, 15))->format('Y-m-d');

                $hora = rand(8, 15) . ':00:00';

                $estado = $esPasada
                    ? collect($estados)->except(['pendiente', 'confirmada'])->random()
                    : 'pendiente';

                $cita = Cita::create([
                    'cliente_id' => $cliente->id,
                    'encargado_id' => $encargado->id,
                    'fecha' => $fecha,
                    'hora' => $hora,
                    'estado' => $estado,
                ]);

                $cita->servicios()->attach(
                    Servicio::inRandomOrder()->limit(rand(1, 3))->pluck('id')->toArray()
                );
            }
        }

        echo "✔️ Base de datos poblada correctamente.\n";
    }
}
