$(document).ready(function() {
    var id;
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
        id = $(this).val();

        $('#modalItemType').modal('show');
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
            url: "/admin/archive/itemtype/restore",
            data: { inputItemTypeID: id },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + id).remove().draw(false);
                $('#modalItemType').modal('hide');
                
                toastr.success("Restore Successful");
            },
            error: function(data) {
                console.log(data);
            },
        });
    });


});