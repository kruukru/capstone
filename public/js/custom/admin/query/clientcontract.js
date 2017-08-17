$(document).ready(function() {
    var requirementid;
    var table = $('#tblClient').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
        ]
    });
    table.order([[1, 'desc']]).draw();
});