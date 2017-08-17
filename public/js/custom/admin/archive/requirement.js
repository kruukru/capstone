$(document).ready(function() {
    var id;
    var table = $('#tblRequirement').DataTable({
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
    $('#requirement-list').on('click', '#btnRestore', function() {
        id = $(this).val();

        $('#modalRequirement').modal('show');
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
            url: "/admin/archive/requirement/restore",
            data: { inputRequirementID: id },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + id).remove().draw(false);
                $('#modalRequirement').modal('hide');

                toastr.success("Restore Successful");
            },
            error: function(data) {
                console.log(data);
            },
        });
    });


});