//Datatable
$(document).ready(function() {
    $("#table_id").DataTable({
        "pageLength": 20,
        "order": [0, 'asc']
    });
});