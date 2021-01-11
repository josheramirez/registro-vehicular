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

</style>

<div id="modalVerOtrosDetalles" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5>Otros detalles del usuario ID : {{$usuario->id}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <ul>
                    <li>
                        Instituciones :
                        <ul>
                            @if(is_string($usuario->obtenerInstituciones()))
                            <li>{{$usuario->obtenerInstituciones()}}</li>
                            @else
                            @foreach($usuario->obtenerInstituciones() as $ins)
                            <li>{{$ins->nombre_institucion}}</li>
                            @endforeach
                            @endif
                           
                        </ul>
                    </li>
                    <li>
                        Direcciones :
                        <ul>
                            @if(is_string($usuario->obtenerDirecciones()))
                            <li>{{$usuario->obtenerDirecciones()}}</li>
                            @else
                            @foreach($usuario->obtenerDirecciones() as $dir)
                            <li>{{$dir->nombre_direccion}}</li>
                            @endforeach
                            @endif
                          
                        </ul>
                    </li>
                    <li>
                        Sub Direcciones :
                        <ul>
                            @if(is_string($usuario->obtenerSubDirecciones()))
                            <li>{{$usuario->obtenerSubDirecciones()}}</li>
                            @else
                            @foreach($usuario->obtenerSubDirecciones() as $sdir)
                            <li>{{$sdir->nombre_sub_direccion}}</li>
                            @endforeach
                            @endif
                          
                        </ul>
                    </li>
                    <li>
                        Departamentos :
                        <ul>
                            @if(is_string($usuario->obtenerDepartamentos()))
                            <li>{{$usuario->obtenerDepartamentos()}}</li>
                            @else
                            @foreach($usuario->obtenerDepartamentos() as $dp)
                            <li>{{$dp->nombre_departamento}}</li>
                            @endforeach
                            @endif
                           
                        </ul>
                    </li>
                    <li>
                        Unidades :
                        <ul>
                            @if(is_string($usuario->obtenerUnidades()))
                            <li>{{$usuario->obtenerUnidades()}}</li>
                            @else
                            @foreach($usuario->obtenerUnidades() as $uni)
                            <li>{{$uni->nombre_unidad}}</li>
                            @endforeach
                            @endif
                          
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="{!! asset('/js/utilidades.js') !!}"></script>
<script>
    $(document).ready(function () {
        $(".otrosDetalles").attr('disabled', false);
    });

</script>
