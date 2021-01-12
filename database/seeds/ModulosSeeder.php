<?php

use Illuminate\Database\Seeder;

class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modulos')->insert([
            'nombre' => 'Mentenedor de usuarios',
            'observacion' => 'CRUD de usuarios'
        ]);

        DB::table('modulos')->insert([
            'nombre' => 'Mentenedor de usuarios inactivos',
            'observacion' => 'Recuperar usuarios eliminados'
        ]);

        DB::table('modulos')->insert([
            'nombre' => 'Mentenedor de instituciones',
            'observacion' => 'CRUD de instituciones'
        ]);
    }
}
