$(document).ready(function() {
    var table = $('#tblSecurityGuard').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[3, 'asc']]).draw();



});