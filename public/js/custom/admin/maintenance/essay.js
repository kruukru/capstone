$(document).ready(function() {
    var id;
    var table = $('#tblEssay').DataTable({
        "aoColumns": [
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    $('#modalEssay').on('hide.bs.modal', function() {
        $('#formEssay').trigger("reset");
        $('#formEssay').parsley().reset();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Essay");
        $('#modalEssay').modal('show');
    });

    //display modal for update task
    $('#question-list').on('click', '#btnUpdate', function() { 
        id = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/essay/one",
            data: { inputQuestionID: id, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#inputQuestion').val(data.question);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Essay");
                $('#modalEssay').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#question-list').on('click', '#btnRemove', function() {
        id = $(this).val();

        $('#modalEssayRemove').modal('show');
    });

    //remove task and remove it from the list
    $('#btnRemoveConfirm').click(function(e) { 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/essay/remove",
            data: { inputQuestionID: id },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + id).remove().draw(false);
                toastr.success("REMOVE SUCCESSFUL");
                $('#modalEssayRemove').modal('hide');
            },
            error: function(data) {
                console.log(data);

                if(data.responseJSON == "BEING USED") {
                    toastr.error("CANNOT REMOVE WHILE BEING USED");
                }
            },
        });
    });

    //create new task / update existing task
    $('#btnSave').click(function (e) {
        if($('#formEssay').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            //used to determine the http verb to use
            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/maintenance/essay/new";
                var formData = {
                    inputQuestion: $('#inputQuestion').val(),
                }
            } else {
                var my_url = "/admin/maintenance/essay/update";
                var formData = {
                    inputQuestionID: id,
                    inputQuestion: $('#inputQuestion').val(),
                }
            }

            $.ajax({
                type: "POST",
                url: my_url,
                data: formData,
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    if ($('#btnSave').val() == "New") {
                        var row = "<tr id=id" + data.questionid + ">" +
                            "<td>" + data.question + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.questionid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.questionid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        table.row.add($(row)[0]).draw();
                    } else {
                        var dt = [
                            data.question,
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.questionid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.questionid+">Remove</button>",
                        ];

                        table.row('#id' + data.questionid).data(dt).draw(false);
                    }

                    $('#modalEssay').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function (data) {
                    console.log(data);

                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("QUESTION ALREADY EXIST");
                    }
                }
            });
        }
    });
});