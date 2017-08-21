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

                $('#modalRequestItem').modal('show');
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

                $('#modalRequestItem').modal('show');
            },
        });
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

            toastr.success("HELLO");
        }
    });


});