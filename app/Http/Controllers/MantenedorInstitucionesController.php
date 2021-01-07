<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institucion;

class MantenedorInstitucionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instituciones = Institucion::all();
        return view('MantenedorInstituciones/index')->with('instituciones',$instituciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MantenedorInstituciones/modalVerAgregar');
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
        $institucion = new Institucion();
        $institucion->nombre = $datos['nombre'];
        $institucion->observacion = $datos['observacion'];
        $institucion->save();
        return 'institucion_guardada';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $institucion = Institucion::find($id);
        return view('MantenedorInstituciones/modalVerInstitucion')->with('institucion',$institucion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institucion = Institucion::find($id);
        return view('MantenedorInstituciones/modalVerEditar')->with('institucion',$institucion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
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
        $institucion = Institucion::find($id);
        $institucion->nombre = $datos['nombre'];
        $institucion->observacion = $datos['observacion'];
        $institucion->save();
        return 'institucion_actualizada';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Institucion::find($id)->delete();
       return 'institucion_eliminada';
    }
}
