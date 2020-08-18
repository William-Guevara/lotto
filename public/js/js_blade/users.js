//clean inputs
$(function(event) {
    $(".clear").click(function() {
        $(".campos").val("");
    });
});
//data to modal
$(function(event) {
    $("#modalUserAdmin")
        .off()
        .on("show.bs.modal", function(e) {
            var option = $(e.relatedTarget).data("option");
            var user = $(e.relatedTarget).data("user");
            $("#option_select").val(option);
            if (option == "create") {
                $("#tittle_modal").text("Register user");
                return;
            }
            if (option == "update") {
                $("#tittle_modal").text("Update user");
                //var area = $(e.relatedTarget).data('area');
                $.ajax({
                    type: "GET",
                    url: "users/" + user,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async: true,
                    success: function(response) {
                        //cargar funcion click envio de datos agrtegar area
                        $("#user_id").val(response.user_id);
                        $("#Email").val(response.email);
                        $("#Email2").val(response.email2);
                        $("#Password").val(response.password);
                        $("#FirstName").val(response.fname);
                        $("#LastName").val(response.lname);
                        $("#Address").val(response.address);
                        $("#City").val(response.city);
                        $("#State").val(response.state);
                        $("#ZipCode").val(response.zip_code);
                        $("#id_country").val(response.country_id);
                        $(".typeahead_country").val(response.country_name);
                        $("#Phone").val(response.phone);
                        $("#Fax").val(response.fax);
                        $("#Gender").val(response.gender);
                        $("#Credits").val(response.credits);
                        $("#Newsletter").val(response.newsletter);
                        $("#Language").val(response.language);
                        $("#Level").val(response.level);
                    },
                    failure: function(response) {},
                    error: function(response) {},
                    timeout: 10000,
                });
            }
        });
});
//Fin cargar area

//add or update user send
$(function(event) {
    $("#btn_send")
        .off()
        .on("click", function(e) {
            let option = $("#option_select").val();
            let user_id = $("#user_id").val();
            let Email = $("#Email").val();
            let Email2 = $("#Email2").val();
            let Password = $("#Password").val();
            let FirstName = $("#FirstName").val();
            let LastName = $("#LastName").val();
            let Address = $("#Address").val();
            let City = $("#City").val();
            let State = $("#State").val();
            let ZipCode = $("#ZipCode").val();
            let Country = $("#id_country").val();
            let Phone = $("#Phone").val();
            let Fax = $("#Fax").val();
            let Gender = $("#Gender").val();
            let Credits = $("#Credits").val();
            let Newsletter = $("#Newsletter").val();
            let Lenguage = $("#Language").val();
            let Level = $("#Level").val();
            var _token = $("._token").val();
            if (
                Email == "" ||
                Password == "" ||
                FirstName == "" ||
                LastName == "" ||
                Address == "" ||
                City == "" ||
                State == "" ||
                ZipCode == "" ||
                Country == "" ||
                Phone == "" ||
                Fax == "" ||
                Gender == "" ||
                Credits == "" ||
                Newsletter == "" ||
                Lenguage == "" ||
                Level == ""
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

            var comments = $("#comments").val();
            $.ajax({
                type: "POST",
                url: getControl(),
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify({
                    _token: _token,
                    option: option,
                    user_id: user_id,
                    Email: Email,
                    Email2: Email2,
                    Password: Password,
                    FirstName: FirstName,
                    LastName: LastName,
                    Address: Address,
                    City: City,
                    State: State,
                    ZipCode: ZipCode,
                    Country: Country,
                    Phone: Phone,
                    Fax: Fax,
                    Gender: Gender,
                    Credits: Credits,
                    Newsletter: Newsletter,
                    Language: Lenguage,
                    Level: Level,
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
                        window.location.href = "users";
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

//detail user
$(function(event) {
    $(".btn_detail")
        .off()
        .on("click", function(e) {
            var user = $(this).data("user");
            window.location.href = getUserAcount(user);
        });
});
//Delete user
$(function(event) {
    $(".btn_delete")
        .off()
        .on("click", function(e) {
            var user = $(this).data("user");
            swal({
                title: "¿Delete user?",
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
                        url: "users/" + user + "/delete",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                    });
                    swal("removed!", {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: "btn btn-success",
                            },
                        },
                    }).then((navigate) => {
                        window.location.href = "users";
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