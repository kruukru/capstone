$(document).ready(function() {
    var leaverequestid;
    var startDate = moment().add(5, 'days');
    var endDate = moment().add(7, 'days');
    var table = $('#tblRequestLeave').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'desc']]).draw();
    
    var table = $('#tblRequirement').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'desc']]).draw();

    //date range picker
    $('#daterange').daterangepicker({
        locale: {
            format: 'MMMM DD, YYYY'
        },
        minDate: moment().add(3, 'days'),
        maxDate: moment($('#contractenddate').val()),
        startDate: startDate,
        endDate: endDate,
    }, function(start, end) {
        startDate = start; endDate = end;
    });

    //request leave
    $('#btnNewLeave').click(function() {
        $('#formRequestLeave').trigger('reset');
        $('#formRequestLeave').parsley().reset();

        $('#modalRequestLeave').modal('show');
    });
    //save request leave
    $('#btnSaveRequestLeave').click(function(e) {
        if ($('#formRequestLeave').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $('#modalRequestLeave').loading({
                message: "SAVING..."
            });

            var formData = {
                inputStartDate: startDate.format('YYYY-MM-DD'),
                inputEndDate: endDate.format('YYYY-MM-DD'),
                inputReason: $('#reason').val()
            };

            $.ajax({
                type: "POST",
                url: "/applicant/leave/requestleave",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var row = "<tr id=id" + data.leaverequestid + ">" +
                        "<td>Right Now</td>" +
                        "<td>" + $.format.date(data.start, "MMMM dd, yyyy") + " - " + $.format.date(data.end, "MMMM dd, yyyy") + "</td>" +
                        "<td>" + data.reason + "</td>" +
                        "<td style='text-align: center'>PENDING</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-danger btn-xs' id='btnCancel' value="+data.leaverequestid+">Cancel</button>" +
                        "</td>" +
                        "</tr>";
                    table.row.add($(row)[0]).draw();

                    $('#modalRequestLeave').modal('hide');
                    $('#modalRequestLeave').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalRequestLeave').loading('stop');
                    if (data.responseJSON == "INVALID DATE") {
                        toastr.error("DATE ALREADY EXIST");
                    }
                }
            });
        }
    });

    //cancel request leave
    $('#leave-list').on('click', '#btnCancel', function() {
        leaverequestid = $(this).val();

        $('#modalCancelRequest').modal('show');
    });
    $('#btnConfirmCancel').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#modalCancelRequest').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/applicant/leave/cancel",
            data: { inputLeaveRequestID: leaverequestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id'+leaverequestid).remove().draw(false);

                $('#modalCancelRequest').modal('hide');
                $('#modalCancelRequest').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });



});