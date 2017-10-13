$(document).ready(function() {
    var table = $('#tblNotification').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    table.order([[2, 'asc']]).draw();



});