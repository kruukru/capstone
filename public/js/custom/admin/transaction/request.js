$(document).ready(function() {
    var requestid;
    var table = $('#tblRequest').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
    var tableRequestItem = $('#tblRequestItem').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    var tableInventory = $('#tblInventory').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableDeployItem = $('#tblDeployItem').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    $('#request-list').on('click', '#btnDecline', function(e) {
        e.preventDefault();
        requestid = $(this).val();

        $('#modalDeclineConfirmation').modal('show');
    });

    $('#btnDeclineConfirm').on('click', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/admin/transaction/request/decline",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + requestid).remove().draw(false);

                $('#modalDeclineConfirmation').modal('hide');
                toastr.success("REMOVE SUCCESSFUL");
            },
        });
    });

    $('#request-list').on('click', '#btnDeploy', function(e) {
        e.preventDefault();
        requestid = $(this).val();
        var requesttype = $(this).closest('tr').find('#requesttype').text();

        if (requesttype == "ITEM") {
            $('#modalItem').modal('show');
        }
    });



});