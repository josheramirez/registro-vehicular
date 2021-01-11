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

    .bootstrap-select {
        border: 1px solid #ced4da !important;
    }
</style>

<div id="modalVerAgregar" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5>Formulario creación de usuarios</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <form action="{{route('mantenedorusuarios.agregar')}}" method="POST" id="formulario_agregar_usuario">
                            @csrf

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <label for="rut">RUT </label>
                                            <input type="text" class="form-control" name="rut" id="rut" value="">
                                        </div>
                                        <div class="col-md-3" style="margin-left: -5%;">
                                            <label for="dv">DV </label>
                                            <input type="text" class="form-control" name="dv" id="dv" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="name">Nombre </label>
                                    <input type="text" class="form-control" name="name" id="name" value="" onchange="mostrarPassword(this.value)">
                                </div>

                                <div class="col-md-6 mt-4">
                                    <label for="email">E-mail </label>
                                    <input type="text" class="form-control" name="email" id="email" value="">
                                </div>

                                <div class="col-md-6 mt-4">
                                    <label for="telefono">Teléfono </label>
                                    <input type="text" class="form-control" name="telefono" id="telefono" value="">
                                </div>

                                <div class="col-md-6 mt-4">
                                    <label for="anexo">Anexo </label>
                                    <input type="text" class="form-control" name="anexo" id="anexo" value="">
                                </div>

                                <div class="col-md-12 mt-4">
                                    <label for="tipo_usuario">Tipo de usuario </label>
                                </div>
                                <div class="col-md-12" id="div_select_usuario">
                                    <select name="tipo_usuario" id="tipo_usuario" class="form-control">
                                        <option value="">Seleccione Tipo de usuario</option>
                                        @foreach($tipos_usuario as $tu)
                                        <option value="{{$tu->id}}">{{$tu->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-1">
                                    <span id="tipo_usuario_span" style="color: red"></span>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mt-4">
                                            <label for="instituciones">Instituciones </label>
                                        </div>
                                        <div class="col-md-12" id="div_select_departamento">
                                            <select name="instituciones[]" id="instituciones" class="form-control" multiple>
                                                @foreach($instituciones as $institucion)
                                                <option value="{{$institucion->id}}">{{$institucion->nombre}}</option>
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
                                                <option value="{{$direccion->id}}">{{$direccion->nombre}}</option>
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
                                            <select name="sub_direcciones[]" id="sub_direcciones" class="form-control" multiple>
                                                @foreach($sub_direcciones as $sub_direccion)
                                                <option value="{{$sub_direccion->id}}">{{$sub_direccion->nombre}}</option>
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
                                        <div class="col-md-12" id="div_select_departamento">
                                            <select name="departamentos[]" id="departamentos" class="form-control" multiple>
                                                @foreach($departamentos as $dp)
                                                <option value="{{$dp->id}}">{{$dp->nombre}}</option>
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
                                                <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <span id="unidad_span" style="color: red"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <b id="password_label">Contraseña por defecto : </b>
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

            <!-- Modal footer -->
            {{-- <div class="modal-footer botones">
                <div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div> --}}

        </div>
    </div>
</div>
<script type="text/javascript" src="{!! asset('/js/utilidades.js') !!}"></script>
<script>
    $(document).ready(function() {
        $(".verAgregar").attr('disabled', false);
        $('#departamentos').selectpicker({
            'noneSelectedText': 'Seleccione departamento',
            'multipleSeparator': ','
        });

        $('#instituciones').selectpicker({
            'noneSelectedText': 'Seleccione institución',
            'multipleSeparator': ','
        });

        $('#direcciones').selectpicker({
            'noneSelectedText': 'Seleccione dirección',
            'multipleSeparator': ','
        });

        $('#unidades').selectpicker({
            'noneSelectedText': 'Seleccione unidad',
            'multipleSeparator': ','
        });

        $('#sub_direcciones').selectpicker({
            'noneSelectedText': 'Seleccione sub dirección',
            'multipleSeparator': ','
        });
        

        $('#tipo_usuario').selectpicker({
            'noneSelectedText': 'Seleccione Tipo de usuario',
        });
    });

    $("#formulario_agregar_usuario").submit(function(e) {
        var lista = document.getElementsByClassName("spanclass");
        limpiarErrores(lista);
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializa los elementos input del form
            success: function(data) {
                if (data == 'usuario_creado') {
                    let timerInterval
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario creado exitosamente',
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
            error: function(error) {

                spanErrores(error);
            }

        });
    });

    function mostrarPassword(value) {
        console.log(value.substring(0, 2));
        document.getElementById('password_label').innerHTML = 'Contraseña por defecto : ' + normalize(value.substring(0, 2)) + '.123456';
    }

    var normalize = (function() {
        var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
            to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
            mapping = {};

        for (var i = 0, j = from.length; i < j; i++)
            mapping[from.charAt(i)] = to.charAt(i);

        return function(str) {
            var ret = [];
            for (var i = 0, j = str.length; i < j; i++) {
                var c = str.charAt(i);
                if (mapping.hasOwnProperty(str.charAt(i)))
                    ret.push(mapping[c]);
                else
                    ret.push(c);
            }
            return ret.join('');
        }

    })();
</script>