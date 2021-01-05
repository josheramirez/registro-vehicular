<?php

use Illuminate\Database\Seeder;

class TipoUsuario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_usuario')->insert([
            'nombre' => 'Administrador',
            'activo' => 1
        ]);

        DB::table('tipos_usuario')->insert([
            'nombre' => 'Funcionario',
            'activo' => 1
        ]);
    }
}
