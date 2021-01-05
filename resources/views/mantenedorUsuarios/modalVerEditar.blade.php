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
    <div class="modal-dialog modal-md">
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

                                <div class="col-md-12">
                                    <label for="name">Nombre </label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{$usuario->name}}">
                                </div>

                                <div class="col-md-12 mt-4">
                                    <label for="email">E-mail </label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        value="{{$usuario->email}}">
                                </div>

                                <div class="col-md-12 mt-4">
                                    <label for="telefono">Teléfono </label>
                                    <input type="text" class="form-control" name="telefono" id="telefono"
                                        value="{{$usuario->telefono}}">
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

                                <div class="col-md-12 mt-4">
                                    <label for="departamentos">Departamentos </label>
                                </div>
                                <div class="col-md-12" id="div_select">
                                    <select name="departamentos[]" id="departamentos" class="form-control" multiple>
                                        @foreach($departamentos as $dp)
                                        @if(in_array($dp->id,$du))
                                        <option value="{{$dp->id}}" selected>{{$dp->nombre}}</option>
                                        @else
                                        <option value="{{$dp->id}}">{{$dp->nombre}}</option>
                                        @endif

                                        @endforeach
                                    </select>
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
            },
            error: function (error) {

                spanErrores(error);
            }

        });
    });

</script>
