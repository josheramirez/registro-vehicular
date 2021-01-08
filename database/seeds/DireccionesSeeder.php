<?php

use Illuminate\Database\Seeder;

class DireccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('direcciones')->insert([
            'nombre' => 'Dirección del trabajo',
            'observacion' => 'Orientación trabajadores' 
        ]);

        DB::table('direcciones')->insert([
            'nombre' => 'Dirección Dos',
            'observacion' => 'Descripción Dirección Dos' 
        ]);

        DB::table('direcciones')->insert([
            'nombre' => 'Dirección Tres',
            'observacion' => 'Descripción Dirección Tres' 
        ]);

        DB::table('direcciones')->insert([
            'nombre' => 'Dirección Cuatro',
            'observacion' => 'Descripción Dirección Cuatro'   
        ]);
    }
}
