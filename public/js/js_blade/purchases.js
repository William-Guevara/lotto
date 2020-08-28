//Datatable
$(document).ready(function() {
    $("#table_id").DataTable({
        "pageLength": 20,
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
    $("#purchasesDetail")
        .off()
        .on("show.bs.modal", function(e) {
            var order_id = $(e.relatedTarget).data('order_id');
            $.ajax({
                type: "GET",
                url: "Detail/" + order_id,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                async: true,
                success: function(response) {
                    let user_id = 3;
                    let url = '<a href="users/' + user_id + '/detail" target="_blank">View customer perfil</a>';
                    $("#url_user").html(url);

                    $("#order_id").val(response.order_id);
                    $("#date").val(response.date);
                    $("#response_code").val(response.response_code);
                    $("#description_es").val(response.description_es);
                    $("#avs_code").val(response.avs_code);
                    $("#transaction_id").val(response.transaction_id);
                    $("#invoice_number").val(response.invoice_number);
                    $("#description").val(response.description);
                    $("#amount").val(response.amount);
                    $("#method").val(response.method);
                    $("#type").val(response.type);
                    //let user_id = response.cust_id;

                },
                failure: function(response) {},
                error: function(response) {},
                timeout: 10000,
            });

        });
});
//Fin cargar area


//cargar tomar data para tabla
$(document).ready(function() {
    $(function(event) {
        $('#purchasesDetail').on('show.bs.modal', function(e) {
            var order_id = $(e.relatedTarget).data('order_id');
            $("#order_id").val(order_id);
            TableProducts.ajax.url(getModalProducts(order_id)).load(function() {});
        });
    });
});
var order_id = 0;
$(document).ready(function(e) {
    TableProducts = $('#table_products').DataTable({
        "pageLength": 10,
        "ajax": {
            type: "GET",
            url: getModalProducts(order_id),
            dataSrc: '',
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        },
        columns: [{
                data: "product_name"
            }, {
                data: "quantity"
            }, {
                data: "promised"
            },
            {
                data: "tickets_received"
            },
            {
                data: "completion_timestamp"
            }
        ],
    });
});