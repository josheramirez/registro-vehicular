<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\User;

use App\Institucion;
use App\InstitucionUsuario;

use App\Direccion;
use App\DireccionUsuario;

use App\SubDireccion;
use App\SubDireccionUsuario;

use App\Unidad;
use App\UnidadUsuario;

use App\Departamento;
use App\DepartamentoUsuario;

use App\CambioUsuario;
use App\TipoUsuario;
use App\Helpers\utilidades;
use App\Rules\RutValido;

class MantenedorUsuariosController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('Roles:1');
    }

    public function index()
    {
        //SE OBTIENE LA LISTA DE USUARIOS ACTIVOS DEL SISTEMA, NO SE MUESTRA EL PROPIO USUARIO NI USUARIOS CON PERMISOS MAYOR AL USUARIO LOGEADO
        $logeado = Auth::user();
        $usuarios = User::select('users.id', 'users.name', 'users.email', 'users.email_old', 'users.telefono', 'users.activo', 'users.tipo_usuario', 'tipos_usuario.nombre as tipo_usuario_desc')
            ->where('users.activo', 1)
            ->where('users.id', '!=', $logeado->id)
            ->where('users.tipo_usuario', '>=', $logeado->tipo_usuario)
            ->join('tipos_usuario', 'users.tipo_usuario', '=', 'tipos_usuario.id')
            ->get();
        return view('mantenedorUsuarios/index')->with('usuarios', $usuarios);
    }

    public function verAgregar()
    {
        //SE OBTIENEN LOS PARAMETROS DEPARTAMENTOS Y TIPOS DE USUARIO NECESARIOS PARA EL FORMULARIO DE CREACION DE USUARIO Y SE RETORNA A LA VISTA CON ESTOS DATOS COMO PARAMETROS
        $departamentos = Departamento::all();
        $instituciones = Institucion::all();
        $direcciones = Direccion::all();
        $sub_direcciones = SubDireccion::all();
        $unidades = Unidad::all();
        $tipos_usuario = TipoUsuario::all();
        return view('mantenedorUsuarios/modalVerAgregar')
            ->with('departamentos', $departamentos)
            ->with('instituciones', $instituciones)
            ->with('direcciones', $direcciones)
            ->with('sub_direcciones', $sub_direcciones)
            ->with('unidades', $unidades)
            ->with('tipos_usuario', $tipos_usuario);
    }

    public function agregar(Request $request)
    {
        $rut = '/^([0-9]+)$/';

        //ASIGNA LOS DATOS DEL REQUEST A UNA NUEVA VARIABLE
        $data = $request->all();
        $validatedData = $request->validate(
            [
                'rut' => ['required', 'max:11', new RutValido($data['rut'], $data['dv'])],
                'name' => ['required', 'string', 'max:80'],
                'telefono' => ['required', 'digits_between:5,12'],
                'departamentos' => ['required'],
                'tipo_usuario' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'digits_between' => 'Este campo debe tener entre :min y :max digitos!',
            ]
        );

        //OBTIENE LOS CODIGOS DE TODOS LOS USUARIOS Y LOS GUARDA EN UN ARRAY
        $codigos = User::groupBy('codigo')->pluck('codigo')->toArray();

        //GENERA UN NUEVO CODIGO ALEATORIO DEL TIPO STRING Y DE LARGO 12 
        $nuevo_codigo = strtoupper(Str::random(12));

        //GENERA EL CODIGO INDEFINIDAMENTE HASTA QUE ESTE SEA UNO QUE NO ESTÉ EN EL ARRAY DE CODIGOS
        while (in_array($nuevo_codigo, $codigos)) {
            $nuevo_codigo = strtoupper(Str::random(12));
        }

        //OBTIENE EL USUARIO LOGEADO
        $logeado = Auth::user();



        //SE PROCEDE A LA CREACION DE USUARIO
        $usuario = new User();
        $usuario->rut = $data['rut'];
        $usuario->dv = $data['dv'];
        $usuario->codigo = $nuevo_codigo;
        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->telefono = $data['telefono'];
        $usuario->activo = 1;
        $usuario->tipo_usuario = $data['tipo_usuario'];
        //SE GENERA LA CONTRASEÑA GENERICA DEL USUARIO, SE ELIMINAN POSIBLES TILDES EN EL NOMBRE DEL USUARIO YA QUE LA CONTRASEÑA SE CONBSTRUYE SEGUN EL NOMBRE DEL USUARIO
        $nueva_pw = substr(utilidades::eliminarTildes($data['name']), 0, 2) . '.123456';
        $nueva_pw = $nueva_pw;
        $usuario->password =  Hash::make($nueva_pw);
        $usuario->save();

        if (isset($data['instituciones'])) {
            foreach ($data['instituciones'] as $institucion) {
                $inst = new InstitucionUsuario();
                $inst->usuario_id = $usuario->id;
                $inst->institucion_id = $institucion;
                $inst->creador_id = $logeado->id;
                $inst->save();
            }
        }

        if (isset($data['direcciones'])) {
            foreach ($data['direcciones'] as $direccion) {
                $dir = new DireccionUsuario();
                $dir->usuario_id = $usuario->id;
                $dir->direccion_id = $direccion;
                $dir->creador_id = $logeado->id;
                $dir->save();
            }
        }

        if (isset($data['sub_direcciones'])) {
            foreach ($data['sub_direcciones'] as $sub_direccion) {
                $sub_dir = new SubDireccionUsuario();
                $sub_dir->usuario_id = $usuario->id;
                $sub_dir->sub_direccion_id = $sub_direccion;
                $sub_dir->creador_id = $logeado->id;
                $sub_dir->save();
            }
        }

        if (isset($data['unidades'])) {
            foreach ($data['unidades'] as $unidad) {
                $uni = new UnidadUsuario();
                $uni->usuario_id = $usuario->id;
                $uni->unidad_id = $unidad;
                $uni->creador_id = $logeado->id;
                $uni->save();
            }
        }

        //SE PROCEDE A LA ASIGNACION DE DEPARTAMENTOS, DONDE SE GUARDA EL USUARIO, EL O LOS DEPARTAMENTOS A LOS CUALES PERTENECE EL USUARIO Y EL USUARIO CREADOR.
        $departamentos = $data['departamentos'];
        foreach ($departamentos as $dp) {
            $du = new DepartamentoUsuario();
            $du->usuario_id = $usuario->id;
            $du->departamento_id = $dp;
            $du->creador_id = $logeado->id;
            $du->save();
        }

        return 'usuario_creado';
    }

    public function verInfo($id)
    {
        //SE OBTIENE LA INFORMACION DE USUARIO NECESARIA PARA MOSTRAR EN LA VENTANA DE INFORMACION DE USUARIO
        $usuario = User::find($id);
        $du = DepartamentoUsuario::where('usuario_id', $id)->get();
        return view('mantenedorUsuarios/modalVerUsuario')->with('usuario', $usuario)->with('du', $du);
    }

    public function verHistorial($id)
    {
        $usuario = User::find($id);


        //SE BUSCA TODOS LOS CAMBIOS QUE HA SUFRIDO EL USUARIO, SE USA COMO REFERENCIA EL CODIGO, EL CUAL ES UNICO Y NO MODIFICABLE
        $historial = User::where('codigo', $usuario->codigo)->select('id', 'codigo', 'name', 'email', 'email_old', 'telefono', 'activo', 'tipo_usuario')->get();

        $codigos = $historial->pluck('id')->toArray();

        $cambios = CambioUsuario::whereIn('usuario_antiguo', $codigos)->get();

        foreach ($cambios as $key => $ca) {
            $cambios[$key]['usuarios'] = $ca->obtenerUsuarios();
            $cambios[$key]['fecha_cambio'] = utilidades::fechaVistas($ca->created_at);
            $cambios[$key]['actual'] =  $cambios[$key]['usuarios'][1];
            $cambios[$key]['antiguo'] =  $cambios[$key]['usuarios'][0];

            $cambios[$key]['actual_departamentos'] =  $cambios[$key]['actual']->obtenerDepartamentos();
            $cambios[$key]['antiguo_departamentos'] =  $cambios[$key]['antiguo']->obtenerDepartamentos();
        }

        return view('mantenedorUsuarios/modalVerHistorial')->with('usuario', $usuario)->with('historial', $cambios);
    }

    public function verEditar($id)
    {
        //OBTIENE LA INFORMACION DEL USUARIO
        $usuario = User::find($id);

        //OBTIENE PARAMETROS DE INSTITUCIONES Y LAS INSTITUCIONES DEL USUARIO. ESTO SE REPITE PARA CADA PARAMETRO
        $instituciones = Institucion::all();
        $iu = InstitucionUsuario::where('usuario_id', $id)->pluck('institucion_id')->toArray();
        
        $direcciones = Direccion::all();
        $diu = DireccionUsuario::where('usuario_id', $id)->pluck('direccion_id')->toArray();

        $sub_direcciones = SubDireccion::all();
        $sdiu = SubDireccionUsuario::where('usuario_id', $id)->pluck('sub_direccion_id')->toArray();

        $departamentos = Departamento::all();
        $du = DepartamentoUsuario::where('usuario_id', $id)->pluck('departamento_id')->toArray();

        $unidades = Unidad::all();
        $uu = UnidadUsuario::where('usuario_id', $id)->pluck('unidad_id')->toArray();

        $tipos_usuario = TipoUsuario::all();
        return view('mantenedorUsuarios/modalVerEditar')
            ->with('usuario', $usuario)
            ->with('instituciones', $instituciones)
            ->with('direcciones', $direcciones)
            ->with('sub_direcciones', $sub_direcciones)
            ->with('departamentos', $departamentos)
            ->with('unidades', $unidades)
            ->with('iu', $iu)
            ->with('diu', $diu)
            ->with('sdiu', $sdiu)
            ->with('du', $du)
            ->with('uu', $uu)
            ->with('tipos_usuario', $tipos_usuario);
    }

    public function editar(Request $request)
    {
        $data = $request->all();
        $validatedData = $request->validate(
            [
                'rut' => ['required', 'max:11', new RutValido($data['rut'], $data['dv'])],
                'name' => ['required', 'string', 'max:80'],
                'telefono' => ['required', 'digits_between:5,12'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,NULL,id,deleted_at,NUL'],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'digits_between' => 'Este campo debe tener entre :min y :max digitos!'
            ]
        );

        //OBTIENE AL USUARIO LOGEADO (MODIFICADOR)
        $logeado = Auth::user();
        //OBTIENE EL USUARIO A EDITAR (ANTIGUO)
        $usuario = User::find($data['usuario_id']);
        //COPIO AL USUARIO ANTIGUO Y CREA AL NUEVO

        $usuario->rut = $data['rut'];
        $usuario->dv = $data['dv'];
        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->telefono = $data['telefono'];
        $usuario->tipo_usuario = $data['tipo_usuario'];
        $usuario->activo = 1;

        if(isset($data['instituciones'])){
            $cambio_institucion = $this->evaluarCambioInstituciones($usuario, $data['instituciones']);
        }else{
            $cambio_institucion = $this->evaluarCambioInstituciones($usuario, []);
        }

        if(isset($data['direcciones'])){
            $cambio_direccion = $this->evaluarCambioDirecciones($usuario, $data['direcciones']);
        }else{
            $cambio_direccion = $this->evaluarCambioDirecciones($usuario, []);
        }

        if(isset($data['sub_direcciones'])){
            $cambio_sub_direccion = $this->evaluarCambioSubDirecciones($usuario, $data['sub_direcciones']);
        }else{
            $cambio_sub_direccion = $this->evaluarCambioSubDirecciones($usuario, []);
        }
       
        if(isset($data['departamentos'])){
            $cambio_departamento = $this->evaluarCambioDepartamentos($usuario, $data['departamentos']);
        }else{
            $cambio_departamento = $this->evaluarCambioDepartamentos($usuario, []);
        }

        if(isset($data['unidades'])){
            $cambio_unidad = $this->evaluarCambioUnidades($usuario, $data['unidades']);
        }else{
            $cambio_unidad = $this->evaluarCambioUnidades($usuario, []);
        }
        
        if (!$cambio_institucion && !$cambio_direccion  && !$cambio_sub_direccion  && !$cambio_departamento  && !$cambio_unidad && count($usuario->getDirty()) == 0) {
            return 'sin_cambios';
        } else {
            $usuario = User::find($data['usuario_id']);
            $usuario_nuevo = $usuario->replicate();
            //OBTIENE EL EMAIL DEL USUARIO, YA QUE EL CAMPO EMAIL ES UNICO
            $email = $usuario->email;
            //ASIGNO EL EMAIL A UNA COLUMNA NO UNICA
            $usuario->email_old =  $email;
            //DEJA NULO EL CAMPO EMAIL Y DESACTIVA AL USUARIO
            $usuario->email = NULL;
            $usuario->activo = 0;
            $usuario->save();

            //CONSTRUYE AL USUARIO NUEVO
            $usuario_nuevo->rut = $data['rut'];
            $usuario_nuevo->dv = $data['dv'];
            $usuario_nuevo->name = $data['name'];
            $usuario_nuevo->email = $data['email'];
            $usuario_nuevo->telefono = $data['telefono'];
            $usuario_nuevo->email =  $email;
            $usuario_nuevo->email_old = NULL;
            $usuario_nuevo->tipo_usuario = $data['tipo_usuario'];
            $usuario_nuevo->activo = 1;
            $usuario_nuevo->save();

            //SE CREA EL OBJETO QUE GUARDA LA INFORMACION DE LOS CAMBIOS EN BD
            $cambio_usuario = new CambioUsuario();
            $cambio_usuario->usuario_antiguo = $usuario->id;
            $cambio_usuario->usuario_actual = $usuario_nuevo->id;
            $cambio_usuario->usuario_modificador = $logeado->id;
            $cambio_usuario->observacion = 'ACTUALIZADO';
            $cambio_usuario->save();

            //PARA CADA INSTITUCION, DIRECCION, DEPARTAMENTO, ETC. SE ELIMINAR LAS DEL USUARIO ANTERIOR U LUEGO SE ASIGNAN LAS NUEVAS
            //ESTO SE REALIZA PARA CADA MODIFICACION DE USUARIO, AUNQUE NO SE MODIFIQUEN INSTITUCION, DIRECCION, DEPARTAMENTO, ETC.
            //EL CAMBIO SE REALIZA IGUAL, YA QUE ESTOS DATOS ESTÁN ASIGNADOS AL USUARIO ANTIGUO (REGISTRO ANTIGUO DEL USUARIO)
            InstitucionUsuario::where('usuario_id', $data['usuario_id'])->delete();

            //UNA VEZ ELIMINADOS, SE PROCEDE A LA ASIGNACION DE LOS VALORES AL NUEVO REGISTRO DEL USUARIO ACTUALIZADO
            if(isset($data['instituciones'])){
                foreach ($data['instituciones'] as $institucion) {
                    $inst = new InstitucionUsuario();
                    $inst->usuario_id = $usuario_nuevo->id;
                    $inst->institucion_id = $institucion;
                    $inst->creador_id = $logeado->id;
                    $inst->save();
                }
            }
           
            //ESTO SE REPITE PARA INSTITUCION, DIRECCION, DEPARTAMENTO, ETC.
            if(isset($data['direcciones'])){
            DireccionUsuario::where('usuario_id', $data['usuario_id'])->delete();
            foreach ($data['direcciones'] as $direccion) {
                $dir = new DireccionUsuario();
                $dir->usuario_id = $usuario_nuevo->id;
                $dir->direccion_id = $direccion;
                $dir->creador_id = $logeado->id;
                $dir->save();
            }
        }

        if(isset($data['sub_direcciones'])){
            SubDireccionUsuario::where('usuario_id', $data['usuario_id'])->delete();
            foreach ($data['sub_direcciones'] as $sub_direccion) {
                $sub_dir = new SubDireccionUsuario();
                $sub_dir->usuario_id = $usuario_nuevo->id;
                $sub_dir->sub_direccion_id = $sub_direccion;
                $sub_dir->creador_id = $logeado->id;
                $sub_dir->save();
            }
        }

        if(isset($data['unidades'])){
            UnidadUsuario::where('usuario_id', $data['usuario_id'])->delete();
            foreach ($data['unidades'] as $unidad) {
                $uni = new UnidadUsuario();
                $uni->usuario_id = $usuario_nuevo->id;
                $uni->unidad_id = $unidad;
                $uni->creador_id = $logeado->id;
                $uni->save();
            }
        }
        if(isset($data['departamentos'])){
            DepartamentoUsuario::where('usuario_id', $data['usuario_id'])->delete();
            foreach ($data['departamentos'] as $dp) {
                $du = new DepartamentoUsuario();
                $du->usuario_id = $usuario_nuevo->id;
                $du->departamento_id = $dp;
                $du->creador_id = $logeado->id;
                $du->save();
            }
        }

        }

        return 'usuario_actualizado';
    }

    public function verEliminar($id)
    {
        $usuario = User::find($id);
        return view('mantenedorUsuarios/modalVerEliminar')->with('usuario', $usuario);
    }

    public function eliminar(Request $request)
    {
        $datos = $request->all();
        $usuario = User::find($datos['usuario_id']);
        $usuario->activo = 0;
        $usuario->email_old = $usuario->email;
        $usuario->email = NULL;
        $usuario->save();

        $cambio_usuario = new CambioUsuario();
        $cambio_usuario->usuario_antiguo = $usuario->id;
        $cambio_usuario->usuario_actual = $usuario->id;
        $cambio_usuario->usuario_modificador = Auth::user()->id;
        $cambio_usuario->observacion = 'ELIMINADO';
        $cambio_usuario->save();

        return 'usuario_eliminado';
    }

    public function inactivos()
    {
        //OBTIENE LOS CODIGOS DE LOS USUARIOS ACTIVOS DEL SISTEMA
        $usuarios_activos = User::groupBy('codigo')->where('activo', 1)->pluck('codigo')->toArray();

        //OBTIENE EL USUARIO LOGEADO EN EL SISTEMA
        $logeado = Auth::user();

        //OBTIENE LOS USUARIOS INACTIVOS DEL SISTEMA, SE TRAEN LOS USUARIOS QUE NO ESTEN ACTIVOS, SEAN INACTIVOS, QUE NO SEA EL USUARIO LOGEADO (OBVIAMENTE) Y QUE TENGAN MENOR JERARQUIA DE PERMISOS.
        $usuarios = User::orderBy('users.id', 'desc')
            ->select('users.id', 'users.codigo', 'users.name', 'users.email', 'users.email_old', 'users.telefono', 'users.activo', 'users.tipo_usuario', 'tipos_usuario.nombre as tipo_usuario_desc')
            ->whereNotIn('codigo', $usuarios_activos)
            ->where('users.activo', 0)
            ->where('users.id', '!=', $logeado->id)
            ->where('users.tipo_usuario', '>=', $logeado->tipo_usuario)
            ->join('tipos_usuario', 'users.tipo_usuario', '=', 'tipos_usuario.id')
            ->get();

        // $usuarios = User::orderBy('id', 'desc')->where('activo', 0)->whereNotIn('codigo', $usuarios_activos)->get();

        //SE AGRUPAN POR CODIGO DE USUARIO
        $usuarios = $usuarios->groupBy('codigo');

        //DEFINE UNA NUEVA COLECCION
        $inactivos = collect();

        //EN CADA UNO DE LOS GRUPOS GENERADOS PREVIAMENTE EL PRIMER VALOR ES EL CAMBIO MAS RECIENTE O, EN SIMPLES PALABRAS, ES EL USUARIO MAS ACTUALIZADO QUE ESTUVO ACTIVO.
        foreach ($usuarios as $u) {
            //SE INGRESA EL USUARIO MAS ACTUALIZADO QUE ESTUVO ACTIVO A LA NUEVA COLECCION.
            $inactivos->push($u[0]);
        }
        return view('mantenedorUsuarios/inactivos')->with('inactivos', $inactivos);
    }

    public function revertir($id)
    {
        $usuario = User::find($id);

        $usuario_nuevo = $usuario->replicate();
        $usuario_nuevo->email = $usuario_nuevo->email_old;
        $usuario_nuevo->email_old = NULL;
        $usuario_nuevo->activo = 1;
        $usuario_nuevo->save();

        $cambio_usuario = new CambioUsuario();
        $cambio_usuario->usuario_antiguo = $usuario->id;
        $cambio_usuario->usuario_actual = $usuario_nuevo->id;
        $cambio_usuario->usuario_modificador = Auth::user()->id;
        $cambio_usuario->observacion = 'RECUPERADO';
        $cambio_usuario->save();

        //ELIMINA LOS DEPARTAMENTOS DEL USUARIO ANTIGUO
        $departamentos_antiguos = DepartamentoUsuario::where('usuario_id', $id)->get();

        //ASIGNA LOS DEPARTAMENTOS PARA LE NUEVO USUARIO
        foreach ($departamentos_antiguos as $da) {
            $dn = $da->replicate();
            $dn->usuario_id = $usuario_nuevo->id;
            $dn->creador_id = Auth::user()->id;
            $dn->save();
            $da->delete();
        }

         //ELIMINA LOS DEPARTAMENTOS DEL USUARIO ANTIGUO
         $instituciones_antiguas = InstitucionUsuario::where('usuario_id', $id)->get();
        
         //ASIGNA LOS DEPARTAMENTOS PARA LE NUEVO USUARIO
         foreach ($instituciones_antiguas as $ia) {
             $in = $ia->replicate();
             $in->usuario_id = $usuario_nuevo->id;
             $in->creador_id = Auth::user()->id;
             $in->save();
             $ia->delete();
         }

        return 'usuario_recuperado';
    }

    public static function evaluarCambioInstituciones($antiguo, $actualizado)
    {
        if ($antiguo->obtenerInstitucionesId() == implode(',', $actualizado)) {
            return false;
        } else {
            return true;
        }
    }

    public static function evaluarCambioDirecciones($antiguo, $actualizado)
    {
        if ($antiguo->obtenerDireccionesId() == implode(',', $actualizado)) {
            return false;
        } else {
            return true;
        }
    }

    public static function evaluarCambioSubDirecciones($antiguo, $actualizado)
    {
        if ($antiguo->obtenerSubDireccionesId() == implode(',', $actualizado)) {
            return false;
        } else {
            return true;
        }
    }

    public static function evaluarCambioDepartamentos($antiguo, $actualizado)
    {
        if ($antiguo->obtenerDepartamentosId() == implode(',', $actualizado)) {
            return false;
        } else {
            return true;
        }
    }

    public static function evaluarCambioUnidades($antiguo, $actualizado)
    {
        if ($antiguo->obtenerUnidadesId() == implode(',', $actualizado)) {
            return false;
        } else {
            return true;
        }
    }
}
