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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5>Otros detalles del usuario ID : {{$usuario->id}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 offset-1">
                        <h5>Jerarquía institucional</h5>
                        <ul class="mt-3">
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

                    <div class="col-md-10 offset-1 mt-3">
                        <h5>Permisos de usuario</h5>
                            <table class="table table-bordered text-center mt-3" id="tabla_permisos">
                                <thead>
                                    <tr>
                                        <th>Módulo</th>
                                        <th>Leer</th>
                                        <th>Crear</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modulos as $modulo)
                                    <tr>
                                        <td>{{$modulo->nombre}}</td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="permiso_leer_{{$modulo->id}}" name="modulo_{{$modulo->id}}[]"
                                                    value="leer" @if(!empty($modulos_usuario->toArray()) &&
                                                isset($modulos_usuario[$modulo->id]) &&
                                                $modulos_usuario[$modulo->id]['leer'] == 1) checked
                                                @endif>
                                                <label class="custom-control-label"
                                                    for="permiso_leer_{{$modulo->id}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="permiso_crear_{{$modulo->id}}" name="modulo_{{$modulo->id}}[]"
                                                    value="crear" @if(!empty($modulos_usuario->toArray()) &&
                                                isset($modulos_usuario[$modulo->id]) &&
                                                $modulos_usuario[$modulo->id]['crear'] == 1) checked
                                                @endif>
                                                <label class="custom-control-label"
                                                    for="permiso_crear_{{$modulo->id}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="permiso_editar_{{$modulo->id}}" name="modulo_{{$modulo->id}}[]"
                                                    value="editar" @if(!empty($modulos_usuario->toArray()) &&
                                                isset($modulos_usuario[$modulo->id]) &&
                                                $modulos_usuario[$modulo->id]['editar'] == 1)
                                                checked @endif>
                                                <label class="custom-control-label"
                                                    for="permiso_editar_{{$modulo->id}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="permiso_eliminar_{{$modulo->id}}"
                                                    name="modulo_{{$modulo->id}}[]" value="eliminar"
                                                    @if(!empty($modulos_usuario->toArray()) &&
                                                isset($modulos_usuario[$modulo->id]) &&
                                                $modulos_usuario[$modulo->id]['eliminar'] == 1)
                                                checked @endif>
                                                <label class="custom-control-label"
                                                    for="permiso_eliminar_{{$modulo->id}}"></label>
                                            </div>
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
<script type="text/javascript" src="{!! asset('/js/utilidades.js') !!}"></script>
<script>
    $(document).ready(function () {
        $(".otrosDetalles").attr('disabled', false);
        $("#tabla_permisos *").prop('disabled',true); 
    });

</script>
