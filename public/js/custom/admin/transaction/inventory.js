$(document).ready(function(){
    var itemid, firearmid, idTable = 0;
    var table = $('#tblInventory').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
    var tableFirearmInventory = $('#tblFirearmInventory').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    tableFirearmInventory.order([[2, 'asc']]).draw();
    var tableFirearm = $('#tblFirearm').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    //date picker validate
    $('.mydatepicker').change(function() {
        $(this).parsley().validate();
    });
    //expiration firearm license
    $('#inputFirearmExpiration').inputmask("9999-99-99");
    $('#inputFirearmExpiration').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '1d',
        endDate: '+100y',
    });
    $('#inputUpdateFirearmExpiration').inputmask("9999-99-99");
    $('#inputUpdateFirearmExpiration').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '1d',
        endDate: '+100y',
    });

    //display modal for add
    $('#item-list').on('click', '#btnAdd', function() { 
        itemid = $(this).val();

        var itemtype = $(this).closest('tr').find('#itemtype').text();
        if (itemtype.toUpperCase() === "FIREARM" || itemtype.toUpperCase() == "FIREARMS") {
            $('#formFirearm').trigger('reset');
            $('#formFirearm').parsley().reset();
            tableFirearm.clear().draw();

            $('#modalFirearm').modal('show');
        } else {
            $('#formItem').trigger('reset');
            $('#formItem').parsley().reset();

            $('#modalItem').modal('show');
        }
    });

    //adding of firearm to the table
    $('#btnAddFirearm').click(function(e) {
        if ($('#formFirearm').parsley().isValid()) {
            e.preventDefault();

            if (!$('#inputFirearmLicense').inputmask('isComplete')) {
                toastr.error("INVALID FIREARM LICENSE");
                return;
            }

            var check = false;
            tableFirearm.rows().every(function(rowIdx, tableLoop, rowLoop) {
                if (this.cell(rowIdx, 0).data() == $('#inputFirearmLicense').val()) {
                    check = true;
                }
            });
            if (check) {
                toastr.error("FIREARM LICENSE ALREADY EXIST");
                return;
            }

            $('#modalFirearm').loading({
                message: "SAVING..."
            });
            var formData = {
                inputLicense: $('#inputFirearmLicense').val(),
                inputExpiration: $('#inputFirearmExpiration').val(),
            };

            $.ajax({
                type: "GET",
                url: "/json/validate-firearm",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var row = "<tr id=id"+idTable+">" +
                        "<td>"+$('#inputFirearmLicense').val()+"</td>" +
                        "<td>"+$('#inputFirearmExpiration').val()+"</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-danger btn-xs' id='btnRemove' value="+idTable+">Remove</button>" +
                        "</td>" +
                        "</tr>";
                    tableFirearm.row.add($(row)[0]).draw();

                    $('#formFirearm').trigger('reset');
                    $('#formFirearm').parsley().reset();
                    $('#modalFirearm').loading('stop');
                },
                error: function(data) {
                    console.log(data);

                    if (data.responseJSON == "SAME LICENSE") {
                        toastr.error("FIREARM LICENSE ALREADY EXIST");
                    }
                },
            });
        }
    });

    //remove firearm in the table
    $('#firearm-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();

        tableFirearm.row('#id' + $(this).val()).remove().draw(false);
    });

    //save of item
    $('#btnSaveItem').click(function(e) {
        if ($('#formItem').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalItem').loading({
                message: "SAVING..."
            });

            $.ajax({
                type: "POST",
                url: "/admin/transaction/inventory/item/add",
                data: { inputItemID: itemid, inputQuantity: $('#inputQuantity').val(), },
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        data.name,
                        data.itemtype.name,
                        data.qty,
                        data.qtyavailable,
                        "<button class='btn btn-primary btn-xs' id='btnAdd' value="+data.itemid+">Add</button> " +
                        "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.itemid+">Remove</button>",
                    ];
                    table.row('#id' + itemid).data(dt).draw(false);

                    $('#modalItem').modal('hide');
                    $('#modalItem').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                }
            });
        }
    });

    //save of firearm
    $('#btnSaveFirearm').click(function(e) {
        e.preventDefault();

        if (tableFirearm.data().count() != 0) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalFirearm').loading({
                message: "SAVING..."
            });

            var formData = [];
            tableFirearm.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = {
                    inputLicense: this.cell(rowIdx, 0).data(),
                    inputExpiration: this.cell(rowIdx, 1).data(),
                };
                formData.push(data);
            });

            formData = {
                inputItemID: itemid,
                formData: formData,
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/inventory/firearm/add",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        data.name,
                        data.itemtype.name,
                        data.qty,
                        data.qtyavailable,
                        "<button class='btn btn-primary btn-xs' id='btnAdd' value="+data.itemid+">Add</button>",
                    ];
                    table.row('#id' + itemid).data(dt).draw(false);

                    $('#modalFirearm').modal('hide');
                    $('#modalFirearm').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                }
            });
        } else {
            toastr.error("NO FIREARM INPUT");
        }
    });

    //remove item
    $('#item-list').on('click', '#btnRemove', function() {
        $('#formRemoveItem').trigger('reset');
        $('#formRemoveItem').parsley().reset();
        itemid = $(this).val();

        if (table.cell('#id'+itemid, 3).data() != 0) {
            $('#modalRemoveItem').modal('show');
        } else {
            toastr.error("CANNOT REMOVE WHILE ITS NOT AVAILABLE");
        }
    });
    $('#btnSaveRemoveItem').click(function(e) {
        if ($('#formRemoveItem').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            if (Number(table.cell('#id'+itemid, 3).data()) < Number($('#inputRemoveQuantity').val())) {
                toastr.error("INVALID QUANTITY");
                return;
            }

            $('#modalRemoveItem').loading({
                message: "SAVING..."
            });

            $.ajax({
                type: "POST",
                url: "/admin/transaction/inventory/item/remove",
                data: { inputItemID: itemid, inputQuantity: $('#inputRemoveQuantity').val() },
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        table.cell('#id'+itemid, 0).data(),
                        table.cell('#id'+itemid, 1).data(),
                        data.qty,
                        data.qtyavailable,
                        table.cell('#id'+itemid, 4).data()
                    ];
                    table.row('#id'+itemid).data(dt).draw(false);

                    $('#modalRemoveItem').modal('hide');
                    $('#modalRemoveItem').loading('stop');
                    toastr.success("REMOVE SUCCESSFUL");
                }
            });
        }
    });

    $('#firearminventory-list').on('click', '#btnUpdate', function() {
        $('#formUpdateFirearm').trigger('reset');
        $('#formUpdateFirearm').parsley().reset();
        firearmid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/firearm/one",
            data: { inputFirearmID: firearmid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#firearmname').text(data.item.name);
                $('#firearmlicense').text(data.license);
                $('#inputUpdateFirearmExpiration').val(data.expiration);
            }
        });

        $('#modalUpdateFirearm').modal('show');
    });

    $('#btnSaveUpdateFirearm').click(function(e) {
        if ($('#formUpdateFirearm').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $('#modalUpdateFirearm').loading({
                message: "SAVING..."
            });

            var formData = {
                inputFirearmID: firearmid,
                inputExpiration: $('#inputUpdateFirearmExpiration').val()
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/inventory/firearm/update",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    $('#modalUpdateFirearm').modal('hide');
                    $('#modalUpdateFirearm').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                }
            });
        }
    });

    //remove firearm
    $('#firearminventory-list').on('click', '#btnRemove', function() {
        firearmid = $(this).val();

        if (tableFirearmInventory.cell('#id'+firearmid, 3).data() == "AVAILABLE") {
            $('#modalRemoveFirearm').modal('show');
        } else {
            toastr.error("CANNOT REMOVE WHILE ITS NOT AVAILABLE");
        }
    });
    $('#btnRemoveConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#modalRemoveFirearm').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/transaction/inventory/firearm/remove",
            data: { inputFirearmID: firearmid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                tableFirearmInventory.row('#id'+firearmid).remove().draw(false);

                $('#modalRemoveFirearm').modal('hide');
                $('#modalRemoveFirearm').loading('stop');
                toastr.success("REMOVE SUCCESSFUL");
            }
        });
    });



});