$(document).ready(function() {
    var requirementid;
    var table = $('#tblSecurityGuard').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
        ]
    });
    table.order([[3, 'desc']]).draw();
});