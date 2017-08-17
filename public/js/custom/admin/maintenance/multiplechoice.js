$(document).ready(function() {
    var id;
    var idTable = 0;
    var table = $('#tblMultipleChoice').DataTable({
        "aoColumns": [
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
    var tableChoice = $('#tblChoice').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    //checkbox
    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
    });

    //reset the modal when hide
    $('#modalMultipleChoice').on('hide.bs.modal', function() {
        $('#formMultipleChoice').trigger("reset");
        $('#formChoice').trigger("reset");
        $('#formMultipleChoice').parsley().reset();
        $('#formChoice').parsley().reset();
        $('#cbCorrect').prop('checked', false).iCheck('update');
        tableChoice.clear().draw();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Multiple Choice");
        $('#modalMultipleChoice').modal('show');
    });

    //display modal for update task
    $('#question-list').on('click', '#btnUpdate', function() { 
        id = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/multiplechoice/one",
            data: { inputQuestionID: id, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#inputQuestion').val(data.question);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Multiple Choice");
                $('#modalMultipleChoice').modal('show');
            },
        });

        $.ajax({
            type: "GET",
            url: "/json/questionchoice/all",
            data: { inputQuestionID: id, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                idTable = 0;
                $.each(data, function(index, value) {
                    console.log(index + " / " + value);

                    if (value.iscorrect == 1) {
                        value.iscorrect = "Correct";
                    } else {
                        value.iscorrect = "Wrong";
                    }

                    var row = "<tr id=choice" + idTable + ">" +
                        "<td id='tdChoice'>" + value.answer + "</td>" +
                        "<td style='text-align: center;' id='tdCorrect'>" + value.iscorrect + "</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-danger btn-xs' id='btnChoiceRemove' value="+ idTable +">Remove</button></td>" +
                        "</td>" +
                        "</tr>";

                    tableChoice.row.add($(row)[0]).draw();
                    idTable++;
                });
            },
        });
    });

    //add choice to the table
    $('#btnChoiceAdd').click(function(e) {
        var check = true;

        if($('#formChoice').parsley().isValid()) {
            e.preventDefault();

            $('#tblChoice > tbody > tr').each(function() {
                if ($(this).find('#tdChoice').text() == $('#inputChoice').val()) {
                    check = false;
                } 
            });

            if (check) {
                var isCorrect = '';

                if($('#cbCorrect').is(":checked")) {
                    isCorrect = 'Correct';
                } else {
                    isCorrect = 'Wrong';
                }

                var row = "<tr id=choice" + idTable + ">" +
                    "<td id='tdChoice'>" + $('#inputChoice').val() + "</td>" +
                    "<td style='text-align: center;' id='tdCorrect'>" + isCorrect + "</td>" +
                    "<td style='text-align: center;'>" +
                        "<button class='btn btn-danger btn-xs' id='btnChoiceRemove' value="+ idTable +">Remove</button></td>" +
                    "</td>" +
                    "</tr>";

                tableChoice.row.add($(row)[0]).draw();
                $('#formChoice').trigger("reset");
                $('#formChoice').parsley().reset();
                $('#cbCorrect').prop('checked', false).iCheck('update');
                idTable++;
            } else {
                toastr.error("CHOICE ALREADY EXIST");
            }
        }
    });

    //remove choice from the table
    $('#choice-list').on('click', '#btnChoiceRemove', function(e) {
        e.preventDefault();

        tableChoice.row('#choice' + $(this).val()).remove().draw(false);
    });

    //display modal for confirmation of remove
    $('#question-list').on('click', '#btnRemove', function() {
        id = $(this).val();

        $('#modalMultipleChoiceRemove').modal('show');
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
            url: "/admin/maintenance/multiplechoice/remove",
            data: { inputQuestionID: id },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + id).remove().draw(false);
                toastr.success("REMOVE SUCCESSFUL");
                $('#modalMultipleChoiceRemove').modal('hide');
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
        var check = true;
        var correct = 0, wrong = 0;

        if ($('#formMultipleChoice').parsley().validate()) {
            e.preventDefault();

            $('#tblChoice > tbody > tr > td:nth-child(2)').each(function() {
                if ($(this).text() == "Correct") {
                    correct++;
                } else {
                    wrong++;
                }
            });

            if ($('#tblChoice > tbody > tr').length == 0) { // if check has rows proceed delete only
                toastr.error("INVALID CHOICE");
                check = false;
            } else if (correct == 0) {
                toastr.error("MUST HAVE ATLEAST 1 CORRECT ANSWER");
                check = false;
            } else if (wrong == 0) {
                toastr.error("MUST HAVE ATLEAST 1 WRONG CHOICE");
                check = false;
            }

            if (check) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })

                //used to determine the http verb to use
                if ($('#btnSave').val() == "New") {
                    var my_url = "/admin/maintenance/multiplechoice/new";
                    var formData = {
                        inputQuestion: $('#inputQuestion').val(),
                    }
                } else {
                    var my_url = "/admin/maintenance/multiplechoice/update";
                    var formData = {
                        inputQuestionID: id,
                        inputQuestion: $('#inputQuestion').val(),
                    }
                }

                var questionid = 0;
                $.ajax({
                    type: "POST",
                    url: my_url,
                    data: formData,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);

                        questionid = data.questionid;
                        var row = "<tr id=id" + data.questionid + ">" +
                            "<td>" + data.question + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.questionid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.questionid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        if ($('#btnSave').val() == "New") {
                            //if user added a new record
                            table.row.add($(row)[0]).draw();
                        } else {
                            //if user updated an existing record`
                            var data = [
                                data.question,
                                "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.questionid+">Update</button> " +
                                "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.questionid+">Remove</button>",
                            ];
                            table.row('#id' + questionid).data(data).draw(false);

                            $.ajax({
                                type: "POST",
                                url: "/admin/maintenance/questionchoice/remove",
                                data: { inputQuestionID: questionid, },
                                dataType: "json",
                                success: function(data) {
                                    console.log(data);
                                },
                            });
                        }

                        var formData = [];
                        $('#tblChoice > tbody > tr').each(function() {
                            if($(this).find('#tdCorrect').text() == "Correct") {
                                $(this).find('#tdCorrect').text("1");
                            } else {
                                $(this).find('#tdCorrect').text("0");
                            }

                            var data = {
                                inputChoice: $(this).find('#tdChoice').text(),
                                inputAnswer: $(this).find('#tdCorrect').text(),
                            };

                            formData.push(data);
                        });

                        formData = { 
                            inputQuestionID: questionid,
                            formData: formData,
                        };

                        $.ajax({
                            type: "POST",
                            url: "/admin/maintenance/questionchoice/new",
                            data: formData,
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                            },
                        });

                        $('#modalMultipleChoice').modal('hide');
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
        }
    });
});