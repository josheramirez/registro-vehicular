<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Departamento;
use App\DepartamentoUsuario;
use App\CambioUsuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\TipoUsuario;

class MantenedorUsuariosController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('Roles:1');
    }

    public function index()
    {
        $usuarios = User::where('activo', 1)->get();
        return view('mantenedorUsuarios/index')->with('usuarios', $usuarios);
    }

    public function verAgregar()
    {
        $departamentos = Departamento::all();
        $tipos_usuario = TipoUsuario::all();
        return view('mantenedorUsuarios/modalVerAgregar')->with('departamentos', $departamentos)->with('tipos_usuario', $tipos_usuario);
    }

    public function agregar(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => ['required', 'string', 'max:80'],
                'telefono' => ['required', 'digits_between:5,12'],
                'departamentos' => ['required'],
                'tipo_usuario' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'digits_between' => 'Este campo debe tener entre :min y :max digitos!'
            ]
        );

        $codigos = User::groupBy('codigo')->pluck('codigo')->toArray();
        $nuevo_codigo = strtoupper(Str::random(12));


        while (in_array($nuevo_codigo, $codigos)) {
            $nuevo_codigo = strtoupper(Str::random(12));
        }

        $logeado = Auth::user();
        $data = $request->all();
        $usuario = new User();
        $usuario->codigo = $nuevo_codigo;
        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->telefono = $data['telefono'];
        $usuario->activo = 1;
        $usuario->tipo_usuario = $data['tipo_usuario'];
        $nueva_pw = substr($this->eliminar_acentos($data['name']), 0, 2) . '.123456';
        $nueva_pw = $nueva_pw;
        $usuario->password =  Hash::make($nueva_pw);
        $usuario->save();

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
        $usuario = User::find($id);
        $du = DepartamentoUsuario::where('usuario_id', $id)->get();
        return view('mantenedorUsuarios/modalVerUsuario')->with('usuario', $usuario)->with('du', $du);
    }

    public function verHistorial($id)
    {
        $usuario = User::find($id);
        $historial = User::where('codigo', $usuario->codigo)->select('id', 'codigo', 'name', 'email', 'email_old', 'telefono', 'activo', 'tipo_usuario')->get();
        foreach ($historial as $key => $his) {
            $historial[$key]['departamentos'] = $his->obtenerDepartamentos();
            if ($his->obtenerCambio()) {
                $cambio = $his->obtenerCambio();
                $historial[$key]['modificador'] = $cambio->obtenerModificador();
                $historial[$key]['fecha_cambio'] = $this->fechaVistas($cambio->created_at);
            } else {
                $historial[$key]['modificador'] = null;
                $historial[$key]['fecha_cambio'] = null;
            }
            $historial[$key]['tipo_usuario'] = $his->obtenerTipoUsuario()->nombre;
        }
        return view('mantenedorUsuarios/modalVerHistorial')->with('usuario', $usuario)->with('historial', $historial);
    }

    public function verEditar($id)
    {
        $usuario = User::find($id);
        $departamentos = Departamento::all();
        $du = DepartamentoUsuario::where('usuario_id', $id)->pluck('departamento_id')->toArray();
        $tipos_usuario = TipoUsuario::all();
        return view('mantenedorUsuarios/modalVerEditar')->with('usuario', $usuario)->with('departamentos', $departamentos)
            ->with('du', $du)
            ->with('tipos_usuario', $tipos_usuario);
    }

    public function editar(Request $request)
    {
        $data = $request->all();
        $validatedData = $request->validate(
            [
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
        $cambio_usuario->save();

        //ELIMINA LOS DEPARTAMENTOS DEL USUARIO ANTIGUO
        $du = DepartamentoUsuario::where('usuario_id', $data['usuario_id'])->delete();

        //ASIGNA LOS DEPARTAMENTOS PARA LE NUEVO USUARIO
        $departamentos = $data['departamentos'];
        foreach ($departamentos as $dp) {
            $du = new DepartamentoUsuario();
            $du->usuario_id = $usuario_nuevo->id;
            $du->departamento_id = $dp;
            $du->creador_id = $logeado->id;
            $du->save();
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
        $usuario->save();
        return 'usuario_eliminado';
    }

    public function inactivos()
    {
        $usuarios_activos = User::groupBy('codigo')->where('activo', 1)->pluck('codigo')->toArray();

        $usuarios = User::orderBy('id', 'desc')->where('activo', 0)->whereNotIn('codigo', $usuarios_activos)->get();
        $usuarios = $usuarios->groupBy('codigo');
        $inactivos = collect();
        foreach ($usuarios as $u) {
            $inactivos->push($u[0]);
        }
        return view('mantenedorUsuarios/inactivos')->with('inactivos', $inactivos);
    }

    public function revertir($id)
    {
        $usuario = User::find($id);
        $usuario->activo = 1;
        $usuario->save();
        return 'usuario_recuperado';
    }

    public function eliminar_acentos($cadena)
    {

        //Reemplazamos la A y a
        $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena
        );

        //Reemplazamos la I y i
        $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena
        );

        //Reemplazamos la O y o
        $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena
        );

        //Reemplazamos la U y u
        $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena
        );

        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $cadena
        );

        return $cadena;
    }

    public static function fechaVistas($fecha)
    {
        $fecha = explode(' ', $fecha)[0];
        $fecha = join('/', array_reverse(explode('-', $fecha)));
        return $fecha;
    }
}
