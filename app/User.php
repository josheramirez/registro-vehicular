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

    //FUNCION QUE RETORNA UN ARRAY CON LA INFORMACION DE LOS INSTITUCIONES A LOS QUE PERTENECE EL USUARIO
    public function obtenerInstituciones()
    {
        $instituciones = $this->hasMany('App\InstitucionUsuario', 'usuario_id', 'id')->withTrashed()->select('id', 'usuario_id', 'institucion_id', 'creador_id')->get();
        $string = '';
        foreach ($instituciones as $ins) {
            $institucion = $ins->obtenerInstitucion();
            $ins['nombre_institucion'] = $institucion->nombre;
            $string = $string . $institucion->nombre . ', ';
        }
        if (count($instituciones)>0) {
            return $instituciones;
        } else {
            return  "SIN INFORMACIÓN";
        };
    }

    //FUNCION QUE RETORNA UN ARRAY CON LA INFORMACION DE LOS DIRECCIONES A LOS QUE PERTENECE EL USUARIO
    public function obtenerDirecciones()
    {
        $direcciones = $this->hasMany('App\DireccionUsuario', 'usuario_id', 'id')->withTrashed()->select('id', 'usuario_id', 'direccion_id', 'creador_id')->get();
        $string = '';
        foreach ($direcciones as $dir) {
            $direccion = $dir->obtenerDireccion();
            $dir['nombre_direccion'] = $direccion->nombre;
            $string = $string . $direccion->nombre . ', ';
        }
        $string = substr($string, 0, -2);
        if (count($direcciones)>0) {
            return $direcciones;
        } else {
            return  "SIN INFORMACIÓN";
        };
    }

    //FUNCION QUE RETORNA UN ARRAY CON LA INFORMACION DE LOS SUB DIRECCIONES A LOS QUE PERTENECE EL USUARIO
    public function obtenerSubDirecciones()
    {
        $sub_direcciones = $this->hasMany('App\SubDireccionUsuario', 'usuario_id', 'id')->withTrashed()->select('id', 'usuario_id', 'sub_direccion_id', 'creador_id')->get();
        $string = '';
        foreach ($sub_direcciones as $sdir) {
            $sub_direccion = $sdir->obtenerSubDireccion();
            $sdir['nombre_sub_direccion'] = $sub_direccion->nombre;
            $string = $string . $sub_direccion->nombre . ', ';
        }
        $string = substr($string, 0, -2);
        if (count($sub_direcciones)>0) {
            return $sub_direcciones;
        } else {
            return  "SIN INFORMACIÓN";
        };
    }

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
        if (count($departamentos)>0) {
            return $departamentos;
        } else {
            return  "SIN INFORMACIÓN";
        };
    }

    //FUNCION QUE RETORNA UN ARRAY CON LA INFORMACION DE LAS UNIDADES A LAS QUE PERTENECE EL USUARIO
    public function obtenerUnidades()
    {
        $unidades = $this->hasMany('App\UnidadUsuario', 'usuario_id', 'id')->withTrashed()->select('id', 'usuario_id', 'unidad_id', 'creador_id')->get();
        $string = '';
        foreach ($unidades as $uni) {
            $unidad = $uni->obtenerUnidad();
            $uni['nombre_unidad'] = $unidad->nombre;
            $string = $string . $unidad->nombre . ', ';
        }
        $string = substr($string, 0, -2);
        if (count($unidades)>0) {
            return $unidades;
        } else {
            return "SIN INFORMACIÓN";
        };
    }

    public function obtenerDepartamentosId()
    {
        $departamentos = $this->hasMany('App\DepartamentoUsuario', 'usuario_id', 'id')->withTrashed()->pluck('departamento_id')->toArray();
        return implode(",", $departamentos);
    }

    public function obtenerInstitucionesId()
    {
        $instituciones = $this->hasMany('App\InstitucionUsuario', 'usuario_id', 'id')->withTrashed()->pluck('institucion_id')->toArray();
        return implode(",", $instituciones);
    }

    public function obtenerDireccionesId()
    {
        $direcciones = $this->hasMany('App\DireccionUsuario', 'usuario_id', 'id')->withTrashed()->pluck('direccion_id')->toArray();
        return implode(",", $direcciones);
    }

    public function obtenerSubDireccionesId()
    {
        $sub_direcciones = $this->hasMany('App\SubDireccionUsuario', 'usuario_id', 'id')->withTrashed()->pluck('sub_direccion_id')->toArray();
        return implode(",", $sub_direcciones);
    }

    public function obtenerUnidadesId()
    {
        $unidades = $this->hasMany('App\UnidadUsuario', 'usuario_id', 'id')->withTrashed()->pluck('unidad_id')->toArray();
        return implode(",", $unidades);
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
