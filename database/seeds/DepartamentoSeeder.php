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
            'nombre' => 'Departamento de informática'
        ]);

        DB::table('departamentos')->insert([
            'nombre' => 'Departamento de estadísticas'
        ]);

        DB::table('departamentos')->insert([
            'nombre' => 'Departamento de recursos humanos'
        ]);
    }
}
