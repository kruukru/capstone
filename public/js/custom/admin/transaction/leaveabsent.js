$(document).ready(function() {
    var leaverequestid, applicantrelieverid, attendanceid;
    var tableLeave = $('#tblLeave').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    tableLeave.order([[1, 'asc']]).draw();
    var tableAbsent = $('#tblAbsent').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    tableAbsent.order([[3, 'desc']]).draw();
    var tableLeaveReliever = $('#tblLeaveReliever').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableAbsentReliever = $('#tblAbsentReliever').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    //show / hide div
    $('#btnApproveLeave').click(function(e) {
        e.preventDefault();

        if ($('#divreliever').is(":visible")) {
            $('#divreliever').hide();
        } else {
            $('#divreliever').show();
        }
    });

    //assess leave
    $('#leave-list').on('click', '#btnAssess', function() {
        tableLeaveReliever.clear().draw();
        leaverequestid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/leaverequest/one",
            data: { inputLeaveRequestID: leaverequestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.applicant.middlename == null) {
                    data.applicant.middlename = "";
                }

                $('#leavepictureview').attr('src', '/applicant/'+data.applicant.picture);
                $('#securityguardname').text(data.applicant.firstname + " " + data.applicant.middlename + " " + data.applicant.lastname);
                $('#daterange').text($.format.date(data.start, "MMMM dd, yyyy") + " - " + $.format.date(data.end, "MMMM dd, yyyy"));
                $('#reason').text(data.reason);
            },
        });

        $.ajax({
            type: "GET",
            url: "/admin/transaction/leaveabsent/reliever",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.middlename == "") {
                        value.middlename = "";
                    }

                    var row = "<tr id=id" + value.applicantid + ">" +
                        "<td>" + value.name + "</td>" +
                        "<td style='text-align: center;'>" + value.vacant + "</td>" + 
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnLeaveReliever' value="+value.applicantid+">Reliever</button>" +
                        "</td>" +
                        "</tr>";
                    tableLeaveReliever.row.add($(row)[0]).draw();
                });

                tableLeaveReliever.order([[1, 'desc']]).draw();
            },
        });

        $('#modalAssessLeave').modal('show');
    });
    //pick a reliever
    $('#leavereliever-list').on('click', '#btnLeaveReliever', function() {
        applicantrelieverid = $(this).val();

        $('#modalLeaveRelieverConfirmation').modal('show');
    });
    //confirm reliever
    $('#btnLeaveRelieverConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#modalLeaveRelieverConfirmation').loading({
            message: "SAVING..."
        });

        var formData = {
            inputLeaveRequestID: leaverequestid,
            inputApplicantRelieverID: applicantrelieverid
        };

        $.ajax({
            type: "POST",
            url: "/admin/transaction/leave/reliever",
            data: formData,
            dataType: "json",
            success: function(data) {
                console.log(data);

                var dt = [
                    tableLeave.cell('#id'+leaverequestid, 0).data(),
                    tableLeave.cell('#id'+leaverequestid, 1).data(),
                    tableLeave.cell('#id'+leaverequestid, 2).data(),
                    tableLeave.cell('#id'+leaverequestid, 3).data(),
                    "APPROVED",
                    "",
                ];
                tableLeave.row('#id'+leaverequestid).data(dt).draw(false);

                $('#modalLeaveRelieverConfirmation').modal('hide');
                $('#modalLeaveRelieverConfirmation').loading('stop');
                $('#modalAssessLeave').modal('hide');
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });

    //decline leave
    $('#btnDeclineLeave').click(function() {
        $leaverequest = $(this).val();

        $('#modalDeclineLeave').modal('show');
    });
    $('#btnDeclineLeaveConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#modalDeclineLeave').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/transaction/leave/decline",
            data: { inputLeaveRequestID: leaverequestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                tableLeave.row('#id'+leaverequestid).remove().draw(false);

                $('#modalDeclineLeave').modal('hide');
                $('#modalDeclineLeave').loading('stop');
                $('#modalAssessLeave').modal('hide');
                toastr.success("SAVE SUCCESSFUL");
            },
        });        
    });

    //assess absent
    $('#absent-list').on('click', '#btnAssess', function() {
        tableAbsentReliever.clear().draw();
        attendanceid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/attendance/one",
            data: { inputAttendanceID: attendanceid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.applicant.middlename == null) {
                    data.applicant.middlename = "";
                }

                $('#absentpictureview').attr('src', '/applicant/'+data.applicant.picture);
                $('#securityguardname').text(data.applicant.firstname + " " + data.applicant.middlename + " " + data.applicant.lastname);
            },
        });

        $.ajax({
            type: "GET",
            url: "/admin/transaction/leaveabsent/reliever",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.middlename == "") {
                        value.middlename = "";
                    }

                    var row = "<tr id=id" + value.applicantid + ">" +
                        "<td>" + value.name + "</td>" +
                        "<td style='text-align: center;'>" + value.vacant + "</td>" + 
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnAbsentReliever' value="+value.applicantid+">Reliever</button>" +
                        "</td>" +
                        "</tr>";
                    tableAbsentReliever.row.add($(row)[0]).draw();
                });

                tableAbsentReliever.order([[1, 'desc']]).draw();
            },
        });

        $('#modalAssessAbsent').modal('show');
    });
    //pick a reliever
    $('#absentreliever-list').on('click', '#btnAbsentReliever', function() {
        applicantrelieverid = $(this).val();

        $('#modalAbsentRelieverConfirmation').modal('show');
    });
    //confirm a reliever
    $('#btnAbsentRelieverConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#modalAbsentRelieverConfirmation').loading({
            message: "SAVING..."
        });

        var formData = {
            inputAttendanceID: attendanceid,
            inputApplicantRelieverID: applicantrelieverid
        };

        $.ajax({
            type: "POST",
            url: "/admin/transaction/absent/reliever",
            data: formData,
            dataType: "json",
            success: function(data) {
                console.log(data);

                tableAbsent.row('#id'+attendanceid).remove().draw(false);

                $('#modalAbsentRelieverConfirmation').modal('hide');
                $('#modalAbsentRelieverConfirmation').loading('stop');
                $('#modalAssessAbsent').modal('hide');
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });



});