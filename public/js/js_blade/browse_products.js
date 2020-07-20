//Agregar envio carrito  --}}
$(function (event) {
    $("#btnSendCart").on("click", function () {
        $.ajax({
            type: "GET",
            url: "checkout",
            data: JSON.stringify({
                _token: "{{ csrf_token() }}",
            }),
            async: false,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                swal(
                    "Su transaccion ha procesada correctamente, por favor verifique su correo regularmente para recibir novedades",
                    {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: "btn btn-success",
                            },
                        },
                    }
                );
                modalDataTableCart.ajax.url("Carrito").load();
            },
            failure: function (response) {},
            error: function (response) {},
            timeout: 1000,
        });
    });
});
//Fin--}}



// Inicio Multiselector Agregar contenido a tabla de modal transferencia --}}
//$(document).ready(function() {
function DataRow(_portfolio, _quantity, _batch, _expiration_date) {
    this.portfolio = _portfolio;
    this.quantity = _quantity;
    this.batch = _batch;
    this.expiration_date = _expiration_date;
}

function sendTranfer(portfolioId, available) {
    var quantity = $("#Quantity").val();
    if (quantity == null || quantity == "") {
        swal("Selecciona la cantidad a Transferir", {
            icon: "error",
            buttons: {
                confirm: {
                    className: "btn btn-danger",
                },
            },
        });
        return;
    }
    //Verificamos que la cantidad a transar o comprar no sea mayor a la que cuenta el cliente
    if (quantity > available) {
        swal(
            "La cantidad a solicitar no puede superar la cantidad disponible, ",
            {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                    },
                },
            }
        );
        return;
    }

    //Arreglo guardar datos de tranferencia
    var data = $("#tableTransfer").DataTable().rows().data().toArray();

    var detail = new Array();
    var j = 0;
    var cont = 0;
    for (var i = 0; i < data.length; i++) {
        var rowId = data[i].rownum;
        var checkboxId = "#checkbox" + rowId;
        var checkbox = $(checkboxId)[0];
        var quantity = "#quantity" + rowId;
        var inputNumber = $(quantity)[0];
        var quantity_ = parseInt(inputNumber.value);
        var portfolio = data[i].portfolio;
        var batch = data[i].batch;
        var expiration_date = data[i].expiration_date;
        //Verificamos que la cantidad a transar como propuesta no sea superior a la que cuenta en su catalogo propio
        var availablePortfolio = data[i].available;
        if (checkbox.checked == true) {
            if (isNaN(quantity_)) {
                swal(
                    "Indica la cantidad que quieres intercambiar del producto seleccionado",
                    {
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: "btn btn-danger",
                            },
                        },
                    }
                );
                return;
            } else if (availablePortfolio < quantity_) {
                swal(
                    "No puedes ofrecer mas unidades de las que tienes en tu catalogo",
                    {
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: "btn btn-danger",
                            },
                        },
                    }
                );
                return;
            } else {
                var row = new DataRow(
                    portfolio,
                    quantity_,
                    batch,
                    expiration_date
                );
                detail[j] = row;
                j++;
            }
        }
    }
    if (j == 0) {
        swal("Selecciona algún producto para transferir", {
            icon: "error",
            buttons: {
                confirm: {
                    className: "btn btn-danger",
                },
            },
        });
        return;
    }
    var batch = $("#batch").val();
    var expiration_date = $("#expiration").val();
    var customer = $("#CustomerId").val();
    var productName = $("#productName").val();
    var internal = $("#internal").val();
    var sanitary = $("#sanitary").val();
    var registration_status = $("#registration_status").val();
    var expiration_register = $("#expiration_register").val();
    var cum = $("#cum").val();
    var cum_status = $("#cum_status").val();
    var content_unit = $("#content_unit").val();
    var price = $("#price").val();
    var quantity = $("#Quantity").val();
    var total = price * quantity;

    $.ajax({
        type: "POST",
        url: "guardarProducto",
        data: JSON.stringify({
            _token: "{{ csrf_token() }}",
            porfolio: portfolioId,
            productName: productName,
            internal: internal,
            expirationRegister: expiration_register,
            available: available,
            price: price,
            quantity: quantity,
            batch: batch,
            expiration_date: expiration_date,
            total: total,
            portfolioId: portfolioId,
            detail: detail,
            transactionClass: 0,
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {
            validationError = false;
            swal(response.message + response.cantidad, {
                icon: "success",
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
            //minimisamos la modal despues de que enviamos la información
            $("#modalTransfer").modal("hide");
            $("#modalDetail").modal("hide");
        },
        failure: function (response) {
            alert(response);
        },
        timeout: 1000,
        async: false,
    });
}
// Fin --}}

// Inicio Multiselector y Agregar Contenido de modal a tabla Compra--}}
function sendBuy(portfolioId, available) {
    var quantity = $("#Quantity").val();
    //Verificamos que el campo quantity a comprar o transar contenga un valor
    if (quantity == null || quantity == "") {
        swal("Selecciona la cantidad a comprar", {
            icon: "error",
            buttons: {
                confirm: {
                    className: "btn btn-danger",
                },
            },
        });
        return;
    }

    //Verificamos que la cantidad a transar o comprar no sea mayor a la que cuenta el cliente
    if (quantity > available) {
        swal("Tu compra no puede superar la cantidad disponible, ", {
            icon: "error",
            buttons: {
                confirm: {
                    className: "btn btn-danger",
                },
            },
        });
        return;
    }
    var detail = 0;
    var customer = $("#CustomerId").val();
    var productName = $("#productName").val();
    var internal = $("#internal").val();
    var sanitary = $("#sanitary").val();
    var registration_status = $("#registration_status").val();
    var expiration_register = $("#expiration_register").val();
    var cum = $("#cum").val();
    var batch = $("#batch").val();
    var expiration_date = $("#expiration").val();
    var cum_status = $("#cum_status").val();
    var content_unit = $("#content_unit").val();
    var price = $("#price").val();
    var quantity = $("#Quantity").val();
    var total = price * quantity;

    $.ajax({
        type: "POST",
        url: "guardarProducto",
        data: JSON.stringify({
            _token: "{{ csrf_token() }}",
            porfolio: portfolioId,
            productName: productName,
            internal: internal,
            expirationRegister: expiration_register,
            available: available,
            price: price,
            quantity: quantity,
            batch: batch,
            expiration_date: expiration_date,
            total: total,
            portfolioId: portfolioId,
            detail: detail,
            transactionClass: 1,
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {
            validationError = false;
            swal(response.message + response.cantidad, {
                icon: "success",
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
            $("#modalDetail").modal("hide");
        },
        failure: function (response) {
            alert(response);
        },
        timeout: 1000,
        async: false,
    });
}
// Fin --}}


// Borrar carrito  --}}
$(function (event) {
    $("#btnClearCart").on("click", function () {
        $.ajax({
            type: "POST",
            url: "BorrarCarrito",
            data: JSON.stringify({
                _token: "{{ csrf_token() }}",
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                swal("Se ha vaciado su carrito", {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: "btn btn-success",
                        },
                    },
                });
            },
            failure: function (response) {
                swal("failure", {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: "btn btn-success",
                        },
                    },
                });
            },
            error: function (response) {
                swal("error", {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: "btn btn-success",
                        },
                    },
                });
            },
            timeout: 1000,
        });
        modalDataTableCart.ajax.url("Carrito").load();
    });
});
//Fin--}}

//Modal Detalle transaccion en carrito --}}
var modalDataTableDetailCart;
var portfolio = 0;

// $(document).ready(function() {
$("#DetalleCarrito")
    .off()
    .on("click", function (e) {
        var porfolio = $(e.relatedTarget).data("porfolio");
        modalDataTableDetailCart = $("#tableDetailCart").DataTable({
            ajax: {
                type: "GET",
                url: "DetailExchange/" + portfolio,
                dataSrc: "",
                data: {},
                contentType: "application/json; charset=utf-8",
                dataType: "json",
            },
            columns: [
                {
                    data: "productName",
                },
                {
                    data: "quantity",
                },
            ],
            columnDefs: [
                {
                    targets: [0],
                    render: function (data, type, row) {
                        return (
                            '<td><textarea class="textarea">' +
                            data +
                            "</textarea></td>"
                        );
                    },
                },
            ],
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                        )
                            .appendTo($(column.footer()).empty())
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(
                                        val ? "^" + val + "$" : "",
                                        true,
                                        false
                                    )
                                    .draw();
                            });
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' +
                                        d +
                                        '">' +
                                        d +
                                        "</option>"
                                );
                            });
                    });
            },
        });
        // });
    });
