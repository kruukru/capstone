$(document).ready(function() {
    var id;
    var table = $('#tblCommend').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[3, 'desc']]).draw();

    //display modal for confirmation of restore
    $('#commend-list').on('click', '#btnRestore', function() {
        id = $(this).val();

        $('#modalCommend').modal('show');
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
            url: "/admin/archive/commend/restore",
            data: { inputCommendID: id },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + id).remove().draw(false);
                $('#modalCommend').modal('hide');

                toastr.success("Restore Successful");
            },
            error: function(data) {
                console.log(data);
            },
        });
    });


});