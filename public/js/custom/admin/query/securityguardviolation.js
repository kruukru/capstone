$(document).ready(function() {
    var requirementid;
    var table = $('#tblSecurityGuard').DataTable({
        "aoColumns": [
            null,
            null,
        ]
    });
    table.order([[1, 'desc']]).draw();
});