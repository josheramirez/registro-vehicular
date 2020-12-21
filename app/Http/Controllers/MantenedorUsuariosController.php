<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class MantenedorUsuariosController extends Controller
{
    public function index(){
        return view('mantenedorUsuarios/index')->with('usuarios',User::all());
    }
}
