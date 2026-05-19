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
            'nombres' => 'Admin',
            'apellidos' => 'Marents',
            'email' => 'admin@marents.com',
            'password' => bcrypt('password'),
            'rol' => 'admin',
            'documento' => '123456789',
            'celular' => '3001234567'
        ]);

        User::create([
            'nombres' => 'Cliente',
            'apellidos' => 'Prueba',
            'email' => 'cliente@marents.com',
            'password' => bcrypt('password'),
            'rol' => 'cliente',
            'documento' => '987654321',
            'celular' => '3007654321'
        ]);
    }
}
