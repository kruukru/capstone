$(document).ready(function() {
    var violationid;
    var table = $('#tblViolation').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    $('#modalViolation').on('hide.bs.modal', function() {
        $('#formViolation').trigger('reset');
        $('#formViolation').parsley().reset();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Violation");
        $('#modalViolation').modal('show');
    });

    //display modal for update task
    $('#violation-list').on('click', '#btnUpdate', function() { 
        violationid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/violation/one",
            data: { inputViolationID: violationid, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#inputViolation').val(data.name);
                $('#inputViolationSeverity').val(data.severity);
                $('#inputViolationDescription').val(data.description);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Violation");
                $('#modalViolation').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#violation-list').on('click', '#btnRemove', function() {
        violationid = $(this).val();

        $('#modalViolationRemove').modal('show');
    });

    //remove task and remove it from the list
    $('#btnRemoveConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalViolationRemove').loading({
            message: "REMOVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/violation/remove",
            data: { inputViolationID: violationid },
            dataType: "json",
            success: function (data) {
                console.log(data);

                table.row('#id' + violationid).remove().draw(false);

                $('#modalViolationRemove').modal('hide');
                $('#modalViolationRemove').loading('stop');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function (data) {
                console.log(data);

                $('#modalViolationRemove').loading('stop');
            },
        });
    });

    //create new task / update existing task
    $("#btnSave").click(function (e) {
        if ($('#formViolation').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalViolation').loading({
                message: "SAVING..."
            });

            //used to determine the http verb to use
            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/maintenance/violation/new";
                var formData = {
                    inputViolation: $('#inputViolation').val(),
                    inputViolationSeverity: $('#inputViolationSeverity').val(),
                    inputViolationDescription: $('#inputViolationDescription').val(),
                }
            } else {
                var my_url = "/admin/maintenance/violation/update";
                var formData = {
                    inputViolationID: violationid,
                    inputViolation: $('#inputViolation').val(),
                    inputViolationSeverity: $('#inputViolationSeverity').val(),
                    inputViolationDescription: $('#inputViolationDescription').val(),
                }
            }

            $.ajax({
                type: "POST",
                url: my_url,
                data: formData,
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    if (data.description === null) {
                        data.description = '';
                    }

                    if ($('#btnSave').val() == "New") {
                        var row = "<tr id=id" + data.violationid + ">" +
                            "<td>" + data.name + "</td>" +
                            "<td>" + data.severity + "</td>" +
                            "<td>" + data.description + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.violationid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.violationid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        table.row.add($(row)[0]).draw();
                    } else {
                        var dt = [
                            data.name,
                            data.severity,
                            data.description,
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.violationid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.violationid+">Remove</button>",
                        ];

                        table.row('#id' + violationid).data(dt).draw(false);
                    }

                    $('#modalViolation').modal('hide');
                    $('#modalViolation').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function (data) {
                    console.log(data);

                    $('#modalViolation').loading('stop');
                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("VIOLATION ALREADY EXIST");
                    } else if (data.responseJSON == "SAME NAME TRASH") {
                        toastr.error("VIOLATION ALREADY EXIST IN ARCHIVE");
                    }
                }
            });
        }
    });
});