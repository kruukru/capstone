$(document).ready(function() {
    var itemtypeid;
    var table = $('#tblItemType').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[4, 'desc']]).draw();

    //display modal for confirmation of restore
    $('#itemtype-list').on('click', '#btnRestore', function() {
        itemtypeid = $(this).val();

        $('#modalItemType').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalItemType').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/itemtype/restore",
            data: { inputItemTypeID: itemtypeid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + itemtypeid).remove().draw(false);

                $('#modalItemType').modal('hide');
                $('#modalItemType').loading('stop');
                toastr.success("RESTORE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                $('#modalItemType').loading('stop');
            },
        });
    });



});