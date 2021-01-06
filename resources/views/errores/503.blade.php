@extends('layouts.master')
@section('content')

{{-- CARGA DE PLUGINS PARA DATATABLES --}}
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/datatables/jquery.dataTables.min.css')}}">

{{-- CARGA DE PLUGINS PARA BOOTSTRAP SELECT JQUERY --}}
<link rel="stylesheet" href="{{asset('plugins/bootstrap-select/css/bootstrap-select.min.css')}}">
<script src="{{asset('plugins/bootstrap-select/js/bootstrap-select.min.js')}}"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger mb-3">
                <div class="card-header">ATENCION!</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center" style="vertical-align: middle;">
                        <img src="{{asset('/img/warning-icon.png')}}" alt="Logo" style="max-width: 100%;">
                        </div>

                        <div class="col-md-9 text-center" >
                            <h4 style="margin-top:5%">Usted no posee los permisos necesarios para acceder a este modulo!</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




@endsection