<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class InstitucionUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'instituciones_usuarios';

    //OBTIENE EL DEPARTAMENTO CORRESPONDIENTE AL OBJETO INSTITUCION USUARIO
    public function obtenerInstitucion()
    {
        return $this->hasOne('App\Institucion', 'id', 'institucion_id')->first();
    }
}
