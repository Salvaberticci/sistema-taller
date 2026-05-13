<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@taller.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Mecánico Pro',
            'email' => 'mecanico@taller.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'mechanic',
        ]);

        User::create([
            'name' => 'Recepcionista',
            'email' => 'recepcion@taller.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'receptionist',
        ]);

        $this->call([
            DemoDataSeeder::class,
        ]);
    }
}
