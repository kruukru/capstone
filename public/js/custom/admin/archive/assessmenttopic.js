$(document).ready(function() {
    var assessmenttopicid;
    var table = $('#tblAssessmentTopic').DataTable({
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
    $('#assessmenttopic-list').on('click', '#btnRestore', function() {
        assessmenttopicid = $(this).val();

        $('#modalAssessmentTopic').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalAssessmentTopic').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/assessmenttopic/restore",
            data: { inputAssessmentTopicID: assessmenttopicid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + assessmenttopicid).remove().draw(false);

                $('#modalAssessmentTopic').modal('hide');
                $('#modalAssessmentTopic').loading('stop');
                toastr.success("RESTORE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                $('#modalAssessmentTopic').loading('stop');
            },
        });
    });


});