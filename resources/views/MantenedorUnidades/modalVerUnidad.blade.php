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

<div id="modalVerDireccion" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5>Información de unidad ID : {{$unidad->id}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12 mt-4">
                        <ul>
                            <li><b>Nombre</b> : {{$unidad->nombre}}</li>
                            <li><b>Observación</b> : {{$unidad->observacion}}</li>
                        </ul>
                    </div>

                    <div class="col-md-12 mt-2 mb-3 text-center">
                        <form action="{{route('mantenedor_unidades.destroy', ['mantenedor_unidade' => $unidad->id])}}" method="DELETE" id="formulario_eliminar_unidad">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm verEliminar" name="{{$unidad->id}}" title="Eliminarción de unidad"><i class="fas fa-trash-alt"></i>Eliminar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".verInstitucion").attr('disabled', false);
    });

    $("#formulario_eliminar_unidad").submit(function(e) {

        var lista = document.getElementsByClassName("spanclass");
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        Swal.fire({
            title: '¿Está seguro de eliminar la unidad?',
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            denyButtonColor: '#007bff',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: form.serialize(), // serializa los elementos input del form
                    success: function(data) {
                        if (data == 'unidad_eliminada') {
                            let timerInterval
                            Swal.fire({
                                icon: 'success',
                                title: 'Unidad eliminada exitosamente',
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


    });
</script>