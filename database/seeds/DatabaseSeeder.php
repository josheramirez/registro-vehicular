<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(InstitucionesSeeder::class);
        $this->call(DireccionesSeeder::class);
        $this->call(SubDireccionesSeeder::class);
        $this->call(UnidadesSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(TipoUsuarioSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ModulosSeeder::class);
    }
}
