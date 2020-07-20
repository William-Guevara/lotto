//Datatable
$(document).ready(function () {
    $("#table_id").DataTable({
        "pageLength": 20,
        dom: 'Bfrtip',
        buttons: [
            'print'
        ],
        "order": [5,'desc']
    });
    
});