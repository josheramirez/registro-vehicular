<?php

use Illuminate\Database\Seeder;

class SubDireccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_direcciones')->insert([
            'nombre' => 'Sub Dirección',
            'observacion' => 'Descripción Sub Dirección Dos' 
        ]);

        DB::table('sub_direcciones')->insert([
            'nombre' => 'Sub Dirección Dos',
            'observacion' => 'Descripción Sub Dirección Dos'  
        ]);

        DB::table('sub_direcciones')->insert([
            'nombre' => 'Sub Dirección Tres',
            'observacion' => 'Descripción Sub Dirección Dos'  
        ]);

        DB::table('sub_direcciones')->insert([
            'nombre' => 'Sub Dirección Cuatro',
            'observacion' => 'Descripción Sub Dirección Dos'  
        ]);
    }
}
