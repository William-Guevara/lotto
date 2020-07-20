//clean inputs
$(function (event) {
    $(".clear").click(function () {
        $(".campos").val("");
    });
});

//data to modal
$(function (event) {
    $("#modalAdminProduct")
        .off()
        .on("show.bs.modal", function (e) {
            var option = $(e.relatedTarget).data("option");
            var product = $(e.relatedTarget).data("product");
            $("#option_select").val(option);
            if (option == "create") {
                $("#tittle_modal").text("Register product");
                return;
            }
            if (option == "update") {
                $("#tittle_modal").text("Update product");
                //var area = $(e.relatedTarget).data('area');
                $.ajax({
                    type: "GET",
                    url: "products/" + product,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: true,
                    success: function (response) {
                        //cargar funcion click envio de datos agrtegar area
                        $("#product_id").val(response.product_id);
                        $("#name_en").val(response.name_en);
                        $("#description_en").val(response.description_en);
                        $("#name_es").val(response.name_es);
                        $("#description_es").val(response.description_es);
                        $("#duration_months").val(response.duration_months);
                        $("#total_games").val(response.total_games);
                        $("#category").val(response.category);
                        $("#price").val(response.price);
                        $("#display").val(response.display);
                    },
                    failure: function (response) {},
                    error: function (response) {},
                    timeout: 10000,
                });
            }
        });
});
//Fin cargar area

//add or update product send
$(function (event) {
    $("#btn_send")
        .off()
        .on("click", function (e) {
            let option = $("#option_select").val();
            let product_id = $("#product_id").val();
            let name_en = $("#name_en").val();
            let description_en = $("#description_en").val();
            let name_es = $("#name_es").val();
            let description_es = $("#description_es").val();
            let duration_months = $("#duration_months").val();
            let total_games = $("#total_games").val();
            let category = $("#category").val();
            let price = $("#price").val();
            let display = $("#display").val();
            var _token = $("._token").val();
            if (
                name_en == '' ||
                description_en == '' ||
                name_es == '' ||
                description_es == '' ||
                duration_months == '' ||
                total_games == '' ||
                category == '' ||
                price == '' ||
                display == '' 
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
                    product_id: product_id,
                    name_en: name_en,
                    description_en: description_en,
                    name_es: name_es,
                    description_es: description_es,
                    duration_months: duration_months,
                    total_games: total_games,
                    category: category,
                    price: price,
                    display: display,
                }),
                dataType: "json",
                success: function (response) {
                    swal(response.message + "", {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: "btn btn-success",
                            },
                        },
                    }).then((navigate) => {
                        window.location.href = "products";
                    });
                },
                failure: function (response) {
                    swal(xhr.responseJSON.message + "", {
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: "btn btn-danger",
                            },
                        },
                    });
                },
                error: function (response) {},
                timeout: 1000,
            });
        });
});

//Delete user
let user;
$(function (event) {
    $(".btn_delete")
        .off()
        .on("click", function (e) {
            var product = $(this).data("product");
            swal({
                title: "¿Delete product?",
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
                        afterSelect: function () {},
                    },
                },
            }).then((willCreate) => {
                if (willCreate) {
                    $.ajax({
                        type: "GET",
                        url: "products/" + product + "/delete",
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
                        window.location.href = "products";
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

var routCountry = "country_typea";
$(".typeahead_country").typeahead(
    {
        highlight: true,
        minLength: 1,
    },
    {
        name: "country",
        display: "country_name",
        limit: 20,
        source: function (query, syncResults, asyncResults) {
            return $.get(
                routCountry,
                {
                    query: query,
                },
                function (data) {
                    return asyncResults(data);
                }
            );
        },
    }
);
$(".typeahead_country").bind("typeahead:select", function (ev, data) {
    $("#id_country").val(data.country_id);
});
