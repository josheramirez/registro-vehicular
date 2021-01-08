<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo', 'name', 'email', 'password', 'activo', 'tipo_usuario',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //FUNCION QUE RETORNA UN ARRAY CON LA INFORMACION DE LOS DEPARTAMENTOS A LOS QUE PERTENECE EL USUARIO
    public function obtenerDepartamentos()
    {
        $departamentos = $this->hasMany('App\DepartamentoUsuario', 'usuario_id', 'id')->withTrashed()->select('id', 'usuario_id', 'departamento_id', 'creador_id')->get();
        $string = '';
        foreach ($departamentos as $dp) {
            $dp['nombre_departamento'] = $dp->obtenerDepartamento()->nombre;
            $string = $string . $dp->obtenerDepartamento()->nombre . ', ';
        }
        $string = substr($string, 0, -2);
        return $string;
    }

    public function obtenerDepartamentosId()
    {
        $departamentos = $this->hasMany('App\DepartamentoUsuario', 'usuario_id', 'id')->withTrashed()->pluck('departamento_id')->toArray();
        return implode(",", $departamentos);
    }

    //FUNCION QUE OBTIENE LA INFORMACION DEL CAMBIO CORRESPONDIENTE AL USUARIO
    public function obtenerCambio()
    {
        $cambio = $this->hasOne('App\CambioUsuario', 'usuario_actual', 'id')->select('id', 'usuario_antiguo', 'usuario_actual', 'usuario_modificador', 'created_at', 'observacion')->first();
        return $cambio;
    }

    //FUNCION QUE RETORNA EL TIPO DE USUARIO DEL USUARIO
    public function obtenerTipoUsuario()
    {
        $tipo_usuario = $this->hasOne('App\TipoUsuario', 'id', 'tipo_usuario')->first();
        return $tipo_usuario;
    }
}
