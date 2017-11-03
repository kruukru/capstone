$(document).ready(function() {
    var deploymentsiteid, applicantid, date;
    var table = $('#tblDeploymentSite').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
    var tableSecurityGuard = $('#tblSecurityGuard').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableAttendance = $('#tblAttendance').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    //icheck checkbox
    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
    });

    //input mask
    $('#timein').inputmask("99:99:99");
    $('#timeout').inputmask("99:99:99");

    //jquery time
    $('#timein').timepicker({'timeFormat':'H:i:s'});
    $('#timeout').timepicker({'timeFormat':'H:i:s'});

    //checkbox like radiobutton
    $('#cblate').on('ifChecked', function(event) {
        $('#cbabsent').iCheck('uncheck');
    });
    $('#cbabsent').on('ifChecked', function(event) {
        $('#cblate').iCheck('uncheck');
        $('#divreason').show();
    });
    $('#cbabsent').on('ifUnchecked', function(event) {
        $('#divreason').hide();
        $('#reason').val("");
    });

    //modal time
    function modalTime() {
        $('#cblate').iCheck('uncheck');
        $('#cbabsent').iCheck('uncheck');
        $('#formTime').trigger('reset');
        $('#formTime').parsley().reset();

        var formData = {
            inputDeploymentSiteID: deploymentsiteid,
            inputApplicantID: applicantid,
            inputDate: date
        };

        $.ajax({
            type: "GET",
            url: "/client/attendance/securityguard/one",
            data: formData,
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#timein').val(data.timein);
                $('#timeout').val(data.timeout);
                if (data.status == 1) {
                    $('#cblate').iCheck('check');
                } else if (data.status == 2) {
                    $('#cbabsent').iCheck('check');
                    $('#reason').val(data.reason);
                }
            },
        });

        $('#modalTime').modal('show');
    }

    //modal attendance
    function modalAttendance() {
        tableSecurityGuard.clear().draw();

        $.ajax({
            type: "GET",
            url: "/client/attendance/securityguard",
            data: { inputDeploymentSiteID: deploymentsiteid, inputDate: date },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data.applicant, function(index, value) {
                    if (data.middlename == "") {
                        data.middlename = "";
                    }

                    var schedule = "";
                    if (data.dayofweek == 0) {
                        schedule = value.schedule.sundayin+" - "+value.schedule.sundayout;
                    } else if (data.dayofweek == 1) {
                        schedule = value.schedule.mondayin+" - "+value.schedule.mondayout;
                    } else if (data.dayofweek == 2) {
                        schedule = value.schedule.tuesdayin+" - "+value.schedule.tuesdayout;
                    } else if (data.dayofweek == 3) {
                        schedule = value.schedule.wednesdayin+" - "+value.schedule.wednesdayout;
                    } else if (data.dayofweek == 4) {
                        schedule = value.schedule.thursdayin+" - "+value.schedule.thursdayout;
                    } else if (data.dayofweek == 5) {
                        schedule = value.schedule.fridayin+" - "+value.schedule.fridayout;
                    } else if (data.dayofweek == 6) {
                        schedule = value.schedule.saturdayin+" - "+value.schedule.saturdayout;
                    }

                    var row = "<tr id=id" + value.applicantid + ">" +
                        "<td>" + value.firstname + " " + value.middlename + " " + value.lastname + "</td>" +
                        "<td style='text-align: center;'>" + schedule + "</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-warning btn-xs' id='btnAssess' value="+value.applicantid+">Assess</button>" +
                        "</td>" +
                        "</tr>";
                    tableSecurityGuard.row.add($(row)[0]).draw();
                });
            },
        });

        modalAttendanceHistory();

        $('#modalAttendance').modal('show');
    }

    //attendance history
    function modalAttendanceHistory() {
        tableAttendance.clear().draw();

        var formData = {
            inputDeploymentSiteID: deploymentsiteid,
            inputApplicantID: applicantid,
            inputDate: date
        };

        $.ajax({
            type: "GET",
            url: "/client/attendance/history",
            data: formData,
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.applicant.middlename == null) {
                        value.applicant.middlename = "";
                    }
                    if (value.timein == null) {
                        value.timein = "";
                    }
                    if (value.timeout == null) {
                        value.timeout = "";
                    }
                    if (value.status == 0) {
                        value.status = "PRESENT";
                    } else if (value.status == 1) {
                        value.status = "LATE";
                    } else if (value.status == 2) {
                        value.status = "ABSENT";
                    }

                    var row = "<tr id=id" + value.applicant.applicantid + ">" +
                        "<td>" + value.applicant.firstname + " " + value.applicant.middlename + " " + value.applicant.lastname + "</td>" +
                        "<td style='text-align: center;'>" + value.timein + "</td>" +
                        "<td style='text-align: center;'>" + value.timeout + "</td>" +
                        "<td style='text-align: center;'>" + value.status + "</td>" +
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnUpdate' value="+value.applicant.applicantid+">Update</button>" +
                        "</td>" +
                        "</tr>";
                    tableAttendance.row.add($(row)[0]).draw();
                });
            },
        });
    }

    //show calendar div
    $('#deploymentsite-list').on('click', '#btnAttendance', function() {
        deploymentsiteid = $(this).val();
        $('#divCalendar').show();
        $('#calendar').fullCalendar('destroy');

        $('#calendar').fullCalendar({
            eventSources: [{
                type: "GET",
                url: "/client/attendance/calendar",
                data: { inputDeploymentSiteID: deploymentsiteid },
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    $('#deploymentsitename').text(table.cell('#id'+deploymentsiteid, 0).data()+" - "+table.cell('#id'+deploymentsiteid, 1).data());
                },
                error: function(data) {
                    console.log(data);

                    if (data.responseJSON == "NO SCHEDULE") {
                        toastr.error("NO SECURITY GUARD SCHEDULE");
                    }
                    $('#divCalendar').hide();
                },
            }],

            eventClick: function(calEvent, jsEvent, view) {
                date = calEvent.date;

                if (calEvent.status == 2) {
                    $('#lbldate').text($.format.date(calEvent.start._d, "ddd, MMMM d, yyyy"));

                    modalAttendance();
                } else {
                    $('#lbldate').text($.format.date(calEvent.start._d, "ddd, MMMM d, yyyy"));

                    modalAttendance();
                }
            },
            eventMouseover: function(event, jsEvent, view) {
                $(this).css({"background-color":"purple"});
            },
            eventMouseout: function(event, jsEvent, view) {
                if (event.status == 0) {
                    $(this).css({"background-color":"green"});
                } else if (event.status == 1) {
                    $(this).css({"background-color":"orange"});
                } else if (event.status == 2) {
                    $(this).css({"background-color":"red"});
                } else {
                    $(this).css({"background-color":"rgb(58, 135, 173)"});
                }
            },
            eventRender: function(event, element) {
                if (event.status == 0) {
                    element.css({"background-color":"green"});
                } else if (event.status == 1) {
                    element.css({"background-color":"orange"});
                } else if (event.status == 2) {
                    element.css({"background-color":"red"});
                }
                element.find('.fc-content').css({"text-align":"center", "margin":"10px"});
                element.find('.fc-title').css({"white-space":"normal"});
            },
        });
    });

    //assess attendance
    $('#securityguard-list').on('click', '#btnAssess', function(e) {
        applicantid = $(this).val();

        modalTime();
    });

    //update attendance
    $('#attendance-list').on('click', '#btnUpdate', function() {
        applicantid = $(this).val();

        modalTime();
    });

    //save time
    $('#btnSaveTime').click(function(e) {
        if ($('#formTime').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $('#modalTime').loading({
                message: "SAVING..."
            });

            var formData = {
                inputDeploymentSiteID: deploymentsiteid,
                inputApplicantID: applicantid,
                inputDate: date,
                inputTimeIN: $('#timein').val(),
                inputTimeOUT: $('#timeout').val(),
                inputReason: $('#reason').val(),
                inputStatus: $('input[name="cbstatus"]:checked').val()
            };

            $.ajax({
                type: "POST",
                url: "/client/attendance/securityguard",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    tableSecurityGuard.row('#id'+applicantid).remove().draw(false);

                    $('#calendar').fullCalendar('refetchEvents');
                    modalAttendanceHistory();

                    $('#modalTime').modal('hide');
                    $('#modalTime').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
            });
        }
    });



});