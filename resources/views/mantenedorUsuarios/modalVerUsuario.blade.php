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

<div id="modalVerUsuario" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5>Usuario ID : {{$usuario->id}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li><b>Nombre</b> : {{$usuario->name}}</li>
                            <li><b>Correo electrónico</b> : {{$usuario->email}}</li>
                            <li><b>Teléfono</b> : {{$usuario->telefono}}</li>
                            <li><b>Departamentos</b> : </li>
                            <ul>
                                @foreach($du as $d)
                                <li>{{$d->obtenerDepartamento()->nombre}}</li>
                                @endforeach
                            </ul>
                            <li><b>Tipo de usuario</b> : {{$usuario->obtenerTipoUsuario()->nombre}} </li>
                            <li><b>Estado</b> :
                                @if($usuario->activo==1)
                                <b class="text-success">ACTIVO</b>
                                @else
                                <b class="text-danger">INACTIVO</b>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".verUsuario").attr('disabled', false);
    });
</script>