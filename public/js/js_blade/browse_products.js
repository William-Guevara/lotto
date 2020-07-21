// Agregar contenido al carro
$(function (event) {
    $(".btnAddCart").on("click", function () {
        let product_id = $(this).data("product_id");
        let description_en = $(this).data("description_en");
        let name_en = $(this).data("name_en");
        let price = $(this).data("price");
        let quantity = $("." + product_id).val();
        if (quantity == "") {
            swal("Select quantity", {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                    },
                },
            });
            return;
        }
        let total = price * quantity;
        let _token = $("._token").val();

        $.ajax({
            type: "POST",
            url: getRouteAddCart(),
            data: JSON.stringify({
                _token: _token,
                product_id: product_id,
                description: description_en,
                productName: name_en,
                productPrice: price,
                quantity: quantity,
                total: total,
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
            },
            failure: function (response) {
                alert(response);
            },
            timeout: 1000,
            async: false,
        });
    });
});
// Fin --}}

//agrupar data del carrito
$("#btnSendCart").click(function () {
    var cells = [];
    var rows = $("#tableCart").dataTable().fnGetNodes();
    for (var i = 0; i < rows.length; i++) {
        // Get HTML of 3rd column (for example)
        cells[i] = [
            $(rows[i]).find("td:eq(0)").html(),
            $(rows[i]).find("td:eq(2)").html(),
            $(rows[i]).find("td:eq(3)").html(),
            $(rows[i]).find("td:eq(4)").html(),
        ];
    }
    console.log(cells);
});

//Generar compra
$(function (event) {
    $("#btnSendCart_").on("click", function () {
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
//Fin

// Borrar carrito
$(function (event) {
    $("#btnClearCart").on("click", function () {
        let _token = $("._token").val();
        $.ajax({
            type: "POST",
            url: getRouteDrop(),
            data: JSON.stringify({
                _token: _token,
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                swal(response.message + "", {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: "btn btn-success",
                        },
                    },
                });
                modalDataTableCart.ajax.url(getRouteShowCar()).load();
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
                modalDataTableCart.ajax.url(getRouteShowCar()).load();
            },
            timeout: 1000,
        });
    });
});
//Fin
// Borrar un elemento
function deleteToCart(id) {
    let _token = $("._token").val();
    $.ajax({
        type: "POST",
        url: getRouteDeleteToCart(),
        data: JSON.stringify({
            _token: _token,
            product_id: id,
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (response) {
            swal(response.message + "", {
                icon: "success",
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
            modalDataTableCart.ajax.url(getRouteShowCar()).load();
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
            modalDataTableCart.ajax.url(getRouteShowCar()).load();
        },
        timeout: 1000,
    });
}
//Fin

// Inicio Tabla sesion Carrito de compras
var modalDataTableCart;
$(document).ready(function () {
    modalDataTableCart = $("#tableCart").DataTable({
        ajax: {
            type: "GET",
            url: getRouteShowCar(),
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
                data: "description",
            },
            {
                data: "quantity",
            },
            {
                data: "price",
            },
            {
                data: "total",
            },
            {
                data: "product_id",
            },
        ],
        columnDefs: [
            {
                targets: [1],
                render: function (data, type, row) {
                    return (
                        '<td><textarea class="textarea" disabled>' +
                        data +
                        "</textarea></td>"
                    );
                },
            },
            {
                targets: [3],
                render: function (data, type, row) {
                    return "<td>$" + data + "</td>";
                },
            },
            {
                targets: [4],
                render: function (data, type, row) {
                    return "<td>$" + data + "</td>";
                },
            },
            {
                targets: [5],
                render: function (data, type, row) {
                    return (
                        '<button onclick="deleteToCart(' +
                        data +
                        ')" style="padding:0" type="button" class="btn btn-danger"><i class="bx bx-minus"></i></button>'
                    );
                },
            },
        ],
    });
    $("#modalShopping").on("show.bs.modal", function (e) {
        modalDataTableCart.ajax.url(getRouteShowCar()).load();
    });
});
