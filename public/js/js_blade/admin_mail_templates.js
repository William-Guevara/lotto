//clean inputs
$(function(event) {
    $(".clear").click(function() {
        $(".campos").val("");
    });
});
var textarea = 0;

//Send mails
$(function(event) {
    $(".btn_sen_mail").click(function() {
        var template = $(this).data("template");
        var _token = $('._token').val();

        swal({
            title: '¿ Send E-mails ?',
            text: "¡You won't be able to reverse this!",
            type: 'warning',
            buttons: {
                cancel: {
                    visible: true,
                    text: 'No, cancel!',
                    className: 'btn btn-danger'
                },
                confirm: {
                    text: 'Yes, save!',
                    className: 'btn btn-success',
                    afterSelect: function() {
                        /* Agregar la navegacion a ordenes cargadas
                        var pathLabeling = "{{ route('OrdenEtiquetado') }}";
                        return $.get(pathLabeling);
                        */
                    }
                }
            }
        }).then((willCreate) => {
            if (willCreate) {
                $.ajax({
                    type: "POST",
                    url: getMail(template),
                    data: JSON.stringify({
                        "_token": _token,
                        'template': template
                    }),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: false,
                    success: function(response) {
                        swal("Emails Sent!", {
                            icon: "success",
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                    },
                    failure: function(response) {},
                    error: function(response) {},
                    timeout: 1000,
                });
            } else {
                swal("Not send!!", {
                    buttons: {
                        confirm: {
                            className: 'btn btn-success'
                        }
                    }
                });
            }
        });
    });
});

//data to modal
$(function(event) {
    $("#modalAdminTemplate")
        .off()
        .on("show.bs.modal", function(e) {
            if (textarea == 0) {
                textarea = document.getElementById('content_');
                sceditor.create(textarea, {
                    format: 'bbcode',
                    icons: 'monocons',
                    style: '../minified/themes/content/default.min.css'
                });
                // var themeInput = document.getElementById('theme');
            }
            var option = $(e.relatedTarget).data("option");
            var template = $(e.relatedTarget).data("template");
            var _token = $('._token').val();
            $("#option_select").val(option);
            if (option == "create") {
                $("#tittle_modal").text("Register template");
                return;
            }
            if (option == "update") {
                $("#tittle_modal").text("Update template");
                //var area = $(e.relatedTarget).data('area');
                $.ajax({
                    type: "POST",
                    url: "adminMailTemplate/" + template,
                    contentType: "application/json; charset=utf-8",
                    data: JSON.stringify({
                        _token: _token
                    }),
                    dataType: "json",
                    async: true,
                    success: function(response) {
                        //cargar funcion click envio de datos agrtegar area
                        $("#id").val(response.id);
                        $("#name").val(response.name);
                        $("#subject").val(response.subject);
                        $("#content_").val(response.content);
                    },
                    failure: function(response) {},
                    error: function(response) {},
                    timeout: 100000,
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
            let id = $("#id").val();
            let name = $("#name").val();
            let subject = $("#subject").val();
            let content_ = $("#content_").val();
            console.log(content_);
            if (
                name == '' ||
                subject == '' ||
                content_ == ''
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
                success: function(response) {
                    swal(response.message + "", {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: "btn btn-success",
                            },
                        },
                    }).then((navigate) => {
                        window.location.href = "adminMailTemplate";
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
                        afterSelect: function() {},
                    },
                },
            }).then((willCreate) => {
                if (willCreate) {
                    $.ajax({
                        type: "GET",
                        url: "adminMailTemplate/" + product + "/delete",
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
                        window.location.href = "adminMailTemplate";
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
$(".typeahead_country").typeahead({
    highlight: true,
    minLength: 1,
}, {
    name: "country",
    display: "country_name",
    limit: 20,
    source: function(query, syncResults, asyncResults) {
        return $.get(
            routCountry, {
                query: query,
            },
            function(data) {
                return asyncResults(data);
            }
        );
    },
});
$(".typeahead_country").bind("typeahead:select", function(ev, data) {
    $("#id_country").val(data.country_id);
});