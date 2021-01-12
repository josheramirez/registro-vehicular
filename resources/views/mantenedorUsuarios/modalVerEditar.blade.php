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



<div id="modalVerEditar" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5>Edición usuario ID : {{$usuario->id}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <form action="{{route('mantenedorusuarios.editar')}}" method="POST"
                            id="formulario_editar_usuario">
                            @csrf
                            <input type="hidden" name="usuario_id" id="usuario_id" value="{{$usuario->id}}">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <label for="rut">RUT </label>
                                            <input type="text" class="form-control" name="rut" id="rut"
                                                value="{{$usuario->rut}}">
                                        </div>
                                        <div class="col-md-3" style="margin-left: -5%;">
                                            <label for="dv">DV </label>
                                            <input type="text" class="form-control" name="dv" id="dv"
                                                value="{{$usuario->dv}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="name">Nombre </label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{$usuario->name}}">
                                </div>

                                <div class="col-md-6 mt-4">
                                    <label for="email">E-mail </label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        value="{{$usuario->email}}">
                                </div>

                                <div class="col-md-6 mt-4">
                                    <label for="telefono">Teléfono </label>
                                    <input type="text" class="form-control" name="telefono" id="telefono"
                                        value="{{$usuario->telefono}}">
                                </div>

                                <div class="col-md-6 mt-4">
                                    <label for="anexo">Anexo </label>
                                    <input type="text" class="form-control" name="anexo" id="anexo"
                                        value="{{$usuario->anexo}}">
                                </div>

                                <div class="col-md-12 mt-4">
                                    <label for="tipo_usuario">Tipo de usuario </label>
                                </div>
                                <div class="col-md-12" id="div_select_usuario">
                                    <select name="tipo_usuario" id="tipo_usuario" class="form-control">
                                        @foreach($tipos_usuario as $tu)
                                        @if($tu->id == $usuario->tipo_usuario))
                                        <option value="{{$tu->id}}" selected>{{$tu->nombre}}</option>
                                        @else
                                        <option value="{{$tu->id}}">{{$tu->nombre}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <label for="instituciones">Instituciones </label>
                                        </div>
                                        <div class="col-md-12" id="div_select_departamento">
                                            <select name="instituciones[]" id="instituciones" class="form-control"
                                                multiple>
                                                @foreach($instituciones as $institucion)
                                                @if(in_array($institucion->id,$iu))
                                                <option value="{{$institucion->id}}" selected>{{$institucion->nombre}}
                                                </option>
                                                @else
                                                <option value="{{$institucion->id}}">{{$institucion->nombre}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <span id="instituciones_span" style="color: red"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <label for="direcciones">Direcciones </label>
                                        </div>
                                        <div class="col-md-12" id="div_select_departamento">
                                            <select name="direcciones[]" id="direcciones" class="form-control" multiple>
                                                @foreach($direcciones as $direccion)
                                                @if(in_array($direccion->id,$diu))
                                                <option value="{{$direccion->id}}" selected>{{$direccion->nombre}}
                                                </option>
                                                @else
                                                <option value="{{$direccion->id}}">{{$direccion->nombre}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <span id="direcciones_span" style="color: red"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <label for="sub_direcciones">Sub direcciones </label>
                                        </div>
                                        <div class="col-md-12" id="div_select_departamento">
                                            <select name="sub_direcciones[]" id="sub_direcciones" class="form-control"
                                                multiple>
                                                @foreach($sub_direcciones as $sub_direccion)
                                                @if(in_array($sub_direccion->id,$sdiu))
                                                <option value="{{$sub_direccion->id}}" selected>
                                                    {{$sub_direccion->nombre}}</option>
                                                @else
                                                <option value="{{$sub_direccion->id}}">{{$sub_direccion->nombre}}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <span id="sub_direcciones_span" style="color: red"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <label for="departamentos">Departamentos </label>
                                        </div>
                                        <div class="col-md-12" id="div_select">
                                            <select name="departamentos[]" id="departamentos" class="form-control"
                                                multiple>
                                                @foreach($departamentos as $dp)
                                                @if(in_array($dp->id,$du))
                                                <option value="{{$dp->id}}" selected>{{$dp->nombre}}</option>
                                                @else
                                                <option value="{{$dp->id}}">{{$dp->nombre}}</option>
                                                @endif

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <span id="departamentos_span" style="color: red"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <label for="unidades">Unidades </label>
                                        </div>
                                        <div class="col-md-12" id="div_select_departamento">
                                            <select name="unidades[]" id="unidades" class="form-control" multiple>
                                                @foreach($unidades as $unidad)
                                                @if(in_array($unidad->id,$uu))
                                                <option value="{{$unidad->id}}" selected>{{$unidad->nombre}}</option>
                                                @else
                                                <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <span id="unidad_span" style="color: red"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <div class="row">
                                        <table class="table table-bordered text-center">
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
                                                                id="permiso_leer_{{$modulo->id}}"
                                                                name="modulo_{{$modulo->id}}[]" value="leer"
                                                                @if(!empty($modulos_usuario->toArray()) && isset($modulos_usuario[$modulo->id]) && $modulos_usuario[$modulo->id]['leer'] == 1) checked
                                                            @endif>
                                                            <label class="custom-control-label"
                                                                for="permiso_leer_{{$modulo->id}}"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="permiso_crear_{{$modulo->id}}"
                                                                name="modulo_{{$modulo->id}}[]" value="crear"
                                                                @if(!empty($modulos_usuario->toArray()) && isset($modulos_usuario[$modulo->id]) &&  $modulos_usuario[$modulo->id]['crear'] == 1) checked
                                                            @endif>
                                                            <label class="custom-control-label"
                                                                for="permiso_crear_{{$modulo->id}}"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="permiso_editar_{{$modulo->id}}"
                                                                name="modulo_{{$modulo->id}}[]" value="editar"
                                                                @if(!empty($modulos_usuario->toArray()) && isset($modulos_usuario[$modulo->id]) &&  $modulos_usuario[$modulo->id]['editar'] == 1)
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
                                                                @if(!empty($modulos_usuario->toArray()) && isset($modulos_usuario[$modulo->id]) &&  $modulos_usuario[$modulo->id]['eliminar'] == 1)
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

                            <div class="row mt-5">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<script type="text/javascript" src="{!! asset('/js/utilidades.js') !!}"></script>
<script>
    $(document).ready(function () {
        $(".verEditar").attr('disabled', false);
        $('#departamentos').selectpicker({
            'noneSelectedText': 'Seleccione Departamento',
            'multipleSeparator': ','
        });

        $('#instituciones').selectpicker({
            'noneSelectedText': 'Seleccione Institución',
            'multipleSeparator': ','
        });

        $('#direcciones').selectpicker({
            'noneSelectedText': 'Seleccione dirección',
            'multipleSeparator': ','
        });

        $('#unidades').selectpicker({
            'noneSelectedText': 'Seleccione Unidad',
            'multipleSeparator': ','
        });

        $('#sub_direcciones').selectpicker({
            'noneSelectedText': 'Seleccione sub dirección',
            'multipleSeparator': ','
        });
    });

    $("#formulario_editar_usuario").submit(function (e) {
        var lista = document.getElementsByClassName("spanclass");
        limpiarErrores(lista);
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializa los elementos input del form
            success: function (data) {
                if (data == 'usuario_actualizado') {
                    let timerInterval
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario actualizado exitosamente',
                        html: 'Cerrando ventana en <b>5</b> segundos.',
                        timer: 5000,
                        timerProgressBar: false,
                        willOpen: () => {
                            Swal.showLoading();
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent();
                                if (content) {
                                    const b = content.querySelector('b');
                                    if (b) {

                                        b.textContent = Math.round(Swal
                                            .getTimerLeft() / 1000);
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

                if (data == 'sin_cambios') {
                    let timerInterval
                    Swal.fire({
                        icon: 'warning',
                        title: 'No hay cambios para guardar!',
                        html: 'Cerrando ventana en <b>5</b> segundos.',
                        timer: 5000,
                        timerProgressBar: false,
                        willOpen: () => {
                            Swal.showLoading();
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent();
                                if (content) {
                                    const b = content.querySelector('b');
                                    if (b) {

                                        b.textContent = Math.round(Swal
                                            .getTimerLeft() / 1000);
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
            error: function (error) {

                spanErrores(error);
            }

        });
    });

</script>
