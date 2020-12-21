@extends('layouts.master')

<script src="{{asset('plugins/jquery/jquery-3.5.1.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/datatables/jquery.dataTables.min.css')}}">

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Usuarios del sistema</div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <button type="button" class="btn btn-success float-right verAgregar"
                                title="Información solicitud" onclick="verAgregar()"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="tabla_usuarios">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>E-mail</th>
                                        <th>Activo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                    <tr>
                                        <td>{{$usuario->name}}</td>
                                        <td>{{$usuario->email}}</td>
                                        <td>{{$usuario->active}}</td>
                                        <td style="text-align:center">
                                            <button type="button" class="btn btn-primary verUsuario"
                                                name="{{$usuario->id}}" title="Información solicitud"
                                                onclick="verUsuario(this.name)"><i
                                                    class="fas fa-info-circle"></i></button>
                                            <button type="button" class="btn btn-warning verEditar"
                                                name="{{$usuario->id}}" title="Información solicitud"
                                                onclick="verEditar(this.name)"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger verEliminar"
                                                name="{{$usuario->id}}" title="Información solicitud"
                                                onclick="verEliminar(this.name)"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<div id="modal"></div>
<script>
    $(document).ready(function () {
        $('#tabla_usuarios').DataTable({
            language: {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar:",
                "processing": "Consultando...",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": '<i class="fas fa-chevron-right"></i>',
                    "previous": '<i class="fas fa-chevron-left"></i>'
                },
            },
        });
    });

    function verAgregar(id) {
        $(".verAgregar").attr('disabled', true);
        ruta = @json(route('mantenedorusuarios.veragregar', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function (data) {
            $('#modal').html(data);
            $('#modalVerAgregar').modal('show');
        });
    };

    function verUsuario(id) {
        $(".verUsuario").attr('disabled', true);
        ruta = @json(route('mantenedorusuarios.verusuario', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function (data) {
            $('#modal').html(data);
            $('#modalVerUsuario').modal('show');
        });
    };

    function verEditar(id) {
        $(".verEditar").attr('disabled', true);
        ruta = @json(route('mantenedorusuarios.vereditar', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function (data) {
            $('#modal').html(data);
            $('#modalVerEditar').modal('show');
        });
    };

    function verEliminar(id) {
        $(".verEliminar").attr('disabled', true);
        ruta = @json(route('mantenedorusuarios.vereliminar', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function (data) {
            $('#modal').html(data);
            $('#modalVerEliminar').modal('show');
        });
    };

</script>
