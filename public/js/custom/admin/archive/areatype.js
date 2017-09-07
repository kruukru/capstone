$(document).ready(function() {
    var areatypeid;
    var table = $('#tblAreaType').DataTable({
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
    $('#areatype-list').on('click', '#btnRestore', function() {
        areatypeid = $(this).val();

        $('#modalAreaType').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalAreaType').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/areatype/restore",
            data: { inputAreaTypeID: areatypeid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + areatypeid).remove().draw(false);

                $('#modalAreaType').modal('hide');
                $('#modalAreaType').loading('stop');
                toastr.success("RESTORE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                $('#modalAreaType').loading('stop');
            },
        });
    });


});