$(document).ready(function() {
    var itemid;
    var table = $('#tblReport').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    $('#btnNewCommendReport').click(function(e) {
        e.preventDefault();

        $('#modalReport').modal('show');
    });

    $('#btnNewViolationReport').click(function(e) {
        e.preventDefault();
        
        $('#modalReport').modal('show');
    });



});