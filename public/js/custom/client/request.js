$(document).ready(function() {
    var itemid;
    var table = $('#tblRequest').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
    var tableInventory = $('#tblInventory').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableRequestItem = $('#tblRequestItem').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    //initialize the select2
    $('#deploymentsitelist').select2({
        theme: "bootstrap",
    });

    $('#btnNewRequestItem').click(function(e) {
        $('#deploymentsitelist').empty();
        tableInventory.clear().draw();
        tableRequestItem.clear().draw();
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "/client/request/deploymentsite",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    $('#deploymentsitelist').append('<option value='+value.deploymentsiteid+'>'+value.sitename+'</option>');
                });
            },
        });

        $.ajax({
            type: "GET",
            url: "/client/request/item",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr id=id" + value.itemid + ">" +
                        "<td id='name'>" + value.name + "</td>" +
                        "<td id='itemtypename'>" + value.item_type.name + "</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-primary btn-xs' id='btnAdd' value="+value.itemid+">Add</button> " +
                        "</td>" +
                        "</tr>";
                    tableInventory.row.add($(row)[0]).draw();
                });
            },
        });

        $('#modalRequestItem').modal('show');
    });

    $('#inventory-list').on('click', '#btnAdd', function(e) {
        e.preventDefault();
        itemid = $(this).val();

        var row = "<tr id=id" + itemid + ">" +
            "<td id='name'>" + $('#inventory-list').find('#id'+itemid).find('#name').text() + "</td>" +
            "<td id='itemtypename'>" + $('#inventory-list').find('#id'+itemid).find('#itemtypename').text() + "</td>" +
            "<td style='text-align: center;'>" +
                "<input type='text' id='approxqty' class='form-control' style='text-align: right; width: 75px;' pattern='^[1-9][0-9]*$' placeholder='Qty'>" +
            "</td>" +
            "<td style='text-align: center;'>" +
                "<button class='btn btn-danger btn-xs' id='btnRemove' value=" + itemid + ">Remove</button> " +
            "</td>" +
            "</tr>";
        tableRequestItem.row.add($(row)[0]).draw();
        tableInventory.row('#id' + itemid).remove().draw(false);
    });

    $('#requestitem-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();
        itemid = $(this).val();

        var row = "<tr id=id" + itemid + ">" +
            "<td id='name'>" + $('#requestitem-list').find('#id'+itemid).find('#name').text() + "</td>" +
            "<td id='itemtypename'>" + $('#requestitem-list').find('#id'+itemid).find('#itemtypename').text() + "</td>" +
            "<td style='text-align: center;'>" +
                "<button class='btn btn-primary btn-xs' id='btnAdd' value=" + itemid + ">Add</button> " +
            "</td>" +
            "</tr>";
        tableInventory.row.add($(row)[0]).draw();
        tableRequestItem.row('#id' + itemid).remove().draw(false);
    });

    $('#btnRequestItemSave').click(function(e) {
        if ($('#formRequestItem').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            if (tableRequestItem.row().count() == 0) {
                toastr.error("NO REQUEST ITEM");
                return;
            }

            var formData = [];
            $('#tblRequestItem > tbody > tr').each(function() {
                if ($(this).find('#approxqty').val() == "") {
                    $(this).find('#approxqty').val(0);
                }

                var data = {
                    inputItemID: $(this).find('#btnRemove').val(),
                    inputQty: $(this).find('#approxqty').val(),
                };
                formData.push(data);
            });

            formData = {
                inputDeploymentSiteID: $('#deploymentsitelist').val(),
                formData: formData,
            };

            $.ajax({
                type: "POST",
                url: "/client/request/item",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var row = "<tr id=id" + data.requestid + ">" +
                        "<td>" + data.requestid + "</td>" +
                        "<td>" + data.type + "</td>" +
                        "<td>Me</td>" +
                        "<td>" + data.deploymentsite.sitename + "</td>" +
                        "<td>" + data.deploymentsite.location + "</td>" +
                        "<td style='text-align: center;'>PENDING</td>" +
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-danger btn-xs' id='btnCancel' value="+data.requestid+">Cancel</button> " +
                        "</td>" +
                        "</tr>";
                    table.row.add($(row)[0]).draw();

                    $('#modalRequestItem').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
            });
        }
    });

    $('#request-list').on('click', '#btnCancel', function(e) {
        e.preventDefault();
        requestid = $(this).val();

        $('#modalCancelConfirmation').modal('show');
    });

    $('#btnRemoveConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/client/request/item/remove",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + requestid).remove().draw(false);
                
                $('#modalCancelConfirmation').modal('hide');
                toastr.success("CANCEL SUCCESSFUL");
            },
        });
    });



});