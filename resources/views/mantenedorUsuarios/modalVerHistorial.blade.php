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
                            <table class="table table-bordered table-sm text-center">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>E-mail</th>
                                        <th>Teléfono</th>
                                        <th>Departamentos</th>
                                        <th>Modificador</th>
                                        <th>Fecha modificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historial as $key1 => $his)

                                    @if($his['active']==1)
                                    <tr style="color:green; font-weight: bold;">
                                    @else
                                    <tr>
                                    @endif
                                    
                                        <td>{{$his['name']}}</td>

                                        @if($his['active']==1)
                                        <td>{{$his['email']}}</td>
                                        @else
                                        <td>{{$his['email_old']}}</td>
                                        @endif

                                        <td>{{$his['telefono']}}</td>

                                        <td>
                                            <ul style="margin-bottom: 0;">
                                                @foreach($his['departamentos'] as $dp)
                                                <li>{{$dp['nombre_departamento']}}</li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        @if($his['modificador'])
                                        <td>{{$his['modificador']['name']}}</td>
                                        @else
                                        <td></td>
                                        @endif

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