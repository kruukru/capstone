$(document).ready(function() {
    var areatypeid;
    var table = $('#tblAreaType').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    //reset the modal when hide
    $('#modalAreaType').on('hide.bs.modal', function() {
        $('#formAreaType').trigger('reset');
        $('#formAreaType').parsley().reset();
    });

    //mask for price
    $('#inputAreaTypeAmountPerHour').inputmask({
        alias: "currency",
        prefix: '',
        radixPoint: '.',
        allowMinus: false,
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Area Type");
        $('#modalAreaType').modal('show');
    });

    //display modal for update task
    $('#areatype-list').on('click', '#btnUpdate', function() { 
        areatypeid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/areatype/one",
            data: { inputAreaTypeID: areatypeid, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#inputAreaType').val(data.name);
                $("#inputAreaTypeAmountPerHour").val(data.amountperhour);
                $('#inputAreaTypeDescription').val(data.description);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Area Type");
                $('#modalAreaType').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#areatype-list').on('click', '#btnRemove', function() {
        areatypeid = $(this).val();

        $('#modalAreaTypeRemove').modal('show');
    });

    //remove task and remove it from the list
    $('#btnRemoveConfirm').click(function(e) { 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        e.preventDefault();
        $('#modalAreaTypeRemove').loading({
            message: "REMOVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/areatype/remove",
            data: { inputAreaTypeID: areatypeid },
            dataType: "json",
            success: function (data) {
                console.log(data);

                table.row('#id' + areatypeid).remove().draw(false);

                $('#modalAreaTypeRemove').modal('hide');
                $('#modalAreaTypeRemove').loading('stop');
                toastr.success("REMOVE SUCCESSFUL")
            },
            error: function (data) {
                console.log(data);

                $('#modalAreaTypeRemove').loading('stop');
                if (data.responseJSON == "CANNOT REMOVE") {
                    toastr.error("CANNOT REMOVE WHILE BEING USED");
                }
            },
        });
    });

    //create new task / update existing task
    $("#btnSave").click(function (e) {
        if ($('#formAreaType').parsley().isValid()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            e.preventDefault();
            $('#modalAreaType').loading({
                message: "SAVING..."
            });

            if ($('#inputAreaTypeAmountPerHour').val() == 0) {
                toastr.error("INVALID AMOUNT PER HOUR");
                return;
            }

            //used to determine the http verb to use
            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/maintenance/areatype/new";
                var formData = {
                    inputAreaType: $('#inputAreaType').val(),
                    inputAreaTypeAmountPerHour: $("#inputAreaTypeAmountPerHour").val(),
                    inputAreaTypeDescription: $('#inputAreaTypeDescription').val(),
                }
            } else {
                var my_url = "/admin/maintenance/areatype/update";
                var formData = {
                    inputAreaTypeID: areatypeid,
                    inputAreaType: $('#inputAreaType').val(),
                    inputAreaTypeAmountPerHour: $("#inputAreaTypeAmountPerHour").val(),
                    inputAreaTypeDescription: $('#inputAreaTypeDescription').val(),
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
                        var row = "<tr id=id" + data.areatypeid + ">" +
                            "<td>" + data.name + "</td>" +
                            "<td>" + data.amountperhour + "</td>" +
                            "<td>" + data.description + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.areatypeid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.areatypeid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        table.row.add($(row)[0]).draw();
                    } else {
                        var dt = [
                            data.name,
                            data.amountperhour,
                            data.description,
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.areatypeid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.areatypeid+">Remove</button>",
                        ];

                        table.row('#id' + areatypeid).data(dt).draw(false);
                    }

                    $('#modalAreaType').modal('hide');
                    $('#modalAreaType').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function (data) {
                    console.log(data);

                    $('#modalAreaType').loading('stop');
                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("AREA TYPE ALREADY EXIST");
                    } else if(data.responseJSON == "SAME NAME TRASH") {
                        toastr.error("AREA TYPE ALREADY EXIST IN ARCHIVE");
                    }
                }
            });
        }
    });
});