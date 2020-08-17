//Datatable
$(document).ready(function() {
    $("#table_id").DataTable({
        "pageLength": 20,
        dom: 'Bfrtip',
        buttons: [
            'print'
        ],
        "order": [5, 'desc']
    });

});

//clean inputs
$(function(event) {
    $(".clear").click(function() {
        $(".campos").val("");
    });
});

//data to modal
$(function(event) {
    $("#modalAdminResult")
        .off()
        .on("show.bs.modal", function(e) {
            var option = $(e.relatedTarget).data("option");
            var result = $(e.relatedTarget).data("result");
            $("#option_select").val(option);
            if (option == "create") {
                $("#tittle_modal").text("Register result");
                return;
            }
            if (option == "update") {
                $("#tittle_modal").text("Update result");
                //var area = $(e.relatedTarget).data('area');
                $.ajax({
                    type: "GET",
                    url: "results/" + result,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: true,
                    success: function(response) {
                        //cargar funcion click envio de datos agrtegar area
                        $("#drawing_id").val(response.drawing_id);
                        $("#category").val(response.category);
                        $("#drawing_date").val(response.drawing_date);
                        $("#numbers").val(response.numbers);
                        $("#jackpot").val(response.jackpot);
                    },
                    failure: function(response) {},
                    error: function(response) {},
                    timeout: 10000,
                });
            }
        });
});
//Fin cargar area

//add or update product send
$(function(event) {
    $("#btn_send")
        .off()
        .on("click", function(e) {
            let option = $("#option_select").val();
            let drawing_id = $("#drawing_id").val();
            let category = $("#category").val();
            let drawing_date = $("#drawing_date").val();
            let numbers = $("#numbers").val();
            let jackpot = $("#jackpot").val();
            var _token = $("._token").val();
            if (
                category == '' || category == null ||
                drawing_date == '' ||
                numbers == '' ||
                jackpot == ''
            ) {
                swal("fields are missing", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: "btn btn-danger",
                        },
                    },
                });
                return;
            }

            $.ajax({
                type: "POST",
                url: getControl(),
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify({
                    _token: _token,
                    option: option,
                    drawing_id: drawing_id,
                    category: category,
                    drawing_date: drawing_date,
                    numbers: numbers,
                    jackpot: jackpot
                }),
                dataType: "json",
                success: function(response) {
                    swal(response.message + "", {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: "btn btn-success",
                            },
                        },
                    }).then((navigate) => {
                        window.location.href = "results";
                    });
                },
                failure: function(response) {
                    swal(xhr.responseJSON.message + "", {
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: "btn btn-danger",
                            },
                        },
                    });
                },
                error: function(response) {},
                timeout: 1000,
            });
        });
});

//Delete user
let user;
$(function(event) {
    $(".btn_delete")
        .off()
        .on("click", function(e) {
            var result = $(this).data("result");
            swal({
                title: "¿Delete result?",
                text: "¡you want to delete!",
                type: "warning",
                buttons: {
                    cancel: {
                        visible: true,
                        text: "No!",
                        className: "btn btn-danger",
                    },
                    confirm: {
                        text: "Yes!",
                        className: "btn btn-success",
                        afterSelect: function() {},
                    },
                },
            }).then((willCreate) => {
                if (willCreate) {
                    $.ajax({
                        type: "GET",
                        url: "results/" + result + "/delete",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                    });
                    swal("Hide on store!", {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: "btn btn-success",
                            },
                        },
                    }).then((navigate) => {
                        window.location.href = "results";
                    });
                } else {
                    swal("not removed!", {
                        buttons: {
                            confirm: {
                                className: "btn btn-danger",
                            },
                        },
                    });
                }
            });
        });
});


//cargar tomar data para tabla
$(document).ready(function() {
    $(function(event) {
        $('#AdminTickets').on('show.bs.modal', function(e) {
            var device = $(e.relatedTarget).data('device');
            TableProducts.ajax.url(getModelProducts(device)).load(function() {});
        });
    });
});
var device = 0;
$(document).ready(function(e) {
    TableProducts = $('#table_products').DataTable({
        "pageLength": 10,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'copy',
            text: 'Copiar'
        }, 'excel', 'pdf'],
        language: {
            buttons: {
                copyTitle: 'Copiado al portapapeles',
                copyKeys: 'Presione <i> ctrl </hr i> o <i> \ u2318 </ i> + <i> C </ i> para copiar los datos de la tabla a su portapapeles. <br> <br> Para cancelar, haga clic en este mensaje o presione Esc.',
                copySuccess: {
                    _: '%d filas copiadas',
                    1: '1 fila copiada'
                }
            }
        },
        "ajax": {
            type: "GET",
            url: getModelProducts(device),
            dataSrc: '',
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        },
        columns: [{
                data: "product_name"
            }, {
                data: "quantity"
            }, {
                data: "ticket_sold"
            },
            {
                data: "delivered"
            }
        ],
        /*,
        "columnDefs": [{
            "targets": [2],
            "render": function(data, type, row) {
                return '<td><button data-id_file="' + row.id + '" class="btn btn-icon btn-round btn-success download_file"><i class="fas fa-download"></i></button></td>';
            }
        }]
        */
    });
});