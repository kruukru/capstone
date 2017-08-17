$(document).ready(function() {
    var adminid, contractid;
    var table = $('#tblContract').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[1, 'asc']]).draw();



});