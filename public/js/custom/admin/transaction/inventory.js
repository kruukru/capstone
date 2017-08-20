$(document).ready(function(){
    var itemid, idTable = 0;
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
    $('#inputFirearmExpiration').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '1d',
        endDate: '+100y',
    });

    //reset the modal when hide
    $('#modalItem').on('hide.bs.modal', function() {
        $('#formItem').trigger('reset');
        $('#formItem').parsley().reset();
    });

    //display modal for add
    $('#item-list').on('click', '#btnAdd', function() { 
        itemid = $(this).val();

        var itemtype = $(this).closest('tr').find('#itemtype').text();
        if (itemtype.toUpperCase() === "FIREARM" || itemtype.toUpperCase() == "FIREARMS") {
            $('#modalFirearm').modal('hide');
            $('#formFirearm').trigger('reset');
            $('#formFirearm').parsley().reset();
            tableFirearm.clear().draw();
            $('#modalFirearm').modal('show');
        } else {
            $('#modalItem').modal('show');
        }
    });

    //adding of firearm to the table
    $('#btnFirearmAdd').click(function(e) {
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

            var formData = {
                inputLicense: $('#inputFirearmLicense').val(),
                inputExpiration: $('#inputFirearmExpiration').val(),
            };

            $.ajax({
                type: "GET",
                url: "/admin/transaction/inventory/firearm-validate",
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
    $('#btnItemSave').click(function(e) {
        if ($('#formItem').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/admin/transaction/inventory/additem",
                data: { inputItemID: itemid, inputQuantity: $('#inputQuantity').val(), },
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        data.name,
                        data.item_type.name,
                        data.qty,
                        data.qtyavailable,
                        "<button class='btn btn-success btn-xs' id='btnAdd' value="+data.itemid+">Add</button>",
                    ];
                    table.row('#id' + itemid).data(dt).draw(false);

                    $('#modalItem').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);
                },
            });
        }
    });

    //save of firearm
    $('#btnFirearmSave').click(function(e) {
        e.preventDefault();
        if (tableFirearm.data().count() != 0) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
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
                url: "/admin/transaction/inventory/addfirearm",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        data.name,
                        data.item_type.name,
                        data.qty,
                        data.qtyavailable,
                        "<button class='btn btn-success btn-xs' id='btnAdd' value="+data.itemid+">Add</button>",
                    ];
                    table.row('#id' + itemid).data(dt).draw(false);

                    $('#modalFirearm').modal('hide');
                    $('#formFirearm').trigger('reset');
                    $('#formFirearm').parsley().reset();
                    tableFirearm.clear().draw();
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);
                },
            });
        } else {
            toastr.error("NO FIREARM INPUT");
        }
    });



});