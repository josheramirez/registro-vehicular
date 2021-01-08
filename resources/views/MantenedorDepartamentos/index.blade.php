@extends('layouts.master')
@section('content')

{{-- CARGA DE PLUGINS PARA DATATABLES --}}
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/datatables/jquery.dataTables.min.css')}}">

{{-- CARGA DE PLUGINS PARA BOOTSTRAP SELECT JQUERY --}}
<link rel="stylesheet" href="{{asset('plugins/bootstrap-select/css/bootstrap-select.min.css')}}">
<script src="{{asset('plugins/bootstrap-select/js/bootstrap-select.min.js')}}"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Departamentos del sistema</div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <button type="button" class="btn btn-success btn-sm float-right verAgregar" title="Creación de usuario" onclick="verAgregar()"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="tabla_departamentos" class="display compact text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <!-- <th>Activo</th> -->
                                        <th>Observación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($departamentos as $departamento)
                                    <tr>
                                        <td>{{$departamento->nombre}}</td>
                                        <td>{{$departamento->observacion}}</td>
                                        <td style="text-align:center">
                                            <button type="button" class="btn btn-primary btn-sm verInstitucion" name="{{$departamento->id}}" title="Información del usuario" onclick="verInstitucion(this.name)"><i class="fas fa-info-circle"></i></button>
                                            <button type="button" class="btn btn-warning btn-sm verEditar" name="{{$departamento->id}}" title="Edición de usuario" onclick="verEditar(this.name)"><i class="fas fa-edit"></i></button>
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

<div id="modal"></div>

<script>
    $(document).ready(function() {
        $('#tabla_departamentos').DataTable({
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
        ruta = @json(route('mantenedor_departamentos.create', ['mantenedor_departamento' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function(data) {
            $('#modal').html(data);
            $('#modalVerAgregar').modal('show');
        });
    };

    function verInstitucion(id) {
        $(".verInstitucion").attr('disabled', true);
        ruta = @json(route('mantenedor_departamentos.show', ['mantenedor_departamento' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function(data) {
            $('#modal').html(data);
            $('#modalVerDireccion').modal('show');
        });
    };

    function verEditar(id) {
        $(".verEditar").attr('disabled', true);
        ruta = @json(route('mantenedor_departamentos.edit', ['mantenedor_departamento' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function(data) {
            $('#modal').html(data);
            $('#modalVerEditar').modal('show');
        });
    };

    function verEliminar(id) {
        $(".verEliminar").attr('disabled', true);
        ruta = @json(route('mantenedor_departamentos.show', ['mantenedor_departamento' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function(data) {
            $('#modal').html(data);
            $('#modalVerEliminar').modal('show');
        });
    };
</script>

@endsection