$(document).ready(function() {
    var requirementid;
    var table = $('#tblRequirement').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    //reset the modal when hide
    $('#modalRequirement').on('hide.bs.modal', function() {
        $('#formRequirement').trigger('reset');
        $('#formRequirement').parsley().reset();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Applicant Requirement");
        $('#modalRequirement').modal('show');
    });

    //display modal for update task
    $('#requirement-list').on('click', '#btnUpdate', function() { 
        requirementid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/requirement/one",
            data: { inputRequirementID: requirementid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#inputRequirement').val(data.name);
                $('#inputRequirementDescription').val(data.description);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Applicant Requirement");
                $('#modalRequirement').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#requirement-list').on('click', '#btnRemove', function() {
        requirementid = $(this).val();

        $('#modalRequirementRemove').modal('show');
    });

    //remove task and remove it from the list
    $('#btnRemoveConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalRequirementRemove').loading({
            message: "REMOVING...",
        });

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/requirement/remove",
            data: { inputRequirementID: requirementid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + requirementid).remove().draw(false);

                $('#modalRequirementRemove').modal('hide');
                $('#modalRequirementRemove').loading('stop');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);
                
                $('#modalRequirementRemove').loading('stop');
                if (data.responseJSON == "CANNOT REMOVE") {
                    toastr.error("CANNOT REMOVE WHILE BEING USED");
                }
            },
        });
    });

    //create new task / update existing task
    $('#btnSave').click(function(e) {
        if ($('#formRequirement').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalRequirement').loading({
                message: "SAVING...",
            });

            //used to determine the http verb to use
            var state = $('#btnSave').val();
            if (state == "New") {
                var my_url = "/admin/maintenance/requirement/new";
                var formData = {
                    inputRequirement: $('#inputRequirement').val(),
                    inputRequirementDescription: $('#inputRequirementDescription').val(),
                }
            } else {
                var my_url = "/admin/maintenance/requirement/update";
                var formData = {
                    inputRequirementID: requirementid,
                    inputRequirement: $('#inputRequirement').val(),
                    inputRequirementDescription: $('#inputRequirementDescription').val(),
                }
            }

            $.ajax({
                type: "POST",
                url: my_url,
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (data.description === null) {
                        data.description = '';
                    }

                    if ($('#btnSave').val() == "New") {
                        var row = "<tr id=id" + data.requirementid + ">" +
                            "<td>" + data.name + "</td>" +
                            "<td>" + data.description + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.requirementid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.requirementid+">Remove</button>" +
                            "</td>" +
                            "</tr>";
                        table.row.add($(row)[0]).draw();
                    } else {
                        var data = [
                            data.name,
                            data.description,
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.requirementid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.requirementid+">Remove</button>",
                        ];
                        table.row('#id' + requirementid).data(data).draw(false);
                    }

                    $('#modalRequirement').modal('hide');
                    $('#modalRequirement').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalRequirement').loading('stop');
                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("REQUIREMENT ALREADY EXIST");
                    } else if(data.responseJSON == "SAME NAME TRASH") {
                        toastr.error("REQUIREMENT ALREADY EXIST IN ARCHIVE");
                    }
                }
            });
        }
    });
});