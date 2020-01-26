$(document).ready(function () {
    getMantenciones();
});

function getMantenciones() {
    block();

    $.ajax({
        url: 'mantencion/getmantenciones',
        type: 'GET',
        success: function (data) {
            listMantenciones(data);
            unblock();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}

function listMantenciones(data) {
    $('#tabla_mantenciones').DataTable({
        "processing": true,
        "destroy": true,
        "data": data,
        "rowId": 'id_mantencion',
        "columns": [
            {"data": "orden_interno", "className": "text-center"},
            {"data": "descripcion", "className": "text-center"},
            {
                "data": {
                    "ordenes_compra": "ordenes_compra"
                },
                "render": function (data) {
                    var texto = "<ul class='list-unstyled'>";

                    for(var i = 0; i < data.ordenes_compra.length; i++){
                        if(data.ordenes_compra[i].id_orden != null){
                            texto += "<li>-" + data.ordenes_compra[i].id_orden + "</li>"
                        }
                    }

                    texto += "</ul>"

                    return texto ;
                },

                "className": "text-center"
            },
            {"data": "estado", "className": "text-center"},
            {"data": "created_at", "className": "text-center"},
            {
                "data": {
                    "id_mantencion": "id_mantención"
                },
                "render": function (data) {
                    var texto =
                        "<button type='button' class='btn btn-sm btn-primary' onclick='getMantencionById(" + data.id_mantencion + ");' title='Editar Registro'><i class='fa fa-edit'></i></button>" +
                        "&nbsp;&nbsp;" +
                        "<button type='button' class='btn btn-sm btn-danger' onclick='deleteMantencion(" + data.id_mantencion + ");' title='Eliminar Registro'><i class='fa fa-times'></i></button>";

                    return texto;
                }
            }

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

    $("#tabla_mantenciones_filter input").addClass("form-control form-control-sm");
    $("#tabla_mantenciones_length select").addClass("form-control form-control-sm custom-select");
}

function getMantencionById(id_mantencion) {
    block();

    $.ajax({
        url: 'mantencion/getmantencionbyid',
        type: 'GET',
        data: {
            id_mantencion: id_mantencion
        },
        success: function (data) {
            $("#id_mantencion_edit").val(data.id_mantencion);
            $("#id_bus_edit").val(data.id_bus);
            $("#descripcion_edit").val(data.descripcion);
            $("#estado_edit").val(data.estado);

            $("#modal_edit_mantencion").modal();

            unblock();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}

function saveMantencion() {
    block();

    $('#alert_nueva_mantencion').slideUp();
    $('#alert_nueva_mantencion_list').empty();

    $.ajax({
        url: 'mantencion/savemantencion',
        method: 'POST',
        crossDomain: true,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_bus: $("#id_bus").val(),
            descripcion: $("#descripcion").val()
        },
        success: function (data, textStatus, jqXHR) {
            unblock();

            if (data.codigo == 400) {
                $.each(data.error, function (key, value) {
                    $("#alert_nueva_mantencion_list").append("<li>- " + value+ "</li>");
                });

                $("#alert_nueva_mantencion").show();
                setTimeout(function () {
                    $("#alert_nueva_mantencion").slideUp();
                }, 3000);

                return false;
            } else {
                $("#modal_nueva_mantencion").modal('toggle');

                $("#id_bus").val("");
                $("#descripcion").val("");
                getMantenciones();
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

function editMantencion() {
    block();

    $('#alert_edit_mantencion').slideUp();
    $('#alert_edit_mantencion_list').empty();

    $.ajax({
        url: 'mantencion/editmantencion',
        method: 'POST',
        crossDomain: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_mantencion: $("#id_mantencion_edit").val(),
            id_bus: $("#id_bus_edit").val(),
            descripcion: $("#descripcion_edit").val(),
            id_estado: $("#estado_edit").val(),
        },
        success: function (data, textStatus, jqXHR) {
            unblock();

            if (data.codigo == 400) {
                $.each(data.error, function (key, value) {
                    $("#alert_edit_mantencion_list").append("<li>- " + value+ "</li>");
                });

                $("#alert_edit_mantencion").show();
                setTimeout(function () {
                    $("#alert_edit_mantencion").slideUp();
                }, 3000);

                return false;
            } else {
                $("#modal_edit_mantencion").modal('toggle');
                getMantenciones();
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

function deleteMantencion(id_mantencion) {
    block();

    $.ajax({
        url: 'mantencion/deletemantencion',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_mantencion: id_mantencion
        },
        success: function (data) {
            unblock();
            getMantenciones();
            notificacionToast(1, "Registro Eliminado");

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
            notificacionToast(1, "Error al procesar la solicitud");
            unblock();
        }
    });
}