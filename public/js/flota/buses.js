$(document).ready(function () {
    getBuses();
});

function getBuses() {
    block();

    $.ajax({
        url: 'buses/getbuses',
        type: 'GET',
        success: function (data) {
            listBuses(data);
            unblock();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}

function listBuses(data) {
    $('#tabla_buses').DataTable({
        "processing": true,
        "destroy": true,
        "data": data,
        "rowId": 'id_bus',
        "columns": [
            {"data": "patente", "className": "text-center"},
            {"data": "orden_interno", "className": "text-center"},
            {"data": "num_motor", "className": "text-center"},
            {"data": "num_chasis", "className": "text-center"},
            {"data": "salon", "className": "text-center"},
            {"data": "capacidad", "className": "text-center"},
            {
                "data": {
                    "id_bus": "id_bus"
                },
                "render": function (data) {
                    var texto =
                        "<button type='button' class='btn btn-sm btn-primary' onclick='getBusById(" + data.id_bus + ");' title='Editar Registro'><i class='fa fa-edit'></i></button>" +
                        "&nbsp;&nbsp;" +
                        "<button type='button' class='btn btn-sm btn-danger' onclick='deleteBus(" + data.id_bus + ");' title='Eliminar Registro'><i class='fa fa-times'></i></button>";

                    return texto;
                },
                "className": "text-center",
                "orderable": false
            },
        ],
        "dom": "frtpli",
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "cursor": "hand",
    });

    $("#tabla_buses_filter input").addClass("form-control form-control-sm")
    $("#tabla_buses_length select").addClass("form-control form-control-sm custom-select")
}

function getBusById(id_bus) {
    block();

    $.ajax({
        url: 'buses/getbusbyid',
        type: 'GET',
        data: {
            id_bus: id_bus
        },
        success: function (data) {
            $("#id_bus_edit").val(data.id_bus);
            $("#patente_edit").val(data.patente);
            $("#orden_interno_edit").val(data.orden_interno);
            $("#num_motor_edit").val(data.num_motor);
            $("#num_chasis_edit").val(data.num_chasis);
            $("#salon_edit").val(data.id_salon);
            $("#capacidad_edit").val(data.capacidad);

            $("#modal_edit_bus").modal();

            unblock();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}

function saveBus() {
    block();

    $('#alert_nuevo_bus').slideUp();
    $('#alert_nuevo_bus_list').empty();

    $.ajax({
        url: 'buses/savebus',
        method: 'POST',
        crossDomain: true,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            patente: $("#patente").val(),
            orden_interno: $("#orden_interno").val(),
            num_motor: $("#num_motor").val(),
            num_chasis: $("#num_chasis").val(),
            id_salon: $("#salon").val(),
            capacidad: $("#capacidad").val()
        },
        success: function (data, textStatus, jqXHR) {
            unblock();

            if (data.codigo == 400) {
                $.each(data.error, function (key, value) {
                    $("#alert_nuevo_bus_list").append("<li>- " + value+ "</li>");
                });

                $("#alert_nuevo_bus").show();
                setTimeout(function () {
                    $("#alert_nuevo_bus").slideUp();
                }, 3000);

                return false;
            } else {
                $("#modal_nuevo_bus").modal('toggle');

                $("#patente").val("");
                $("#orden_interno").val("");
                $("#num_motor").val("");
                $("#num_chasis").val("");
                $("#salon").val(0);
                $("#capacidad").val();

                getBuses();
                notificacionToast(1, "Datos Registrados");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            unblock();
            console.log(errorThrown);
            notificacionToast(1, "Error al procesar la solicitud");
        }
    });
}

function editBus() {
    block();

    $('#alert_edit_bus').slideUp();
    $('#alert_edit_bus_list').empty();

    $.ajax({
        url: 'buses/editbus',
        method: 'POST',
        crossDomain: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_bus: $("#id_bus_edit").val(),
            patente: $("#patente_edit").val(),
            orden_interno: $("#orden_interno_edit").val(),
            num_motor: $("#num_motor_edit").val(),
            num_chasis: $("#num_chasis_edit").val(),
            id_salon: $("#salon_edit").val(),
            capacidad: $("#capacidad_edit").val()
        },
        success: function (data, textStatus, jqXHR) {
            unblock();

            if (data.codigo == 400) {
                $.each(data.error, function (key, value) {
                    $("#alert_edit_bus_list").append("<li>- " + value+ "</li>");
                });

                $("#alert_edit_bus").show();
                setTimeout(function () {
                    $("#alert_edit_bus").slideUp();
                }, 3000);

                return false;
            } else {
                $("#modal_edit_bus").modal('toggle');
                getBuses();
                notificacionToast(1, "Datos Actualizados");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            unblock();
            console.log(errorThrown);
            notificacionToast(1, "Error al procesar la solicitud");
        }
    });
}

function deleteBus(id_bus) {
    block();

    $.ajax({
        url: 'buses/deletebus',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_bus: id_bus
        },
        success: function (data) {
            unblock();
            getBuses();
            notificacionToast(1, "Registro Eliminado");

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
            notificacionToast(1, "Error al procesar la solicitud");
            unblock();
        }
    });
}