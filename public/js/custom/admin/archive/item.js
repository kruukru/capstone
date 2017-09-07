$(document).ready(function() {
    var itemid;
    var table = $('#tblItem').DataTable({
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
    $('#item-list').on('click', '#btnRestore', function() {
        itemid = $(this).val();

        $('#modalItem').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalItem').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/item/restore",
            data: { inputItemID: itemid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + itemid).remove().draw(false);

                $('#modalItem').modal('hide');
                $('#modalItem').loading('stop');
                toastr.success("RESTORE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);
                
                $('#modalItem').loading('stop');
            },
        });
    });


});