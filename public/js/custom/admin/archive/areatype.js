$(document).ready(function() {
    var id;
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
        id = $(this).val();

        $('#modalAreaType').modal('show');
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
            url: "/admin/archive/areatype/restore",
            data: { inputAreaTypeID: id },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + id).remove().draw(false);
                $('#modalAreaType').modal('hide');

                toastr.success("Restore Successful");
            },
            error: function(data) {
                console.log(data);
            },
        });
    });


});