//Fin--}}

// Inicio Tabla Cookie Carrito de compras --}}
var modalDataTableCart;
var customer = 0;
$(document).ready(function () {
    modalDataTableCart = $("#tableCart").DataTable({
        ajax: {
            type: "GET",
            url: "Carrito",
            dataSrc: "",
            async: true,
            data: {},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
        },
        columns: [
            {
                data: "productName",
            },
            {
                data: "internal",
            },
            {
                data: "expiration",
            },
            {
                data: "transactionClass",
            },
            {
                data: "price",
            },
            {
                data: "available",
            },
            {
                data: "quantity",
            },
            {
                data: "total",
            },
            {
                data: "portfolioId",
            },
        ],
        columnDefs: [
            {
                targets: [0],
                render: function (data, type, row) {
                    return (
                        '<td><textarea class="textarea">' +
                        data +
                        "</textarea></td>"
                    );
                },
            },
            {
                targets: [3],
                render: function (data, type, row) {
                    if (data == 1) {
                        return "<td><label>Compra</label></td>";
                    } else return "<td><label>Transferencia</label></td>";
                },
            },
            {
                targets: [4],
                render: function (data, type, row) {
                    return "<td><label>$" + data + "</label></td>";
                },
            },
            {
                targets: [6],
                render: function (data, type, row) {
                    return '<label style="font-size:10px">' + data + "</label>";
                },
            },
            {
                targets: [7],
                render: function (data, type, row) {
                    return "<td><label>$" + data + "</label></td>";
                },
            },
            {
                targets: [8],
                render: function (data, type, row) {
                    return (
                        '<td> <div class="form-button-action"><button id="EliminarCampo" style="padding:0" type="button" on data-toggle="tooltip" title="Eliminar" class="btn btn-link btn-danger"><i class="fas fa-cart-arrow-down"></i></button><button id="DetailCart"   data-porfolio=" ' +
                        data +
                        '" data-target="#modalDetailTransac" data-toggle="modal"  style="padding:0; margin-left: 15px" type="button" on data-toggle="tooltip" title="Detalle Transacción" class="btn btn-link btn-primary"><i class="fa fa-info"></i></button></div></td>'
                    );
                },
            },
        ],
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    var column = this;
                    var select = $(
                        '<select class="form-control"><option value=""></option></select>'
                    )
                        .appendTo($(column.footer()).empty())
                        .on("change", function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? "^" + val + "$" : "", true, false)
                                .draw();
                        });
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append(
                                '<option value="' + d + '">' + d + "</option>"
                            );
                        });
                });
        },
    });
    $("#modalShopping").on("show.bs.modal", function (e) {
        modalDataTableCart.ajax.url("Carrito").load();
    });

    $("#DetailCart")
        .off()
        .on("show.bs.modal", function (e) {
            var porfolio = $(e.relatedTarget).data("porfolio");

            modalDataTableDetailCart = $("#tableDetailCart").DataTable({
                ajax: {
                    type: "GET",
                    url: "DetailExchange/" + portfolio,
                    dataSrc: "",
                    data: {},
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                },
                columns: [
                    {
                        data: "productName",
                    },
                    {
                        data: "quantity",
                    },
                ],
                columnDefs: [
                    {
                        targets: [0],
                        render: function (data, type, row) {
                            return (
                                '<td><textarea class="textarea">' +
                                data +
                                "</textarea></td>"
                            );
                        },
                    },
                ],
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            var column = this;
                            var select = $(
                                '<select class="form-control"><option value=""></option></select>'
                            )
                                .appendTo($(column.footer()).empty())
                                .on("change", function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(
                                            val ? "^" + val + "$" : "",
                                            true,
                                            false
                                        )
                                        .draw();
                                });
                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function (d, j) {
                                    select.append(
                                        '<option value="' +
                                            d +
                                            '">' +
                                            d +
                                            "</option>"
                                    );
                                });
                        });
                },
            });
            //$("#modalDetailTransac").modal('show');
        });
});
// Fin --}}

// Valores minimos y maximos en inputs--}}
(function ($) {
    $.fn.inputFilter = function (inputFilter) {
        return this.on(
            "input keydown keyup mousedown mouseup select contextmenu drop",
            function () {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(
                        this.oldSelectionStart,
                        this.oldSelectionEnd
                    );
                }
            }
        );
    };
})(jQuery);
$(".intLimitTextBox").inputFilter(function (value) {
    return (
        /^\d*$/.test(value) &&
        (value === "" || (parseInt(value) > 0 && parseInt(value) < 10000000))
    );
});
//Fin Valores minimos --}}
