<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@barberia.com',
            'password' => Hash::make('password'),
            'role' => 'administrador'
        ]);
    
        User::create([
            'name' => 'Juan Barber',
            'email' => 'personal@barberia.com',
            'password' => Hash::make('password'),
            'role' => 'personal'
        ]);
    
        User::create([
            'name' => 'Carlos Cliente',
            'email' => 'cliente@barberia.com',
            'password' => Hash::make('password'),
            'role' => 'cliente'
        ]);
    }
}
