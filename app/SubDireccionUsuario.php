<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubDireccionUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'sub_direcciones_usuarios';

    //OBTIENE EL DEPARTAMENTO CORRESPONDIENTE AL OBJETO SUB DIRECCIONES USUARIO
    public function obtenerSubDireccion()
    {
        return $this->hasOne('App\SubDireccion', 'id', 'sub_direccion_id')->first();
    }
}
