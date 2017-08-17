$(document).ready(function() {
    var requirementid;
    var table = $('#tblClient').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    table.order([[2, 'desc']]).draw();
});