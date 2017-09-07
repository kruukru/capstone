$(document).ready(function() {
    var questionid;
    var table = $('#tblQuestion').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[2, 'desc']]).draw();

    $('#cbQuestionType').on('change', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/question/change",
            data: { inputQuestionType: $('#cbQuestionType').val(), },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.clear().draw();
                $.each(data, function(index, value) {
                    console.log(value);

                    var row = "<tr id=id" + value.questionid + ">" +
                        "<td>" + value.questionid + "</td>" +
                        "<td>" + value.question + "</td>" +
                        "<td>" + value.deleted_at + "</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-success btn-xs' id='btnRestore' value="+value.questionid+">Restore</button> " +
                        "</td>" +
                        "</tr>";

                    table.row.add($(row)[0]).draw();
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    //display modal for confirmation of restore
    $('#question-list').on('click', '#btnRestore', function() {
        questionid = $(this).val();

        $('#modalQuestion').modal('show');
    });

    //restore task and remove it from the list
    $('#btnRestoreConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalQuestion').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/archive/question/restore",
            data: { inputQuestionID: questionid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + questionid).remove().draw(false);

                $('#modalQuestion').modal('hide');
                $('#modalQuestion').loading('stop');
                toastr.success("RESTORE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                $('#modalQuestion').loading('stop');
            },
        });
    });


});