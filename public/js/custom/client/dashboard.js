$(document).ready(function() {
	var tableAbsent = $('#tblAbsent').DataTable({
        "aoColumns": [
            null,
            null,
        ]
    });
    tableAbsent.order([[1, 'desc']]).draw();
    var tableLate = $('#tblLate').DataTable({
        "aoColumns": [
            null,
            null,
        ]
    });
    tableLate.order([[1, 'desc']]).draw();



});