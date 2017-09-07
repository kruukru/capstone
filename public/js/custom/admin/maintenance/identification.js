$(document).ready(function() {
    var id;
    var table = $('#tblIdentification').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    $('#modalIdentification').on('hide.bs.modal', function() {
        $('#formIdentification').trigger("reset");
        $('#formIdentification').parsley().reset();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Identification");
        $('#modalIdentification').modal('show');
    });

    //display modal for update task
    $('#question-list').on('click', '#btnUpdate', function() { 
        id = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/identification/one",
            data: { inputQuestionID: id, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#inputQuestion').val(data.question);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Identification");
                $('#modalIdentification').modal('show');
            },
        });

        $.ajax({
            type: "GET",
            url: "/json/questionchoice/all",
            data: { inputQuestionID: id, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#inputChoice').val(data[0].answer);
            },
        });
    });

    //display modal for confirmation of remove
    $('#question-list').on('click', '#btnRemove', function() {
        id = $(this).val();

        $('#modalIdentificationRemove').modal('show');
    });

    //remove task and remove it from the list
    $('#btnRemoveConfirm').click(function(e) { 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        e.preventDefault();
        $('#modalIdentificationRemove').loading({
            message: "REMOVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/identification/remove",
            data: { inputQuestionID: id },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + id).remove().draw(false);

                $('#modalIdentificationRemove').modal('hide');
                $('#modalIdentificationRemove').loading('stop');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                $('#modalIdentificationRemove').loading('stop');
                if (data.responseJSON == "CANNOT REMOVE") {
                    toastr.error("CANNOT REMOVE WHILE BEING USED");
                }
            },
        });
    });

    //create new task / update existing task
    $('#btnSave').click(function (e) {
        if($('#formIdentification').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalIdentification').loading({
                message: "SAVING..."
            });

            //used to determine the http verb to use
            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/maintenance/identification/new";
                var formData = {
                    inputQuestion: $('#inputQuestion').val(),
                }
            } else {
                var my_url = "/admin/maintenance/identification/update";
                var formData = {
                    inputQuestionID: id,
                    inputQuestion: $('#inputQuestion').val(),
                }
            }

            var questionid = 0, question = "";
            $.ajax({
                type: "POST",
                url: my_url,
                data: formData,
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    questionid = data.questionid;
                    question = data.question;
                    var formData = [];
                    var data = {
                        inputChoice: $('#inputChoice').val(),
                        inputAnswer: 1,
                    };
                    formData.push(data);
                    formData = {
                        inputQuestionID: questionid,
                        formData: formData,
                    };

                    if ($('#btnSave').val() == "New") {
                        $.ajax({
                            type: "POST",
                            url: "/admin/maintenance/questionchoice/new",
                            data: formData,
                            dataType: "json",
                            success: function(data) {
                                console.log(data);

                                var row = "<tr id=id" + data.questionid + ">" +
                                    "<td>" + question + "</td>" +
                                    "<td>" + data.answer + "</td>" +
                                    "<td style='text-align: center;'>" +
                                    "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+questionid+">Update</button> " +
                                    "<button class='btn btn-danger btn-xs' id='btnRemove' value="+questionid+">Remove</button>" +
                                    "</td>" +
                                    "</tr>";

                                table.row.add($(row)[0]).draw();
                            },
                            error: function(data) {
                                console.log(data);
                            },
                        });
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "/admin/maintenance/questionchoice/update",
                            data: formData,
                            dataType: "json",
                            success: function(data) {
                                console.log(data);

                                var dt = [
                                    question,
                                    data.answer,
                                    "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+questionid+">Update</button> " +
                                    "<button class='btn btn-danger btn-xs' id='btnRemove' value="+questionid+">Remove</button>",
                                ];

                                table.row('#id' + questionid).data(dt).draw(false);
                            },
                            error: function(data) {
                                console.log(data);
                            },
                        });
                    }

                    $('#modalIdentification').modal('hide');
                    $('#modalIdentification').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function (data) {
                    console.log(data);

                    $('#modalIdentification').loading('stop');
                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("QUESTION ALREADY EXIST");
                    } else if (data.responseJSON == "SAME NAME TRASH") {
                        toastr.error("QUESTION ALREADY EXIST IN ARCHIVE");
                    }
                }
            });
        }
    });
});