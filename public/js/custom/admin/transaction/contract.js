$(document).ready(function() {
    var contractid;
    var table = $('#tblContract').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[2, 'asc']]).draw();

    //renew contract
    $('#contract-list').on('click', '#btnExtend', function() {
        $('#formExtendContract').trigger('reset');
        $('#formExtendContract').parsley().reset();
        contractid = $(this).val();

        $('#modalExtendContract').modal('show');
    });
    $('#btnSaveExtendContract').click(function(e) {
        if ($('#formExtendContract').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $('#modalExtendContract').loading({
                message: "SAVING..."
            });

            var formData = {
                inputContractID: contractid,
                inputLength: $('#inputLength').val(),
                inputLengthType: $('#lengthtype').val()
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/contract/extend",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        table.cell('#id'+contractid, 0).data(),
                        table.cell('#id'+contractid, 1).data(),
                        table.cell('#id'+contractid, 2).data(),
                        table.cell('#id'+contractid, 3).data(),
                        table.cell('#id'+contractid, 4).data(),
                        $.format.date(data.expiration, "MMM. dd, yyyy"),
                        table.cell('#id'+contractid, 6).data(),
                        table.cell('#id'+contractid, 7).data(),
                    ];
                    table.row('#id'+contractid).data(dt).draw(false);

                    $('#modalExtendContract').modal('hide');
                    $('#modalExtendContract').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
            });
        }
    });

    //terminate contract
    $('#contract-list').on('click', '#btnTerminate', function() {
        contractid = $(this).val();

        $('#modalTerminateContract').modal('show');
    });
    $('#btnConfirmTerminate').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#modalTerminateContract').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/transaction/contract/terminate",
            data: { inputContractID: contractid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var dt = [
                    table.cell('#id'+contractid, 0).data(),
                    table.cell('#id'+contractid, 1).data(),
                    table.cell('#id'+contractid, 2).data(),
                    table.cell('#id'+contractid, 3).data(),
                    table.cell('#id'+contractid, 4).data(),
                    table.cell('#id'+contractid, 5).data(),
                    "TERMINATED",
                    "",
                ];
                table.row('#id'+contractid).data(dt).draw(false);

                $('#modalTerminateContract').modal('hide');
                $('#modalTerminateContract').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });




});