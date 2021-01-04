<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'codigo' => Str::random(12),
            'name' => 'Administrador',
            'email' => 'admin@admin.cl',
            'telefono' => '12345678',
            'active' => 1,
            'password' => Hash::make('123456')
        ]);

        DB::table('departamentos_usuarios')->insert([
            'usuario_id' => 1,
            'departamento_id' => 1,
            'creador_id' => 1
        ]);

        DB::table('departamentos_usuarios')->insert([
            'usuario_id' => 1,
            'departamento_id' => 2,
            'creador_id' => 1
        ]);

        DB::table('departamentos_usuarios')->insert([
            'usuario_id' => 1,
            'departamento_id' => 3,
            'creador_id' => 1
        ]);

        DB::table('users')->insert([
            'codigo' => Str::random(12),
            'name' => 'Funcionario',
            'email' => 'funcionario@funcionario.cl',
            'telefono' => '12345678',
            'active' => 1,
            'password' => Hash::make('123456')
        ]);

        DB::table('departamentos_usuarios')->insert([
            'usuario_id' => 2,
            'departamento_id' => 1,
            'creador_id' => 1
        ]);

        DB::table('departamentos_usuarios')->insert([
            'usuario_id' => 2,
            'departamento_id' => 2,
            'creador_id' => 1
        ]);
      
    }
}
