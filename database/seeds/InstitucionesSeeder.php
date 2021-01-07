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
            'nombre' => 'ONU',
            'observacion' => 'Organización Nacione Unidas'
        ]);

        DB::table('instituciones')->insert([
            'nombre' => 'SSMOC',
            'observacion' => 'Servicio Salud Metropolitano Occidente'
        ]);

        DB::table('instituciones')->insert([
            'nombre' => 'SSMS',
            'observacion' => 'Servicio Salud Metropolitano Sur'
        ]);

        DB::table('instituciones')->insert([
            'nombre' => 'SSMN',
            'observacion' => 'Servicio Salud Metropolitano Norte'
        ]);

        DB::table('instituciones')->insert([
            'nombre' => 'SSME',
            'observacion' => 'Servicio Salud Metropolitano Este'
        ]);
    }
}
