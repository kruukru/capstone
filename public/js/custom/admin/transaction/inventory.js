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
    $('#inputFirearmExpiration').inputmask("9999-99-99");
    $('#inputFirearmExpiration').datepicker({
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
                        "<button class='btn btn-success btn-xs' id='btnAdd' value="+data.itemid+">Add</button>",
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
                        "<button class='btn btn-success btn-xs' id='btnAdd' value="+data.itemid+">Add</button>",
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



});