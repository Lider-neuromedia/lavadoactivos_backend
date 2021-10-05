<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
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

        $question1 = new Question(['description' => '¿Es es una pregunta válida?']);
        $question1->save();
        $question1->options()->saveMany([
            new Option(['description' => 'Si']),
            new Option(['description' => 'No']),
        ]);

        $question2 = new Question(['description' => '¿Cual de estos no es un color?']);
        $question2->save();
        $question2->options()->saveMany([
            new Option(['description' => 'Naranja']),
            new Option(['description' => 'Pera']),
            new Option(['description' => 'Azul']),
            new Option(['description' => 'Rojo']),
        ]);
    }
}
