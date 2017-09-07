$(document).ready(function() {
    var testid;
    var table = $('#tblTest').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[5, 'desc']]).draw();

    //display modal for confirmation of restore
    $('#test-list').on('click', '#btnRestore', function() {
        testid = $(this).val();

        $('#modalTest').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalTest').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/test/restore",
            data: { inputTestID: testid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + testid).remove().draw(false);

                $('#modalTest').modal('hide');
                $('#modalTest').loading('stop');
                toastr.success("RESTORE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);
                
                $('#modalTest').loading('stop');
            },
        });
    });


});