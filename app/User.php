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
        'codigo','name', 'email', 'password',
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

    public function obtenerDepartamentos()
    {
        // dd(DepartamentoUsuario::where('usuario_id',$this->id)->get());
        $departamentos = $this->hasMany('App\DepartamentoUsuario', 'usuario_id', 'id')->withTrashed()->select('id','usuario_id','departamento_id','creador_id')->get();
        foreach($departamentos as $dp){
            $dp['nombre_departamento'] = $dp->obtenerDepartamento()->nombre;
        }
        return $departamentos;
    }

    public function obtenerCambio()
    {
        // dd(DepartamentoUsuario::where('usuario_id',$this->id)->get());
        $modificador = $this->hasOne('App\CambioUsuario', 'usuario_actual', 'id')->select('id','usuario_antiguo','usuario_actual','usuario_modificador','created_at')->first();
        return $modificador;
    }
}
