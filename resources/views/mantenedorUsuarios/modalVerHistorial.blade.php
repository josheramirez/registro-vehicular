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



<div id="modalVerHistorial" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                        <th>E-mail</th>
                                        <th>Teléfono</th>
                                        <th>Tipo de usuario</th>
                                        <th>Departamentos</th>
                                        <th>Acción</th>
                                        <th>Modificador</th>
                                        <th>Fecha modificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $inicial = $historial[0]['usuarios'][0]; @endphp
                                    <tr>
                                        <td>{{$inicial['name']}}</td>

                                        @if($inicial['activo']==1)
                                        <td>{{$inicial['email']}}</td>
                                        @else
                                        <td>{{$inicial['email_old']}}</td>
                                        @endif

                                        <td>{{$inicial['telefono']}}</td>

                                        <td>{{$inicial->obtenerTipoUsuario()->nombre}}</td>

                                        <td>{{$inicial->obtenerDepartamentos()}}</td>

                                        <td>NO APLICA</td>
                                        <td>NO APLICA</td>
                                        <td>NO APLICA</td>
                                    </tr>
                                    @foreach($historial as $key1 => $his)

                                    @if($his['usuarios'][1]['activo']==1)
                                    <tr style="color:green; font-weight: bold;">
                                        @else
                                    <tr>
                                        @endif

                                        <td>{{$his['usuarios'][1]['name']}}</td>

                                        @if($his['usuarios'][1]['activo']==1)
                                        <td>{{$his['usuarios'][1]['email']}}</td>
                                        @else
                                        <td>{{$his['usuarios'][1]['email_old']}}</td>
                                        @endif

                                        <td>{{$his['usuarios'][1]['telefono']}}</td>

                                        <td>{{$his['usuarios'][1]->obtenerTipoUsuario()->nombre}}</td>

                                        <td>{{$inicial->obtenerDepartamentos()}}</td>

                                        <td>{{$his['observacion']}}</td>

                                        <td>{{$his['usuarios'][2]['name']}}</td>


                                        @if($his['fecha_cambio'])
                                        <td>{{$his['fecha_cambio']}}</td>
                                        @else
                                        <td></td>
                                        @endif


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row" style="margin-top: -10px; margin-left:5px">
                            <b style="font-size: 12px; color:gray;">* La fila resaltada en color VERDE corresponde al usuario actualmente activo en el sistema.</b></label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{!! asset('/js/utilidades.js') !!}"></script>
<script>
    $(document).ready(function() {
        $(".verHistorial").attr('disabled', false);

    });
</script>