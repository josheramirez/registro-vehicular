<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CambioUsuario extends Model
{
    protected $table = 'cambios_usuarios';

    public function obtenerUsuarios()
    {
        $usuarios = collect();
        $usuarios->push($this->hasOne('App\User', 'id', 'usuario_antiguo')->select('name','email','email_old','telefono','active')->first());
        $usuarios->push($this->hasOne('App\User', 'id', 'usuario_actual')->select('name','email','email_old','telefono','active')->first());
        $usuarios->push($this->hasOne('App\User', 'id', 'usuario_modificador')->select('name','email','email_old','telefono','active')->first());
        return $usuarios;
    }
}
