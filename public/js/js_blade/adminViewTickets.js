//add to menssage
$(function(event) {
    $(".btn_send_option")
        .off()
        .on("click", function(e) {
            var _token = $("._token").val();
            var category = $(".category").val();
            var drawing_date = $("#drawing_date").val();
            if (drawing_date == "") {
                //category == "" || category == 0 ||
                swal("Select drawing date", {
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
        });
});