$(document).ready(function () {
    getSalones();
});

function getSalones() {
    block();

    $.ajax({
        url: 'salones/getsalones',
        type: 'GET',
        success: function (data) {
            listSalones(data);
            unblock();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}

function listSalones(data) {
    $('#tabla_salones').DataTable({
        "processing": true,
        "destroy": true,
        "data": data,
        "rowId": 'id_salon',
        "columns": [
            {"data": "descripcion", "className": "text-center"},
            {"data": "nombre_corto", "className": "text-center"},
            {
                "data": {
                    "id_salon": "id_salon"
                },
                "render": function (data) {
                    var texto =
                        "<button type='button' class='btn btn-sm btn-primary' onclick='getSalonById(" + data.id_salon + ");' title='Editar Registro'><i class='fa fa-edit'></i></button>" +
                        "&nbsp;&nbsp;" +
                        "<button type='button' class='btn btn-sm btn-danger' onclick='deleteSalon(" + data.id_salon + ");' title='Eliminar Registro'><i class='fa fa-times'></i></button>";


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

    $("#tabla_salones_filter input").addClass("form-control form-control-sm")
    $("#tabla_salones_length select").addClass("form-control form-control-sm custom-select")
}

function getSalonById(id_salon) {
    block();

    $.ajax({
        url: 'salones/getsalonbyid',
        type: 'GET',
        data: {
            id_salon: id_salon
        },
        success: function (data) {
            $("#id_salon_edit").val(data.id_salon);
            $("#descripcion_edit").val(data.descripcion);
            $("#nombre_corto_edit").val(data.nombre_corto);

            $("#modal_edit_salon").modal();

            unblock();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}

function saveSalon() {
    block();

    $('#alert_nuevo_salon').slideUp();
    $('#alert_nuevo_salon_list').empty();

    $.ajax({
        url: 'salones/savesalon',
        method: 'POST',
        crossDomain: true,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            descripcion: $("#descripcion").val(),
            nombre_corto: $("#nombre_corto").val()
        },
        success: function (data, textStatus, jqXHR) {
            unblock();

            if (data.codigo == 400) {
                $.each(data.error, function (key, value) {
                    $("#alert_nuevo_salon_list").append("<li>- " + value+ "</li>");
                });

                $("#alert_nuevo_salon").show();
                setTimeout(function () {
                    $("#alert_nuevo_salon").slideUp();
                }, 3000);

                return false;
            } else {
                $("#modal_nuevo_salon").modal('toggle');
                $("#descripcion").val();
                $("#nombre_corto").val();

                getSalones();
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

function editSalon() {
    block();

    $('#alert_edit_salon').slideUp();
    $('#alert_edit_salon_list').empty();

    $.ajax({
        url: 'salones/editsalon',
        method: 'POST',
        crossDomain: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_salon: $("#id_salon_edit").val(),
            descripcion: $("#descripcion_edit").val(),
            nombre_corto: $("#nombre_corto_edit").val()
        },
        success: function (data, textStatus, jqXHR) {
            unblock();

            if (data.codigo == 400) {
                $.each(data.error, function (key, value) {
                    $("#alert_edit_salon_list").append("<li>- " + value+ "</li>");
                });

                $("#alert_edit_salon").show();
                setTimeout(function () {
                    $("#alert_edit_salon").slideUp();
                }, 3000);

                return false;
            } else {
                $("#modal_edit_salon").modal('toggle');
                getSalones();
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

function deleteSalon(id_salon) {
    block();

    $.ajax({
        url: 'salones/deletesalon',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_salon: id_salon
        },
        success: function (data) {
            unblock();
            getSalones();
            notificacionToast(1, "Registro Eliminado");

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
            notificacionToast(1, "Error al procesar la solicitud");
            unblock();
        }
    });
}