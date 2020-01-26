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
                    <h1>Buses</h1>
                </div>

                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-sm btn-primary" onclick="$('#modal_nuevo_bus').modal();"><i class="fa fa-plus"></i>&nbsp;Agregar</button>
                </div>
            </div>


            <table class="table table-sm table-bordered table-hover text-center small" id="tabla_buses">
                <thead class="bg-info text-white">
                <tr>
                    <th>Patente</th>
                    <th>Orden Interno</th>
                    <th>Nº Motor</th>
                    <th>Nº Chasis</th>
                    <th>Salón</th>
                    <th>Capacidad</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal_nuevo_bus">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Bus</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_nuevo_bus" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 text-right ml-4">
                                <button type="button" class="btn btn-link text-white" onclick="$('#alert_nuevo_bus').slideUp(); $('#alert_nuevo_bus_list').empty();"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled" id="alert_nuevo_bus_list"></ul>
                            </div>
                        </div>
                    </div>

                    <form method="post">
                        <div class="form-group">
                            <label for="patente">Patente</label>
                            <input type="text" class="form-control" id="patente">
                        </div>

                        <div class="form-group">
                            <label for="orden_interno">Orden Interno</label>
                            <input type="text" class="form-control" id="orden_interno">
                        </div>

                        <div class="form-group">
                            <label for="num_motor">Nº Motor</label>
                            <input type="text" class="form-control" id="num_motor">
                        </div>

                        <div class="form-group">
                            <label for="num_chasis">Nº Chasis</label>
                            <input type="text" class="form-control" id="num_chasis">
                        </div>

                        <div class="form-group">
                            <label for="salon">Salón</label>

                            <select class="form-control custom-select" id="salon">
                                <option value="0">Seleccione Salón</option>
                                @foreach(App\Models\flota\salon::getSalones() as $salon)
                                    <option value="{{ $salon->id_salon }}">{{ $salon->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="capacidad">Capacidad</label>
                            <input type="text" class="form-control" id="capacidad">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveBus();"><i class="fa fa-save"></i>&nbsp;Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modal_edit_bus">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Bus</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_edit_bus" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 text-right ml-4">
                                <button type="button" class="btn btn-link text-white" onclick="$('#alert_edit_bus').slideUp(); $('#alert_edit_bus_list').empty();"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled" id="alert_edit_bus_list"></ul>
                            </div>
                        </div>
                    </div>

                    <form method="post">
                        <div class="form-group">
                            <input type="hidden" id="id_bus_edit">
                            <label for="patente_edit">Patente</label>
                            <input type="text" class="form-control" id="patente_edit">
                        </div>

                        <div class="form-group">
                            <label for="orden_interno_edit">Orden Interno</label>
                            <input type="text" class="form-control" id="orden_interno_edit">
                        </div>

                        <div class="form-group">
                            <label for="num_motor_edit">Nº Motor</label>
                            <input type="text" class="form-control" id="num_motor_edit">
                        </div>

                        <div class="form-group">
                            <label for="num_chasis_edit">Nº Chasis</label>
                            <input type="text" class="form-control" id="num_chasis_edit">
                        </div>

                        <div class="form-group">
                            <label for="salon_edit">Salón</label>

                            <select class="form-control custom-select" id="salon_edit">
                                <option value="0">Seleccione Salón</option>
                                @foreach(App\Models\flota\salon::getSalones() as $salon)
                                    <option value="{{ $salon->id_salon }}">{{ $salon->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="capacidad_edit">Capacidad</label>
                            <input type="text" class="form-control" id="capacidad_edit">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="editBus();"><i class="fa fa-save"></i>&nbsp;Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset("js/general.js") }}"></script>
    <script src="{{ asset("js/datatables.min.js") }}"></script>
    <script src="{{ asset("js/sweetalert2.js") }}"></script>
    <script src="{{ asset("js/jquery.blockUI.js") }}"></script>
    <script src="{{ asset("js/flota/buses.js") }}"></script>
@endsection
