//data to modal

$(function (event) {
    $(".lotto_category")
        .off()
        .on("click", function (e) {
            var category = $(this).data("category");
            window.location.href = getRouteLotto(category);
        });
});

$(function (event) {
    $(".lotto_category_client")
        .off()
        .on("click", function (e) {
            var category = $(this).data("category");
            window.location.href = getRouteLottoClient(category);
        });
});
