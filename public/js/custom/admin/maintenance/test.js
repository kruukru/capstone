$(document).ready(function() {
    var id = '';
    var table = $('#tblTest').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
    var tableQuestionIN = $('#tblQuestionIN').DataTable({
        "aoColumns": [
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableQuestionOUT = $('#tblQuestionOUT').DataTable({
        "aoColumns": [
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    $('#modalTestQuestion').on('hide.bs.modal', function() {
        tableQuestionIN.clear().draw();
        tableQuestionOUT.clear().draw();
    });
    $('#modalTest').on('hide.bs.modal', function() {
        $('#formTest').trigger('reset');
        $('#formTest').parsley().reset();
    });

    //add question to the test
    $('#questionin-list').on('click', '#btnRemoveQuestion', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var qid = $(this).val();

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/testquestion/remove",
            data: { inputTestID: id, inputQuestionID: qid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var row = "<tr id=out"+data.questionid+">" +
                    "<td>" + data.question + "</td>" +
                    "<td style='text-align: center;'>" +
                    "<button style='padding: 0px 15px 0px 15px;' class='btn btn-primary btn-xs' id='btnAddQuestion' value="+data.questionid+">Add</button> " +
                    "</td>" +
                    "</tr>";

                tableQuestionOUT.row.add($(row)[0]).draw();
                tableQuestionIN.row('#in' + qid).remove().draw(false);
            },
        });
    });

    //remove question to the test
    $('#questionout-list').on('click', '#btnAddQuestion', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var qid = $(this).val();

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/testquestion/new",
            data: { inputTestID: id, inputQuestionID: qid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var row = "<tr id=in"+data.questionid+">" +
                    "<td>" + data.question + "</td>" +
                    "<td style='text-align: center;'>" +
                    "<button class='btn btn-primary btn-xs' id='btnRemoveQuestion' value="+data.questionid+">Remove</button> " +
                    "</td>" +
                    "</tr>";

                tableQuestionIN.row.add($(row)[0]).draw();
                tableQuestionOUT.row('#out' + qid).remove().draw(false);
            },
        });
    });

    $('#test-list').on('click', '#btnMultipleChoice', function() {
        id = $(this).val();
        getQuestion(0);
    });

    $('#test-list').on('click', '#btnTrueOrFalse', function() {
        id = $(this).val();
        getQuestion(1);
    });

    $('#test-list').on('click', '#btnIdentification', function() {
        id = $(this).val();
        getQuestion(2);
    });

    $('#test-list').on('click', '#btnEssay', function() {
        id = $(this).val();
        getQuestion(3);
    });

    function getQuestion(x) {
        $.ajax({
            type: "GET",
            url: "/admin/maintenance/testquestion/in",
            data: { inputTestID: id, inputQuestionType: x, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    console.log(index + " / " + value);

                    var row = "<tr id=in" + value.questionid + ">" +
                        "<td>" + value.question + "</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-primary btn-xs' id='btnRemoveQuestion' value="+value.questionid+">Remove</button> " +
                        "</td>" +
                        "</tr>";

                    tableQuestionIN.row.add($(row)[0]).draw();
                });
            },
        });

        $.ajax({
            type: "GET",
            url: "/admin/maintenance/testquestion/out",
            data: { inputTestID: id, inputQuestionType: x, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    console.log(index + " / " + value);

                    var row = "<tr id=out" + value.questionid + ">" +
                        "<td>" + value.question + "</td>" +
                        "<td style='text-align: center;'>" +
                        "<button style='padding: 0px 15px 0px 15px;' class='btn btn-primary btn-xs' " +
                        "id='btnAddQuestion' value="+value.questionid+">Add</button> " +
                        "</td>" +
                        "</tr>";

                    tableQuestionOUT.row.add($(row)[0]).draw();
                });
            },
        });

        $('#modalTestQuestion').modal('show');
    }

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Test Form");
        $('#modalTest').modal('show');
    });

    //display modal for update task
    $('#test-list').on('click', '#btnUpdate', function() { 
        id = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/test/one",
            data: { inputTestID: id, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#inputTest').val(data.name);
                $('#inputInstruction').val(data.instruction);
                $('#inputMaxQuestion').val(data.maxquestion);
                $('#inputTimeAlloted').val(data.timealloted);

                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Test Form");
                $('#modalTest').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#test-list').on('click', '#btnRemove', function() {
        id = $(this).val();

        $('#modalTestRemove').modal('show');
    });

    //remove task and remove it from the list
    $('#btnRemoveConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/test/remove",
            data: { inputTestID: id },
            dataType: "json",
            success: function (data) {
                console.log(data);

                table.row('#id' + id).remove().draw(false);
                $('#modalTestRemove').modal('hide');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function (data) {
                console.log(data);

                if (data.responseJSON == "CANNOT REMOVE") {
                    toastr.error("CANNOT REMOVE WHILE BEING USED");
                }
            },
        });
    });

    //create new task / update existing task
    $("#btnSave").click(function (e) {
        if($('#formTest').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            if ($('#timeallotedtype').val() == "hour") {
                $('#inputTimeAlloted').val($('#inputTimeAlloted').val() * 60);
            }

            //used to determine the http verb to use
            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/maintenance/test/new";
                var formData = {
                    inputTest: $('#inputTest').val(),
                    inputInstruction: $('#inputInstruction').val(),
                    inputMaxQuestion: $('#inputMaxQuestion').val(),
                    inputTimeAlloted: $('#inputTimeAlloted').val(),
                }
            } else {
                var my_url = "/admin/maintenance/test/update";
                var formData = {
                    inputTestID: id,
                    inputTest: $('#inputTest').val(),
                    inputInstruction: $('#inputInstruction').val(),
                    inputMaxQuestion: $('#inputMaxQuestion').val(),
                    inputTimeAlloted: $('#inputTimeAlloted').val(),
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
                        //add new task
                        var row = "<tr id=id" + data.testid + ">" +
                            "<td>" + data.name + "</td>" +
                            "<td>" + data.instruction + "</td>" +
                            "<td style='text-align: center;'>" + data.maxquestion + "</td>" +
                            "<td style='text-align: center;'>" + data.timealloted + "</td>" +
                            "<td style='text-align: center;'>" + 
                            "<button class='btn btn-primary btn-xs' id='btnMultipleChoice' value="+data.testid+">Multiple Choice</button> " +
                            "<button class='btn btn-primary btn-xs' id='btnTrueOrFalse' value="+data.testid+">True or False</button> " +
                            "<button class='btn btn-primary btn-xs' id='btnIdentification' value="+data.testid+">Identification</button> " +
                            "<button class='btn btn-primary btn-xs' id='btnEssay' value="+data.testid+">Essay</button>" +
                            "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.testid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.testid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        table.row.add($(row)[0]).draw();
                    } else {
                        //update existing task
                        var data = [
                            data.name,
                            data.instruction,
                            data.maxquestion,
                            data.timealloted,
                            "<button class='btn btn-primary btn-xs' id='btnMultipleChoice' value="+data.testid+">Multiple Choice</button> " +
                            "<button class='btn btn-primary btn-xs' id='btnTrueOrFalse' value="+data.testid+">True or False</button> " +
                            "<button class='btn btn-primary btn-xs' id='btnIdentification' value="+data.testid+">Identification</button> " +
                            "<button class='btn btn-primary btn-xs' id='btnEssay' value="+data.testid+">Essay</button>",
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.testid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.testid+">Remove</button>",
                        ];

                        table.row('#id' + id).data(data).draw(false);
                    }

                    $('#modalTest').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function (data) {
                    console.log(data);

                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("TEST ALREADY EXIST");
                    } else if(data.responseJSON == "SAME NAME TRASH") {
                        toastr.error("TEST ALREADY EXIST IN ARCHIVE");
                    }
                },
            });
        }
    });
});