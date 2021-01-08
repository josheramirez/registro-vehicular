<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubDireccion;

class MantenedorSubDireccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_direcciones = SubDireccion::all();
        return view('MantenedorSubDirecciones/index')->with('sub_direcciones', $sub_direcciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MantenedorSubDirecciones/modalVerAgregar');
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
        $sub_direccion = new SubDireccion();
        $sub_direccion->nombre = $datos['nombre'];
        $sub_direccion->observacion = $datos['observacion'];
        $sub_direccion->save();
        return 'sub_direccion_guardada';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sub_direccion = SubDireccion::find($id);
        return view('MantenedorSubDirecciones/modalVerSubDireccion')->with('sub_direccion', $sub_direccion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sub_direccion = SubDireccion::find($id);
        return view('MantenedorSubDirecciones/modalVerEditar')->with('sub_direccion', $sub_direccion);
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
        $sub_direccion = SubDireccion::find($id);
        $sub_direccion->nombre = $datos['nombre'];
        $sub_direccion->observacion = $datos['observacion'];
        $sub_direccion->save();
        return 'sub_direccion_actualizada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubDireccion::find($id)->delete();
        return 'sub_direccion_eliminada';
    }
}