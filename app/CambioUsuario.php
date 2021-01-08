<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CambioUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'cambios_usuarios';

    //OBTIENE LOS USUARIOS PARTICIPANTES EN EL CAMBIO
    public function obtenerUsuarios()
    {
        $usuarios = collect();
        $usuarios->push($this->hasOne('App\User', 'id', 'usuario_antiguo')->select('id','name','email','email_old','telefono','activo','tipo_usuario')->first());
        $usuarios->push($this->hasOne('App\User', 'id', 'usuario_actual')->select('id','name','email','email_old','telefono','activo','tipo_usuario')->first());
        $usuarios->push($this->hasOne('App\User', 'id', 'usuario_modificador')->select('id','name','email','email_old','telefono','activo','tipo_usuario')->first());
        return $usuarios;
    }

    //OBTIENE INFORMACION DEL USUARIO MODIFICADOR, SE PODRÍA HABER USADO LA ANTERIOR
    public function obtenerModificador()
    {
        return $this->hasOne('App\User', 'id', 'usuario_modificador')->select('name','email','email_old','telefono','activo')->first();
    }
}
