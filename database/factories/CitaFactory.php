<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cita>
 */
class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
        'cliente_id' => User::factory(), // Reemplazado por seeder manual
        'encargado_id' => null,
        'fecha' => $this->faker->dateTimeBetween('-10 days', '+10 days')->format('Y-m-d'),
        'hora' => $this->faker->time('H:i'),
        'estado' => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada', 'finalizada']),
    ];
    }
}
