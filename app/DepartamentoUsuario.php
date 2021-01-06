<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartamentoUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'departamentos_usuarios';
    protected $fillable = ['usuario_modificado','usuario_modificador'];

    //OBTIENE EL DEPARTAMENTO CORRESPONDIENTE AL OBJETO DEPARTAMENTO USUARIO
    public function obtenerDepartamento()
    {
        return $this->hasOne('App\Departamento', 'id', 'departamento_id')->first();
    }
}
