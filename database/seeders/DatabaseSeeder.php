<?php

namespace Database\Seeders;

use App\Models\Tipo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombre' => 'Jose Nieto',
            'cedula' => '',
            'celular' => '',
            'tipo' => Tipo::ADMIN,
            'email' => 'inge1neuro@gmail.com',
            'password' => \Hash::make('secret'),
        ]);

        User::factory(32)->create();
    }
}
