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
            'nombre' => 'UPIT' 
        ]);

        DB::table('unidades')->insert([
            'nombre' => 'DTI' 
        ]);

        DB::table('unidades')->insert([
            'nombre' => 'Unidad 3' 
        ]);

        DB::table('unidades')->insert([
            'nombre' => 'Unidad 4' 
        ]);
    }
}
