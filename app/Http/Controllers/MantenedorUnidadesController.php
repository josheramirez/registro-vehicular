<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;

class MantenedorUnidadesController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidades = Unidad::all();
        return view('MantenedorUnidades/index')->with('unidades', $unidades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MantenedorUnidades/modalVerAgregar');
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
        $unidad = new Unidad();
        $unidad->nombre = $datos['nombre'];
        $unidad->observacion = $datos['observacion'];
        $unidad->save();
        return 'unidad_guardada';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unidad = Unidad::find($id);
        return view('MantenedorUnidades/modalVerUnidad')->with('unidad', $unidad);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unidad = Unidad::find($id);
        return view('MantenedorUnidades/modalVerEditar')->with('unidad', $unidad);
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
        $unidad = Unidad::find($id);
        $unidad->nombre = $datos['nombre'];
        $unidad->observacion = $datos['observacion'];
        $unidad->save();
        return 'unidad_actualizada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unidad::find($id)->delete();
        return 'unidad_eliminada';
    }
}
