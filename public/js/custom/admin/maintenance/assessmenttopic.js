$(document).ready(function() {
    var assessmenttopicid;
    var table = $('#tblAssessmentTopic').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ],
    });
    table.order([[0, 'asc']]).draw();

    //reset the modal when hide
    $('#modalAssessmentTopic').on('hide.bs.modal', function() {
        $('#formAssessmentTopic').trigger('reset');
        $('#formAssessmentTopic').parsley().reset();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Assessment Topic");
        $('#modalAssessmentTopic').modal('show');
    });

    //display modal for update task
    $('#assessmenttopic-list').on('click', '#btnUpdate', function() { 
        assessmenttopicid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/assessmenttopic/one",
            data: { inputAssessmentTopicID: assessmenttopicid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#inputAssessmentTopic').val(data.name);
                $('#inputAssessmentTopicDescription').val(data.description);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Assessment Topic");
                $('#modalAssessmentTopic').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#assessmenttopic-list').on('click', '#btnRemove', function() {
        assessmenttopicid = $(this).val();

        $('#modalAssessmentTopicRemove').modal('show');
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
            url: "/admin/maintenance/assessmenttopic/remove",
            data: { inputAssessmentTopicID: assessmenttopicid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + assessmenttopicid).remove().draw(false);

                $('#modalAssessmentTopicRemove').modal('hide');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                if (data.responseJSON == "CANNOT REMOVE"); {
                    toastr.error("CANNOT REMOVE WHILE BEING USED");
                }
            },
        });
    });

    //create new task / update existing task
    $('#btnSave').click(function(e) {
        if($('#formAssessmentTopic').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            //determine what type of task
            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/maintenance/assessmenttopic/new";
                var formData = {
                    inputAssessmentTopic: $('#inputAssessmentTopic').val(),
                    inputAssessmentTopicDescription: $('#inputAssessmentTopicDescription').val(),
                }
            } else {
                var my_url = "/admin/maintenance/assessmenttopic/update";
                var formData = {
                    inputAssessmentTopicID: assessmenttopicid,
                    inputAssessmentTopic: $('#inputAssessmentTopic').val(),
                    inputAssessmentTopicDescription: $('#inputAssessmentTopicDescription').val(),
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
                        var row = "<tr id=id" + data.assessmenttopicid + ">" +
                            "<td>" + data.name + "</td>" +
                            "<td>" + data.description + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.assessmenttopicid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.assessmenttopicid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        table.row.add($(row)[0]).draw();
                    } else {
                        var data = [
                            data.name,
                            data.description,
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.assessmenttopicid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.assessmenttopicid+">Remove</button>",
                        ];

                        table.row('#id' + assessmenttopicid).data(data).draw(false);
                    }

                    $('#modalAssessmentTopic').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("ASSESSMENT TOPIC ALREADY EXIST");
                    } else if(data.responseJSON == "SAME NAME TRASH") {
                        toastr.error("ASSESSMENT TOPIC ALREADY EXIST IN ARCHIVE");
                    }
                },
            });
        }
    });
});