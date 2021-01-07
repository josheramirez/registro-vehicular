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
            'nombre' => 'Sub Dirección 1' 
        ]);

        DB::table('sub_direcciones')->insert([
            'nombre' => 'Sub Dirección 2' 
        ]);

        DB::table('sub_direcciones')->insert([
            'nombre' => 'Sub Dirección 3' 
        ]);

        DB::table('sub_direcciones')->insert([
            'nombre' => 'Sub Dirección 4' 
        ]);
    }
}
