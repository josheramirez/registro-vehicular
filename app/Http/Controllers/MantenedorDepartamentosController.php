<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;

class MantenedorDepartamentosController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos = Departamento::all();
        return view('MantenedorDepartamentos/index')->with('departamentos', $departamentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MantenedorDepartamentos/modalVerAgregar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regLatino = '/^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$/';
        $validatedData = $request->validate(
            [
                'nombre' => ['required', 'string', 'max:80','regex:' . $regLatino],
                'observacion' => ['nullable','string', 'max:100','regex:' . $regLatino],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'max' => 'Este campo no debe tener mas de :max carácteres!',
                'nombre.regex' => "Este campo solo debe tener letras y espacios!",
                'observacion.regex' => "Este campo solo debe tener letras y espacios!"
            ]
        );

        $datos = $request->all();
        $departamento = new Departamento();
        $departamento->nombre = $datos['nombre'];
        $departamento->observacion = $datos['observacion'];
        $departamento->save();
        return 'departamento_guardada';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $departamento = Departamento::find($id);
        return view('MantenedorDepartamentos/modalVerDepartamento')->with('departamento', $departamento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $departamento = Departamento::find($id);
        return view('MantenedorDepartamentos/modalVerEditar')->with('departamento', $departamento);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $regLatino = '/^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$/';
        $validatedData = $request->validate(
            [
                'nombre' => ['required', 'string', 'max:80','regex:' . $regLatino],
                'observacion' => ['nullable','string', 'max:100','regex:' . $regLatino],
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'max' => 'Este campo no debe tener mas de :max carácteres!',
                'nombre.regex' => "Este campo solo debe tener letras y espacios!",
                'observacion.regex' => "Este campo solo debe tener letras y espacios!"
            ]
        );

        $datos = $request->all();
        $departamento = Departamento::find($id);
        $departamento->nombre = $datos['nombre'];
        $departamento->observacion = $datos['observacion'];
        $departamento->save();
        return 'departamento_actualizada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Departamento::find($id)->delete();
        return 'departamento_eliminada';
    }
}
