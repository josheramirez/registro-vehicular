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
                        Instituciones : {{$usuario->obtenerInstituciones()}}
                    </li>
                    <li>
                        Direcciones : {{$usuario->obtenerDirecciones()}}
                    </li>
                    <li>
                        Sub Direcciones : {{$usuario->obtenerSubDirecciones()}}
                    </li>
                    <li>
                        Departamentos : {{$usuario->obtenerDepartamentos()}}
                    </li>
                    <li>
                        Unidades : {{$usuario->obtenerUnidades()}}
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
