$(document).ready(function() {
    var itemid;
    var table = $('#tblItem').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    $('#modalItem').on('hide.bs.modal', function() {
        $('#formItem').trigger('reset');
        $('#formItem').parsley().reset();
        $('#inputItemType').empty();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $.ajax({
            type: "GET",
            url: "/json/itemtype/all",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    console.log(index + " / " + value);

                    $('#inputItemType').append("<option value="+value.itemtypeid+">"+value.name+"</option>");
                });
            },
        });

        $('#btnSave').val("New");
        $('#modalTitle').text("New Item");
        $('#modalItem').modal('show');
    });

    //display modal for update task
    $('#item-list').on('click', '#btnUpdate', function() { 
        itemid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/itemtype/all",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    console.log(index + " / " + value);

                    $('#inputItemType').append("<option value="+value.itemtypeid+">"+value.name+"</option>");
                });
            },
        });

        $.ajax({
            type: "GET",
            url: "/json/item/one",
            data: { inputItemID: itemid, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                $('#inputItemType').val(data.itemtypeid);
                $('#inputItem').val(data.name);
                $('#inputItemDescription').val(data.description);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Item");
                $('#modalItem').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#item-list').on('click', '#btnRemove', function() {
        itemid = $(this).val();

        $('#modalItemRemove').modal('show');
    });

    //remove task and remove it from the list
    $('#btnRemoveConfirm').click(function(e) { 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        e.preventDefault();
        $('#modalItemRemove').loading({
            message: "REMOVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/maintenance/item/remove",
            data: { inputItemID: itemid, },
            dataType: "json",
            success: function (data) {
                console.log(data);

                table.row('#id' + itemid).remove().draw(false);

                $('#modalItemRemove').modal('hide');
                $('#modalItemRemove').loading('stop');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function (data) {
                console.log(data);

                $('#modalItemRemove').loading('stop');
                if (data.responseJSON == "CANNOT REMOVE") {
                    toastr.error("CANNOT REMOVE WHILE BEING USED");
                }
            },
        });
    });

    //create new task / update existing task
    $("#btnSave").click(function (e) {
        if($('#formItem').parsley().isValid()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            e.preventDefault();
            $('#modalItem').loading({
                message: "SAVING..."
            });

            //used to determine the http verb to use
            var state = $('#btnSave').val();
            if (state == "New") {
                var my_url = "/admin/maintenance/item/new";
                var formData = {
                    inputItemType: $('#inputItemType').val(),
                    inputItem: $('#inputItem').val(),
                    inputItemDescription: $('#inputItemDescription').val(),
                }
            } else {
                var my_url = "/admin/maintenance/item/update";
                var formData = {
                    inputItemID: itemid,
                    inputItemType: $('#inputItemType').val(),
                    inputItem: $('#inputItem').val(),
                    inputItemDescription: $('#inputItemDescription').val(),
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

                    if (state == "New") {
                        var row = "<tr id=id" + data.itemid + ">" +
                            "<td>" + data.name + "</td>" +
                            "<td>" + data.itemtype.name + "</td>" +
                            "<td>" + data.description + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.itemid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.itemid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        table.row.add($(row)[0]).draw();
                    } else {
                        var dt = [
                            data.name,
                            data.itemtype.name,
                            data.description,
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.itemid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.itemid+">Remove</button>",
                        ];

                        table.row('#id' + itemid).data(dt).draw(false);
                    }
                    
                    $('#modalItem').modal('hide');
                    $('#modalItem').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function (data) {
                    console.log(data);

                    $('#modalItem').loading('stop');
                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("ITEM ALREADY EXIST");
                    } else if(data.responseJSON == "SAME NAME TRASH") {
                        toastr.error("ITEM ALREADY EXIST IN ARCHIVE");
                    }
                }
            });
        }
    });
});