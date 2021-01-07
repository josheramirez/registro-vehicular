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
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5>Formulario creación de Instituciones</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <form action="{{route('mantenedor_insituciones.store')}}" method="POST" id="formulario_agregar_institucion">
                            @csrf

                            <div class="row">

                                <div class="col-md-12">
                                    <label for="nombre">Nombre </label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" value="">
                                </div>

                                <div class="col-md-12 mt-4">
                                    <label for="observacion">Observación </label>
                                    <input type="text" class="form-control" name="observacion" id="observacion" value="">
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
    });

    $("#formulario_agregar_institucion").submit(function(e) {
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
                if (data == 'institucion_guardada') {
                    let timerInterval
                    Swal.fire({
                        icon: 'success',
                        title: 'Institución creada exitosamente',
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