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
                <h5>Edición de departamento ID : {{$departamento->id}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <form action="{{route('mantenedor_departamentos.update', ['mantenedor_departamento' => $departamento->id])}}" method="PUT"
                            id="formulario_editar_direccion">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">
                                    <label for="nombre">Nombre </label>
                                    <input type="text" class="form-control" name="nombre" id="nombre"
                                        value="{{$departamento->nombre}}">
                                </div>

                                <div class="col-md-12 mt-4">
                                    <label for="observacion">Observación </label>
                                    <input type="text" class="form-control" name="observacion" id="observacion"
                                        value="{{$departamento->observacion}}">
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
    });

    $("#formulario_editar_direccion").submit(function (e) {
        var lista = document.getElementsByClassName("spanclass");
        limpiarErrores(lista);
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "PUT",
            url: url,
            data: form.serialize(), // serializa los elementos input del form
            success: function (data) {
                if (data == 'departamento_actualizada') {
                    let timerInterval
                    Swal.fire({
                        icon: 'success',
                        title: 'Departamento actualizado exitosamente',
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
