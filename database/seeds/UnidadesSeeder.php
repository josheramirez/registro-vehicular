<?php

use Illuminate\Database\Seeder;

class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades')->insert([
            'nombre' => 'UPIT',
            'observacion' => 'Unidad Desarrollo Dos'
        ]);

        DB::table('unidades')->insert([
            'nombre' => 'DTI',
            'observacion' => 'Unidad Desarrollo' 
        ]);

        DB::table('unidades')->insert([
            'nombre' => 'Unidad 3',
            'observacion' => 'Unidad Desarrollo Dos' 
        ]);

        DB::table('unidades')->insert([
            'nombre' => 'Unidad 4',
            'observacion' => 'Unidad Desarrollo Tres' 
        ]);
    }
}
