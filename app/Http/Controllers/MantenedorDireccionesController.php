<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Direccion;

class MantenedorDireccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $direcciones = Direccion::all();
        return view('MantenedorDirecciones/index')->with('direcciones', $direcciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MantenedorDirecciones/modalVerAgregar');
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
        $direccion = new Direccion();
        $direccion->nombre = $datos['nombre'];
        $direccion->observacion = $datos['observacion'];
        $direccion->save();
        return 'direccion_guardada';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $direccion = Direccion::find($id);
        return view('MantenedorDirecciones/modalVerDireccion')->with('direccion', $direccion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $direccion = Direccion::find($id);
        return view('MantenedorDirecciones/modalVerEditar')->with('direccion', $direccion);
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
        $direccion = Direccion::find($id);
        $direccion->nombre = $datos['nombre'];
        $direccion->observacion = $datos['observacion'];
        $direccion->save();
        return 'direccion_actualizada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Direccion::find($id)->delete();
        return 'direccion_eliminada';
    }
}
