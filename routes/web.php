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
    return view('auth/login');
});

Auth::routes();

route::group(['middleware' => 'auth'], function () {
    
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/mantenedor_usuarios', 'MantenedorUsuariosController@index')->name('mantenedorusuarios.index');

    Route::get('/mantenedor_usuarios/inactivos', 'MantenedorUsuariosController@inactivos')->name('mantenedorusuarios.inactivos');

    Route::get('/mantenedor_usuarios/revertir/{id}', 'MantenedorUsuariosController@revertir')->name('mantenedorusuarios.revertir');

    Route::get('/mantenedor_usuarios/ver_agregar/{id}', 'MantenedorUsuariosController@verAgregar')->name('mantenedorusuarios.veragregar');

    Route::post('/mantenedor_usuarios/agregar', 'MantenedorUsuariosController@agregar')->name('mantenedorusuarios.agregar');

    Route::get('/mantenedor_usuarios/ver_info/{id}', 'MantenedorUsuariosController@verInfo')->name('mantenedorusuarios.verusuario');

    Route::get('/mantenedor_usuarios/ver_editar/{id}', 'MantenedorUsuariosController@verEditar')->name('mantenedorusuarios.vereditar');

    Route::post('/mantenedor_usuarios/editar', 'MantenedorUsuariosController@editar')->name('mantenedorusuarios.editar');

    Route::get('/mantenedor_usuarios/ver_eliminar/{id}', 'MantenedorUsuariosController@verEliminar')->name('mantenedorusuarios.vereliminar');

    Route::post('/mantenedor_usuarios/eliminar', 'MantenedorUsuariosController@eliminar')->name('mantenedorusuarios.eliminar');

    Route::get('/mantenedor_usuarios/ver_historial/{id}', 'MantenedorUsuariosController@verHistorial')->name('mantenedorusuarios.verhistorial');

    Route::resource('mantenedor_insituciones', 'MantenedorInstitucionesController');
});
