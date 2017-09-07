$(document).ready(function() {
    var requirementid;
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
        requirementid = $(this).val();

        $('#modalRequirement').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalRequirement').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/requirement/restore",
            data: { inputRequirementID: requirementid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + requirementid).remove().draw(false);

                $('#modalRequirement').modal('hide');
                $('#modalRequirement').loading('stop');
                toastr.success("RESTORE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                $('#modalRequirement').loading('stop');
            },
        });
    });


});