$(document).ready(function() {
    var commendid;
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
        commendid = $(this).val();

        $('#modalCommend').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalCommend').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/commend/restore",
            data: { inputCommendID: commendid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + commendid).remove().draw(false);

                $('#modalCommend').modal('hide');
                $('#modalCommend').loading('stop');
                toastr.success("RESTORE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);
                
                $('#modalCommend').loading('stop');
            },
        });
    });


});