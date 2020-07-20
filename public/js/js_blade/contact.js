//Check ip
let ip;
$.ajaxSetup({ async: false });
$.get('https://api.ipify.org?format=json', function(r) { ip = r.ip; });

//add to menssage
$(function(event) {
    $('#btn_send').off().on("click", function(e) {
        var _token = $('._token').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var comments = $('#comments').val();
        if (name == "" || email == "" || comments == "") {
            swal('Diligencia todos los campos', {
                icon: "error",
                buttons: {
                    confirm: {
                        className: 'btn btn-danger'
                    }
                }
            });
            return;
        };

        $.ajax({
            type: "POST",
            url: getAddContact(),
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify({
                '_token': _token,
                'full_name': name,
                'email': email,
                'menssage': comments,
                'IP': ip
            }),
            dataType: "json",
            success: function(response) {
                swal(response.message + '', {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: 'btn btn-success'
                        }
                    }
                }).then((navigate) => {
                    window.location.href = "contact_us";
                });
            },
            failure: function(response) {
                swal(xhr.responseJSON.message + '', {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: 'btn btn-danger'
                        }
                    }
                });
            },
            error: function(response) {

            },
            timeout: 1000
        });
    });
});
