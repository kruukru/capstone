$(document).ready(function() {
    var itemtypeid;
    var table = $('#tblItemType').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    $('#modalItemType').on('hide.bs.modal', function() {
        $('#formItemType').trigger('reset');
        $('#formItemType').parsley().reset();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Item Type");
        $('#modalItemType').modal('show');
    });

    //display modal for update task
    $('#itemtype-list').on('click', '#btnUpdate', function() { 
        itemtypeid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/itemtype/one",
            data: { inputItemTypeID: itemtypeid, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#inputItemType').val(data.name);
                $('#inputItemTypeDescription').val(data.description);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Item Type");
                $('#modalItemType').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#itemtype-list').on('click', '#btnRemove', function() {
        itemtypeid = $(this).val();

        $('#modalItemTypeRemove').modal('show');
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
            url: "/admin/maintenance/itemtype/remove",
            data: { inputItemTypeID: itemtypeid },
            dataType: "json",
            success: function (data) {
                console.log(data);

                table.row('#id' + itemtypeid).remove().draw(false);

                $('#modalItemTypeRemove').modal('hide');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function (data) {
                console.log(data);

                toastr.error("CANNOT REMOVE WHILE BEING USED");
            },
        });
    });

    //create new task / update existing task
    $("#btnSave").click(function (e) {
        if($('#formItemType').parsley().isValid()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            e.preventDefault();

            //used to determine the http verb to use
            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/maintenance/itemtype/new";
                var formData = {
                    inputItemType: $('#inputItemType').val(),
                    inputItemTypeDescription: $('#inputItemTypeDescription').val(),
                }
            } else {
                var my_url = "/admin/maintenance/itemtype/update";
                var formData = {
                    inputItemTypeID: itemtypeid,
                    inputItemType: $('#inputItemType').val(),
                    inputItemTypeDescription: $('#inputItemTypeDescription').val(),
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
                        //if user added a new record
                        var row = "<tr id=id" + data.itemtypeid + ">" +
                            "<td>" + data.name + "</td>" +
                            "<td>" + data.description + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.itemtypeid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.itemtypeid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        table.row.add($(row)[0]).draw();
                    } else {
                        //if user updated an existing record
                        var dt = [
                            data.name,
                            data.description,
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.itemtypeid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.itemtypeid+">Remove</button>",
                        ];

                        table.row('#id' + itemtypeid).data(dt).draw(false);
                    }
                    
                    $('#modalItemType').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function (data) {
                    console.log(data);

                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("ITEM TYPE ALREADY EXIST");
                    } else if(data.responseJSON == "SAME NAME TRASH") {
                        toastr.error("ITEM TYPE ALREADY EXIST IN ARCHIVE");
                    }
                }
            });
        }
    });
});