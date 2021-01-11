<style>
    .error {
        border: 1px dashed #f00;
    }

    input:-moz-read-only {
        /* For Firefox */
        background-color: white;
    }

    input:read-only {
        background-color: white;
    }

    td {
        vertical-align: middle !important;
    }

</style>



<div id="modalVerHistorial" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5>Historial usuario : {{$usuario->codigo}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 offset-md-1">

                        <div class="row">
                            <table class="table table-bordered table-sm text-center" style="font-size: 13.5px;">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Rut</th>
                                        <th>E-mail</th>
                                        <th>Teléfono</th>
                                        <th>Anexo</th>
                                        <th>Tipo de usuario</th>
                                        <th>Acción</th>
                                        <th>Modificador</th>
                                        <th>Fecha modificación</th>
                                        <th>Otros detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($historial) == 0)
                                    <td colspan="10">EL USUARIO NO RESGRISTRA CAMBIOS DE NINGÚN TIPO</td>
                                    @else
                                    @php $inicial = $historial[0]['antiguo']; @endphp
                                    <tr>
                                        <td>{{$inicial['name']}}</td>

                                        <td>{{$inicial['rut']}} - {{$inicial['dv']}}</td>

                                        @if($inicial['activo']==1)
                                        <td>{{$inicial['email']}}</td>
                                        @else
                                        <td>{{$inicial['email_old']}}</td>
                                        @endif

                                        <td>{{$inicial['telefono']}}</td>

                                        <td>{{$inicial['anexo']}}</td>

                                        <td>{{$inicial->obtenerTipoUsuario()->nombre}}</td>

                                        <td>NO APLICA</td>
                                        <td>NO APLICA</td>
                                        <td>NO APLICA</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm otrosDetalles"
                                                name="{{$inicial->id}}" title="Información del usuario"
                                                onclick="verOtrosDetalles(this.name)"><i
                                                    class="fas fa-search-plus"></i></button>

                                        </td>
                                    </tr>
                                    @foreach($historial as $key1 => $his)

                                    @if($his['actual'] ['activo']==1)
                                    <tr style="color:green; font-weight: bold;">
                                        @else
                                    <tr>
                                        @endif

                                        <td>{{$his['actual'] ['name']}}</td>
                                        <td>{{$his['actual'] ['rut']}} - {{$his['actual'] ['dv']}}</td>
                                        @if($his['actual'] ['activo']==1)
                                        <td>{{$his['actual'] ['email']}}</td>
                                        @else
                                        <td>{{$his['actual'] ['email_old']}}</td>
                                        @endif

                                        <td>{{$his['actual'] ['telefono']}}</td>
                                        <td>{{$his['actual'] ['anexo']}}</td>

                                        <td>{{$his['actual'] ->obtenerTipoUsuario()->nombre}}</td>


                                        <td>{{$his['observacion']}}</td>

                                        <td>{{$his['modificador']['name']}}</td>


                                        @if($his['fecha_cambio'])
                                        <td>{{$his['fecha_cambio']}}</td>
                                        @else
                                        <td></td>
                                        @endif

                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm otrosDetalles"
                                                name="{{$his['actual'] ->id}}" title="Información del usuario"
                                                onclick="verOtrosDetalles(this.name)"><i
                                                    class="fas fa-search-plus"></i></button>

                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>

                        <div class="row" style="margin-top: -10px; margin-left:5px">
                            <b style="font-size: 12px; color:gray;">* La fila resaltada en color VERDE corresponde al
                                usuario actualmente activo en el sistema.</b></label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{!! asset('/js/utilidades.js') !!}"></script>
<script>
    $(document).ready(function () {
        $(".verHistorial").attr('disabled', false);

    });

    function verOtrosDetalles(id) {
        console.log('detalles');
        $(".otrosDetalles").attr('disabled', true);
        ruta = @json(route('mantenedorusuarios.verotrosdetalles', ['id' => 'id_prof']));
        ruta = ruta.replace('id_prof', id);
        $.get(ruta, function (data) {
            $('#otros_detalles').html(data);
            $('#modalVerOtrosDetalles').modal('show');
        });
    }

</script>
