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
            'codigo' => strtoupper(Str::random(12)),
            'rut' => 11111111,
            'dv' => '1',
            'name' => 'Administrador',
            'email' => 'admin@admin.cl',
            'telefono' => '12345678',
            'activo' => 1,
            'tipo_usuario' => 1,
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
            'codigo' => strtoupper(Str::random(12)),
            'rut' => 22222222,
            'dv' => '2',
            'name' => 'Funcionario',
            'email' => 'funcionario@funcionario.cl',
            'telefono' => '12345678',
            'activo' => 1,
            'tipo_usuario' => 2,
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
