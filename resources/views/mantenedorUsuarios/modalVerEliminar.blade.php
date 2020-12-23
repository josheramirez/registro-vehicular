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

<div id="modalVerEliminar" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5>Eliminar usuario ID : {{$usuario->id}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li><b>Nombre</b> : {{$usuario->name}}</li>
                            <li><b>Correo electrónico</b> : {{$usuario->email}}</li>
                        </ul>
                    </div>
                </div>

                <form action="{{route('mantenedorusuarios.eliminar')}}" method="POST" id="formulario_eliminar_usuario">
                    @csrf
                    <input type="hidden" name="usuario_id" id="usuario_id" value="{{$usuario->id}}">


                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-center">¿Desea eliminar el usuario?</h5>
                        </div>
                    </div>
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>

                </form>
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
    $(document).ready(function () {
        $(".verEliminar").attr('disabled', false);
    });

    $("#formulario_eliminar_usuario").submit(function (e) {

        var lista = document.getElementsByClassName("spanclass");
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');

        Swal.fire({
            title: '¿Está seguro de eliminar el usuario?',
            showDenyButton: true,
            confirmButtonText: 'Eliminar',
            denyButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            denyButtonColor: '#007bff',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializa los elementos input del form
                    success: function (data) {
                        if (data == 'usuario_eliminado') {
                            let timerInterval
                            Swal.fire({
                                icon: 'success',
                                title: 'Usuario eliminado exitosamente',
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
                    error: function (error) {

                    }
                });
            } 
        })


    });

</script>
