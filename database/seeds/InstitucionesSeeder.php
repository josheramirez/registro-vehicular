<?php

use Illuminate\Database\Seeder;

class InstitucionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('instituciones')->insert([
            'nombre' => 'SSMOC' 
        ]);

        DB::table('instituciones')->insert([
            'nombre' => 'SSMS'
        ]);

        DB::table('instituciones')->insert([
            'nombre' => 'SSMN'
        ]);

        DB::table('instituciones')->insert([
            'nombre' => 'SSME'
        ]);
    }
}
