<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MantenedorUsuariosController extends Controller
{
    public function index()
    {
        return view('mantenedorUsuarios/index')->with('usuarios', User::all());
    }

    public function verAgregar()
    {
        return view('mantenedorUsuarios/modalVerAgregar');
    }

    public function agregar(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'confirmed' => 'Las contraseñas deben ser iguales!'
            ]
        );

        $data = $request->all();

        $usuario = new User();
        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->password =  Hash::make($data['password']);
        $usuario->save();

        return 'usuario_creado';
    }
    public function verInfo($id)
    {
        $usuario = User::find($id);
        return view('mantenedorUsuarios/modalVerUsuario')->with('usuario', $usuario);
    }

    public function verEditar($id)
    {
        $usuario = User::find($id);
        return view('mantenedorUsuarios/modalVerEditar')->with('usuario', $usuario);
    }

    public function editar(Request $request)
    {
        $data = $request->all();
        $validatedData = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$data['usuario_id']]
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'email.unique' => 'El E-mail ya ha sido ingresado!'
            ]
        );

        $usuario = User::find($data['usuario_id']);
        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->save();

        return 'usuario_actualizado';
    }

    public function verEliminar($id)
    {
        $usuario = User::find($id);
        return view('mantenedorUsuarios/modalVerEliminar')->with('usuario', $usuario);
    }

    
}
