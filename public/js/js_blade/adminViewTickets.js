//add to menssage
$(function (event) {
    $(".btn_send_option")
        .off()
        .on("click", function (e) {
            var _token = $("._token").val();
            var category = $(".category").val();
            var drawing_date = $("#drawing_date").val();
            if (category == "" || category == 0 || drawing_date == "") {
                swal("Diligencia todos los campos", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: "btn btn-danger",
                        },
                    },
                });
                return;
            }
            window.location.href = getLoad(category, drawing_date);
            /*
            $.ajax({
                type: "GET",
                url: getLoad(category,drawing_date),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {},
                failure: function (response) {},
                error: function (response) {},
                timeout: 1000,
            });
            */
        });
});
