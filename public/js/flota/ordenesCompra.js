$(document).ready(function () {
    getOrdenesCompra();
});

var contador = 0;

function getOrdenesCompra() {
    block();

    $.ajax({
        url: 'ordenescompra/getordenescompra',
        type: 'GET',
        success: function (data) {
            listOrdenesCompra(data);
            unblock();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}

function listOrdenesCompra(data) {
    $('#tabla_ordenes_compra').DataTable({
        "processing": true,
        "destroy": true,
        "data": data,
        "rowId": 'id_orden',
        "columns": [
            {"data": "id_mantencion", "className": "text-center"},
            {
                "data": {
                    "detalle": "detalle"
                },
                "render": function (data) {
                    var texto = "<ul class='list-unstyled'>";

                    $.each(JSON.parse(data.detalle), function(index, value){
                        texto += "<li>-" + value.repuesto + " (" +  value.cantidad + " unidad(es))</li>";
                    });

                    return texto + "</ul>";
                },
                "className": "text-left"
            },
            {"data": "estado", "className": "text-center"},
            {"data": "created_at", "className": "text-center"},
            {
                "data": {
                    "id_orden": "id_orden"
                },
                "render": function (data) {
                    var texto =
                        "<button type='button' class='btn btn-sm btn-primary' onclick='getOrdenCompraById(" + data.id_orden + ");' title='Editar Registro'><i class='fa fa-edit'></i></button>" +
                        "&nbsp;&nbsp;" +
                        "<button type='button' class='btn btn-sm btn-danger' title='Eliminar Registro'><i class='fa fa-times'></i></button>";

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

    $("#tabla_ordenes_compra_filter input").addClass("form-control form-control-sm");
    $("#tabla_ordenes_compra_length select").addClass("form-control form-control-sm custom-select");
}

function getOrdenCompraById(id_orden) {
    block();

    $.ajax({
        url: 'ordenescompra/getordencomprabyid',
        type: 'GET',
        data: {
            id_orden: id_orden
        },
        success: function (data) {
            $("#id_orden_compra_edit").val(data.id_orden);
            $("#id_mantencion_edit").val(data.id_mantencion);


            var detalle = JSON.parse(data.detalle);

            contador = detalle.length + 1;

            $.each(detalle, function(index, value){
                $("#repuesto_edit").append(
                    "<div class='row mt-1 mb-1' id='repuesto_" + (index + 1) + "'>" +
                        "<div class='col-md-8'>" +
                            "<label>Repuesto</label>" +
                            "<input type='text' name='repuesto_edit[]' class='form-control' value='" + value.repuesto + "'>" +
                        "</div>" +

                        "<div class='col-md-2'>" +
                            "<label>Cantidad</label>" +
                            "<input type='number' name='cantidad_edit[]' class='form-control' value='" + value.cantidad + "'>" +
                        "</div>" +

                        "<div class='col-md-2'style='margin-top: 35px;'>" +
                            "<button type='button' class='btn btn-sm btn-danger' name='btnDelete[]' onclick='deleteCampoRepuesto(" + contador + ");'><i class='fa fa-times'></i></button>" +
                        "</div>" +
                    "</div>");
            });

            $("#modal_edit_orden_compra").modal();

            unblock();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown)
        }
    });
}

function saveOrdenCompra() {
    var repuestos = [];

    $($("input[name='repuesto[]']")).each(function () {
        repuestos.push($(this).prop("value"));
    });

    var cantidad = [];

    $($("input[name='cantidad[]']")).each(function () {
        cantidad.push($(this).prop("value"));
    });

    var detalle = [];

    for (var i = 0; i < detalle.length; i++){
        detalle.push('{"repuesto" : "' + repuestos[i] + '", "cantidad" : ' + cantidad[i] +'}');
    }

    console.log(repuestos);

    block();

    $('#alert_nueva_orden_compra').slideUp();
    $('#alert_nueva_orden_compra_list').empty();

    $.ajax({
        url: 'ordenescompra/saveordencompra',
        method: 'POST',
        crossDomain: true,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_mantencion: $("#id_mantencion").val(),
            repuestos: repuestos,
            cantidad: cantidad
        },
        success: function (data, textStatus, jqXHR) {
            unblock();

            if (data.codigo == 400) {
                $.each(data.error, function (key, value) {
                    $("#alert_nueva_orden_compra_list").append("<li>- " + value+ "</li>");
                });

                $("#alert_nueva_orden_compra").show();
                setTimeout(function () {
                    $("#alert_nueva_orden_compra").slideUp();
                }, 3000);

                return false;
            } else {
                $("#modal_nueva_orden_compra").modal('toggle');

                $("#id_mantencion").val(0);
                $("input[name='repuesto[]']").remove();
                $("label[for='repuesto']").remove();
                $("input[name='cantidad[]']").remove();
                $("label[for='cantidad']").remove();
                $("button[name='btnDelete[]']").remove();

                $("#repuesto").append(
                    "<div class='row mt-1 mb-1'>" +
                        "<div class='col-md-8'>" +
                            "<label>Repuesto</label>" +
                            "<input type='text' name='repuesto[]' class='form-control'>" +
                        "</div>" +

                        "<div class='col-md-2'>" +
                            "<label>Cantidad</label>" +
                            "<input type='number' name='cantidad[]' class='form-control'>" +
                        "</div>" +
                    "</div>");

                contador = 0;

                getOrdenesCompra();
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

function editOrdenCompra() {
    var repuestos_edit = [];

    $($("input[name='repuesto_edit[]']")).each(function () {
        repuestos_edit.push($(this).prop("value"));
    });

    var cantidad_edit = [];

    $($("input[name='cantidad_edit[]']")).each(function () {
        cantidad_edit.push($(this).prop("value"));
    });

    var detalle_edit = [];

    for (var i = 0; i < detalle.length; i++){
        detalle_edit.push('{"repuesto" : "' + repuestos_edit[i] + '", "cantidad" : ' + cantidad_edit[i] +'}');
    }

    block();

    $('#alert_edit_orden_compra').slideUp();
    $('#alert_edit_orden_compra_list').empty();

    $.ajax({
        url: 'ordenescompra/editordencompra',
        method: 'POST',
        crossDomain: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_orden: $("#id_orden_compra_edit").val(),
            repuestos: repuestos_edit,
            cantidad: cantidad_edit
        },
        success: function (data, textStatus, jqXHR) {
            unblock();

            if (data.codigo == 400) {
                $.each(data.error, function (key, value) {
                    $("#alert_edit_orden_compra_list").append("<li>- " + value+ "</li>");
                });

                $("#alert_edit_orden_compra").show();
                setTimeout(function () {
                    $("#alert_edit_orden_compra").slideUp();
                }, 3000);

                return false;
            } else {
                $("#alert_edit_orden_compra").modal('toggle');
                getOrdenesCompra();
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

function addCampoRepuesto(id) {
    $("#" + id).append(
        "<div class='row mt-1 mb-1' id='repuesto_" + contador + "'>" +
            "<div class='col-md-8'>" +
                "<label for='repuesto'>Repuesto</label>" +
                "<input type='text' name='repuesto[]' class='form-control'>" +
            "</div>" +

            "<div class='col-md-2'>" +
                "<label for='cantidad'>Cantidad</label>" +
                "<input type='number' name='cantidad[]' class='form-control'>" +
            "</div>" +

            "<div class='col-md-2'style='margin-top: 35px;'>" +
                "<button type='button' class='btn btn-sm btn-danger' name='btnDelete[]' onclick='deleteCampoRepuesto(" + contador + ");'><i class='fa fa-times'></i></button>" +
            "</div>" +
        "</div>");

    contador ++;

    console.log(contador);
}

function deleteCampoRepuesto(c) {
    $("#repuesto_" + c).remove();

    contador --;

    console.log(contador);
}