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
                    <h1>Ordenes de Compra</h1>
                </div>

                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-sm btn-primary" onclick="contador = 0; $('#modal_nueva_orden_compra').modal();"><i class="fa fa-plus"></i>&nbsp;Ingresar Orden de Compra</button>
                </div>
            </div>


            <table class="table table-sm table-bordered table-hover text-center small" id="tabla_ordenes_compra">
                <thead class="bg-info text-white">
                <tr>
                    <th>Id Mantención</th>
                    <th>Repuestos Solicitados</th>
                    <th>Estado</th>
                    <th>Fecha Ingreso</th>
                    <th></th>
                </tr>
                </thead>

                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal_nueva_orden_compra">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generar Orden de Compra</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_nueva_orden_compra" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 text-right ml-4">
                                <button type="button" class="btn btn-link text-white" onclick="$('#alert_nueva_orden_compra').slideUp(); $('#alert_nueva_orden_compra_list').empty();"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled" id="alert_nueva_orden_compra_list"></ul>
                            </div>
                        </div>
                    </div>

                    <form method="post">
                        <div class="form-group">
                            <label for="bus">Bus</label>

                            <select class="form-control custom-select" id="id_mantencion">
                                <option value="0">Seleccione Mantención</option>
                                @foreach(App\Models\flota\mantencion::getMantencionesAgendadas() as $mantencion)
                                    <option value="{{ $mantencion->id_mantencion }}"> Bus Nº {{ $mantencion->orden_interno }}, Fecha {{ $mantencion->created_at }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detalle">Repuestos a Solicitar</label>
                            &nbsp;
                            <button type="button" class="btn btn-sm btn-success" onclick="addCampoRepuesto('repuesto');"><i class="fa fa-plus"></i></button>
                            <div id="repuesto">
                                <div class="row mt-1 mb-1">
                                     <div class="col-md-8">
                                         <label>Repuesto</label>
                                         <input type="text" name="repuesto[]" class="form-control">
                                     </div>

                                    <div class="col-md-2">
                                        <label>Cantidad</label>
                                        <input type="number" name="cantidad[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveOrdenCompra();"><i class="fa fa-save"></i>&nbsp;Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal_edit_orden_compra">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Orden de Compra</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_edit_orden_compra" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 text-right ml-4">
                                <button type="button" class="btn btn-link text-white" onclick="$('#alert_edit_orden_compra').slideUp(); $('#alert_edit_orden_compra_list').empty();"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled" id="alert_edit_orden_compra_list"></ul>
                            </div>
                        </div>
                    </div>

                    <form method="post">
                        <div class="form-group">
                            <input type="hidden" id="id_orden_compra_edit">

                            <label for="bus">Bus</label>

                            <select class="form-control custom-select" id="id_mantencion_edit">
                                @foreach(App\Models\flota\mantencion::getMantencionesAgendadas() as $mantencion)
                                    <option value="{{ $mantencion->id_mantencion }}"> Bus Nº {{ $mantencion->orden_interno }}, Fecha {{ $mantencion->created_at }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detalle">Repuestos a Solicitar</label>
                            &nbsp;
                            <button type="button" class="btn btn-sm btn-success" onclick="addCampoRepuesto('repuesto_edit');"><i class="fa fa-plus"></i></button>
                            <div id="repuesto_edit">

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="editOrdenCompra();"><i class="fa fa-save"></i>&nbsp;Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset("js/general.js") }}"></script>
    <script src="{{ asset("js/datatables.min.js") }}"></script>
    <script src="{{ asset("js/sweetalert2.js") }}"></script>
    <script src="{{ asset("js/jquery.blockUI.js") }}"></script>
    <script src="{{ asset("js/flota/ordenesCompra.js") }}"></script>
@endsection
