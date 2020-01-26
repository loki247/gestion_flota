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
                    <h1>Mantenciones</h1>
                </div>

                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-sm btn-primary" onclick="$('#modal_nueva_mantencion').modal();"><i class="fa fa-plus"></i>&nbsp;Agendar Mantención</button>
                </div>
            </div>


            <table class="table table-sm table-bordered table-hover text-center small" id="tabla_mantenciones">
                <thead class="bg-info text-white">
                <tr>
                    <th>Orden Interno</th>
                    <th>Descripción</th>
                    <th>Orden de Compra de Repuestos</th>
                    <th>Estado</th>
                    <th>Fecha Ingreso</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal_nueva_mantencion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agendar Mantención</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_nueva_mantencion" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 text-right ml-4">
                                <button type="button" class="btn btn-link text-white" onclick="$('#alert_nueva_mantencion').slideUp(); $('#alert_nueva_mantencion_list').empty();"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled" id="alert_nueva_mantencion_list"></ul>
                            </div>
                        </div>
                    </div>

                    <form method="post">
                        <div class="form-group">
                            <label for="bus">Bus</label>

                            <select class="form-control custom-select" id="id_bus">
                                <option value="0">Seleccione Bus</option>
                                @foreach(App\Models\flota\bus::getBuses() as $bus)
                                    <option value="{{ $bus->id_bus }}">Bus Nº {{ $bus->orden_interno }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Detalle Mantención</label>

                            <textarea class="form-control" rows="3" id="descripcion"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveMantencion();"><i class="fa fa-save"></i>&nbsp;Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal_edit_mantencion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Mantención</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_edit_mantencion" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 text-right ml-4">
                                <button type="button" class="btn btn-link text-white" onclick="$('#alert_edit_mantencion').slideUp(); $('#alert_edit_mantencion_list').empty();"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled" id="alert_edit_mantencion_list"></ul>
                            </div>
                        </div>
                    </div>

                    <form method="post">
                        <div class="form-group">
                            <input type="hidden" id="id_mantencion_edit">

                            <label for="id_bus_edit">Bus</label>

                            <select class="form-control custom-select" id="id_bus_edit">
                                <option value="0">Seleccione Bus</option>
                                @foreach(App\Models\flota\bus::getBuses() as $bus)
                                    <option value="{{ $bus->id_bus }}">Bus Nº {{ $bus->orden_interno }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descripcion_edit">Detalle Mantención</label>

                            <textarea class="form-control" rows="3" id="descripcion_edit"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="estado_edit"></label>

                            <select class="form-control custom-select" id="estado_edit">
                                <option value="0">Seleccione Estado</option>
                                @foreach(App\Models\flota\estado_mantencion::getEstados() as $estado)
                                    <option value="{{ $estado->id_estado }}">{{ $estado->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="editMantencion();"><i class="fa fa-save"></i>&nbsp;Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset("js/general.js") }}"></script>
    <script src="{{ asset("js/datatables.min.js") }}"></script>
    <script src="{{ asset("js/sweetalert2.js") }}"></script>
    <script src="{{ asset("js/jquery.blockUI.js") }}"></script>
    <script src="{{ asset("js/flota/mantencion.js") }}"></script>
@endsection
