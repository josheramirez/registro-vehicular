<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CambioUsuario extends Model
{
    protected $table = 'cambios_usuarios';

    //OBTIENE LOS USUARIOS PARTICIPANTES EN EL CAMBIO
    public function obtenerUsuarios()
    {
        $usuarios = collect();
        $usuarios->push($this->hasOne('App\User', 'id', 'usuario_antiguo')->select('name','email','email_old','telefono','activo')->first());
        $usuarios->push($this->hasOne('App\User', 'id', 'usuario_actual')->select('name','email','email_old','telefono','activo')->first());
        $usuarios->push($this->hasOne('App\User', 'id', 'usuario_modificador')->select('name','email','email_old','telefono','activo')->first());
        return $usuarios;
    }

    //OBTIENE INFORMACION DEL USUARIO MODIFICADOR, SE PODRÍA HABER USADO LA ANTERIOR
    public function obtenerModificador()
    {
        return $this->hasOne('App\User', 'id', 'usuario_modificador')->select('name','email','email_old','telefono','activo')->first();
    }
}
