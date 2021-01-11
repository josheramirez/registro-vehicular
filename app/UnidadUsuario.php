<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UnidadUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'unidades_usuarios';

     //OBTIENE EL DEPARTAMENTO CORRESPONDIENTE AL OBJETO UNIDADES USUARIO
     public function obtenerUnidad()
     {
         return $this->hasOne('App\Unidad', 'id', 'unidad_id')->first();
     }
}
