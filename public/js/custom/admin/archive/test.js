$(document).ready(function() {
    var id;
    var id;
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
        id = $(this).val();

        $('#modalTest').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        $.ajax({
            type: "POST",
            url: "/admin/archive/test/restore",
            data: { inputTestID: id },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + id).remove().draw(false);
                $('#modalTest').modal('hide');

                toastr.success("Restore Successful");
            },
            error: function(data) {
                console.log(data);
            },
        });
    });


});