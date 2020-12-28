<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Departamento;
use App\DepartamentoUsuario;
use Illuminate\Support\Facades\Auth;

class MantenedorUsuariosController extends Controller
{
    public function index()
    {
        return view('mantenedorUsuarios/index')->with('usuarios', User::all());
    }

    public function verAgregar()
    {
        $departamentos = Departamento::all();
        return view('mantenedorUsuarios/modalVerAgregar')->with('departamentos',$departamentos);
    }

    public function agregar(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => ['required', 'string', 'max:80'],
                'telefono' => ['required', 'digits_between:5,12'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'digits_between' => 'Este campo debe tener entre :min y :max digitos!'
            ]
        );

        $logeado = Auth::user();
        $data = $request->all();
        $usuario = new User();
        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->telefono = $data['telefono'];
        $nueva_pw = substr($this->eliminar_acentos($data['name']), 0, 2) . '.123456';
        $nueva_pw = $nueva_pw;
        $usuario->password =  Hash::make($nueva_pw);
        $usuario->save();

        $departamentos = $data['departamentos'];
        foreach($departamentos as $dp){
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
        $du = DepartamentoUsuario::where('usuario_id',$id)->get();
        return view('mantenedorUsuarios/modalVerUsuario')->with('usuario', $usuario)->with('du', $du);
    }

    public function verEditar($id)
    {
        $usuario = User::find($id);
        $departamentos = Departamento::all();
        $du = DepartamentoUsuario::where('usuario_id',$id)->pluck('departamento_id')->toArray();
        return view('mantenedorUsuarios/modalVerEditar')->with('usuario', $usuario)->with('departamentos',$departamentos)->with('du',$du);
    }

    public function editar(Request $request)
    {
        $data = $request->all();
        $validatedData = $request->validate(
            [
                'name' => ['required', 'string', 'max:80'],
                'telefono' => ['required', 'digits_between:5,12'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'digits_between' => 'Este campo debe tener entre :min y :max digitos!'
            ]
        );
        $logeado = Auth::user();
        $usuario = User::find($data['usuario_id']);
        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->telefono = $data['telefono'];
        $usuario->save();

        $du = DepartamentoUsuario::where('usuario_id',$data['usuario_id'])->delete();

        $departamentos = $data['departamentos'];
        foreach($departamentos as $dp){
            $du = new DepartamentoUsuario();
            $du->usuario_id = $usuario->id;
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
        User::find($datos['usuario_id'])->delete();
        return 'usuario_eliminado';
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

    
}
