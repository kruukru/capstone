$(document).ready(function() {
    var commendid;
    var table = $('#tblCommend').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ],
    });
    table.order([[0, 'asc']]).draw();

    $('#modalCommend').on('hide.bs.modal', function() {
        $('#formCommend').trigger('reset');
        $('#formCommend').parsley().reset();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Commend");
        $('#modalCommend').modal('show');
    });

    //display modal for update task
    $('#commend-list').on('click', '#btnUpdate', function() { 
        commendid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/commend/one",
            data: { inputCommendID: commendid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#inputCommend').val(data.name);
                $('#inputCommendDescription').val(data.description);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Commend");
                $('#modalCommend').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#commend-list').on('click', '#btnRemove', function() {
        commendid = $(this).val();

        $('#modalCommendRemove').modal('show');
    });

    //remove task and remove it from the list
    $('#btnRemoveConfirm').click(function(e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalCommendRemove').loading({
            message: "REMOVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/commend/remove",
            data: { inputCommendID: commendid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + commendid).remove().draw(false);

                $('#modalCommendRemove').modal('hide');
                $('#modalCommendRemove').loading('stop');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                $('#modalCommendRemove').loading('stop');
            },
        });
    });

    //create new task / update existing task
    $('#btnSave').click(function(e) {
        if ($('#formCommend').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalCommend').loading({
                message: "SAVING..."
            });

            //determine what type of task
            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/maintenance/commend/new";
                var formData = {
                    inputCommend: $('#inputCommend').val(),
                    inputCommendDescription: $('#inputCommendDescription').val(),
                }
            } else {
                var my_url = "/admin/maintenance/commend/update";
                var formData = {
                    inputCommendID: commendid,
                    inputCommend: $('#inputCommend').val(),
                    inputCommendDescription: $('#inputCommendDescription').val(),
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
                        var row = "<tr id=id" + data.commendid + ">" +
                            "<td>" + data.name + "</td>" +
                            "<td>" + data.description + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.commendid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.commendid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        table.row.add($(row)[0]).draw();
                    } else {
                        var data = [
                            data.name,
                            data.description,
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.commendid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.commendid+">Remove</button>",
                        ];

                        table.row('#id' + commendid).data(data).draw(false);
                    }

                    $('#modalCommend').modal('hide');
                    $('#modalCommend').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalCommend').loading('stop');
                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("COMMEND ALREADY EXIST");
                    } else if (data.responseJSON == "SAME NAME TRASH") {
                        toastr.error("COMMEND ALREADY EXIST IN ARCHIVE");
                    }
                },
            });
        }
    });
});