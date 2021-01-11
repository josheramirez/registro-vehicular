<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DireccionUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'direcciones_usuarios';

    //OBTIENE EL DEPARTAMENTO CORRESPONDIENTE AL OBJETO DIRECCION USUARIO
    public function obtenerDireccion()
    {
        return $this->hasOne('App\Direccion', 'id', 'direccion_id')->first();
    }
}
