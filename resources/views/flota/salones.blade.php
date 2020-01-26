@extends('layouts.app')
@section('titulo')
    Gestión Flota
@endsection

@section('contenido')
    <link rel="stylesheet" href="{{ asset("css/datatables.min.css") }}">

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h1>Salones</h1>
                </div>

                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-sm btn-primary" onclick="$('#modal_nuevo_salon').modal();"><i class="fa fa-plus"></i>&nbsp;Agregar</button>
                </div>
            </div>


            <table class="table table-sm table-bordered table-hover text-center small" id="tabla_salones">
                <thead class="bg-info text-white">
                <tr>
                    <th>Nombre</th>
                    <th>Nombre Corto</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal_nuevo_salon">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Salón</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_nuevo_salon" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 text-right ml-4">
                                <button type="button" class="btn btn-link text-white" onclick="$('#alert_nuevo_salon').slideUp(); $('#alert_nuevo_salon_list').empty();"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled" id="alert_nuevo_salon_list"></ul>
                            </div>
                        </div>
                    </div>

                    <form method="post">
                        <div class="form-group">
                            <label for="descripcion">Nombre</label>
                            <input type="text" class="form-control" id="descripcion">
                        </div>

                        <div class="form-group">
                            <label for="nombre_corto">Nombre Corto</label>
                            <input type="text" class="form-control" id="nombre_corto">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveSalon();"><i class="fa fa-save"></i>&nbsp;Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal_edit_salon">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Salón</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_edit_salon" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 text-right ml-4">
                                <button type="button" class="btn btn-link text-white" onclick="$('#alert_edit_salon').slideUp(); $('#alert_edit_salon_list').empty();"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled" id="alert_edit_salon_list"></ul>
                            </div>
                        </div>
                    </div>

                    <form method="post">
                        <div class="form-group">
                            <input type="hidden" id="id_salon_edit">
                            <label for="descripcion">Nombre</label>
                            <input type="text" class="form-control" id="descripcion_edit">
                        </div>

                        <div class="form-group">
                            <label for="nombre_corto">Nombre Corto</label>
                            <input type="text" class="form-control" id="nombre_corto_edit">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="editSalon();"><i class="fa fa-save"></i>&nbsp;Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset("js/general.js") }}"></script>
    <script src="{{ asset("js/datatables.min.js") }}"></script>
    <script src="{{ asset("js/sweetalert2.js") }}"></script>
    <script src="{{ asset("js/jquery.blockUI.js") }}"></script>
    <script src="{{ asset("js/flota/salones.js") }}"></script>
@endsection
