<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/mantenedorUSuarios','MantenedorUsuariosController@index')->name('mantenedorusuarios.index');

Route::get('/mantenedorUSuarios/ver_agregar/{id}','MantenedorUsuariosController@verAgregar')->name('mantenedorusuarios.veragregar');

Route::post('/mantenedorUSuarios/agregar','MantenedorUsuariosController@agregar')->name('mantenedorusuarios.agregar');

Route::get('/mantenedorUSuarios/ver_info/{id}','MantenedorUsuariosController@verInfo')->name('mantenedorusuarios.verusuario');

Route::get('/mantenedorUSuarios/ver_editar/{id}','MantenedorUsuariosController@verEditar')->name('mantenedorusuarios.vereditar');

Route::post('/mantenedorUSuarios/editar','MantenedorUsuariosController@editar')->name('mantenedorusuarios.editar');

Route::get('/mantenedorUSuarios/ver_eliminar/{id}','MantenedorUsuariosController@verEliminar')->name('mantenedorusuarios.vereliminar');