$(document).ready(function() {
    var violationid;
    var table = $('#tblViolation').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[4, 'desc']]).draw();

    //display modal for confirmation of restore
    $('#violation-list').on('click', '#btnRestore', function() {
        violationid = $(this).val();

        $('#modalViolation').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalViolation').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/violation/restore",
            data: { inputViolationID: violationid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + violationid).remove().draw(false);

                $('#modalViolation').modal('hide');
                $('#modalViolation').loading('stop');
                toastr.success("RESTORE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                $('#modalViolation').loading('stop');
            },
        });
    });


});