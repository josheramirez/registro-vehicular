<?php

use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departamentos')->insert([
            'nombre' => 'Departamento de informática',
            'observacion' => 'Tecnologías de la información'
        ]);

        DB::table('departamentos')->insert([
            'nombre' => 'Departamento de estadísticas',
            'observacion' => 'Procesamiento de datos'
        ]);

        DB::table('departamentos')->insert([
            'nombre' => 'Departamento de recursos humanos',
            'observacion' => 'Gestión de las personas'
        ]);
    }
}
