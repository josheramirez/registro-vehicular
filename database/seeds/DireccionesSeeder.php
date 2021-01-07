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
            'nombre' => 'Dirección 1' 
        ]);

        DB::table('direcciones')->insert([
            'nombre' => 'Dirección 2' 
        ]);

        DB::table('direcciones')->insert([
            'nombre' => 'Dirección 3' 
        ]);

        DB::table('direcciones')->insert([
            'nombre' => 'Dirección 4' 
        ]);
    }
}
