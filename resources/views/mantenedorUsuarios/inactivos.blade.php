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
                <div class="card-header">Usuarios Inactivos del sistema</div>

                <div class="card-body">

                    <div class="row">

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="tabla_usuarios" class="display compact text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>E-mail</th>
                                        <!-- <th>Activo</th> -->
                                        <th>Tipo de usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inactivos as $inactivo)
                                    <tr>
                                        <td>{{$inactivo->name}}</td>
                                        <td>{{$inactivo->email}}</td>
                                        <!-- @if($inactivo->activo==1)
                                        <td>SI</td>
                                        @else
                                        <td>NO</td>
                                        @endif -->
                                        <td>{{$inactivo->tipo_usuario_desc}}</td>
                                        <td style="text-align:center">
                                            <button type="button" class="btn btn-primary btn-sm verUsuario" name="{{$inactivo->id}}" title="Información del usuario" onclick="verUsuario(this.name)"><i class="fas fa-info-circle"></i></button>
                                            <button type="button" class="btn btn-success btn-sm revertirUsuario" name="{{$inactivo->id}}" title="Revertir/Reactivar usuario" onclick="revertirUsuario(this.name)"><i class="fa fa-history"></i></button>
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

    function verUsuario(id) {
        $(".verUsuario").attr('disabled', true);
        ruta = @json(route('mantenedorusuarios.verusuario', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $('.modal').modal('hide');
        $.get(ruta, function(data) {
            $('#modal').html(data);
            $('#modalVerUsuario').modal('show');
        });
    };

    function revertirUsuario(id) {
        $(".revertirUsuario").attr('disabled', true);
        ruta = @json(route('mantenedorusuarios.revertir', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        Swal.fire({
            title: '¿Está seguro de recuperar el usuario?',
            showDenyButton: true,
            confirmButtonText: 'Recuperar',
            denyButtonText: 'Cancelar',
            confirmButtonColor: '#28a745',
            denyButtonColor: '#007bff',
            onClose: () => {
                $(".revertirUsuario").attr('disabled', false);
            }
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: ruta,
                    success: function(data) {
                        console.log(data);
                        if (data == 'usuario_recuperado') {
                            let timerInterval
                            Swal.fire({
                                icon: 'success',
                                title: 'Usuario recuperado exitosamente',
                                html: 'Cerrando ventana en <b>5</b> segundos.',
                                timer: 5000,
                                timerProgressBar: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                    timerInterval = setInterval(() => {
                                        const content = Swal
                                            .getContent();
                                        if (content) {
                                            const b = content
                                                .querySelector('b');
                                            if (b) {

                                                b.textContent = Math
                                                    .round(Swal
                                                        .getTimerLeft() /
                                                        1000);
                                            }
                                        }
                                    }, 1000);
                                },
                                onClose: () => {
                                    clearInterval(timerInterval);
                                    location.reload();
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    console.log('I was closed by the timer')
                                }
                            });
                        }
                    },
                    error: function(error) {

                    }
                });
            }
        })


    };
</script>

@endsection