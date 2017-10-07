$(document).ready(function() {
    var applicantid;
	var table = $('#tblSecurityGuard').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    //input mask
    $('#sundaytimein').inputmask("99:99:99");
    $('#sundaytimeout').inputmask("99:99:99");
    $('#mondaytimein').inputmask("99:99:99");
    $('#mondaytimeout').inputmask("99:99:99");
    $('#tuesdaytimein').inputmask("99:99:99");
    $('#tuesdaytimeout').inputmask("99:99:99");
    $('#wednesdaytimein').inputmask("99:99:99");
    $('#wednesdaytimeout').inputmask("99:99:99");
    $('#thursdaytimein').inputmask("99:99:99");
    $('#thursdaytimeout').inputmask("99:99:99");
    $('#fridaytimein').inputmask("99:99:99");
    $('#fridaytimeout').inputmask("99:99:99");
    $('#saturdaytimein').inputmask("99:99:99");
    $('#saturdaytimeout').inputmask("99:99:99");

    //jquery time
    $('#sundaytimein').timepicker({'timeFormat':'H:i:s'});
    $('#sundaytimeout').timepicker({'timeFormat':'H:i:s'});
    $('#mondaytimein').timepicker({'timeFormat':'H:i:s'});
    $('#mondaytimeout').timepicker({'timeFormat':'H:i:s'});
    $('#tuesdaytimein').timepicker({'timeFormat':'H:i:s'});
    $('#tuesdaytimeout').timepicker({'timeFormat':'H:i:s'});
    $('#wednesdaytimein').timepicker({'timeFormat':'H:i:s'});
    $('#wednesdaytimeout').timepicker({'timeFormat':'H:i:s'});
    $('#thursdaytimein').timepicker({'timeFormat':'H:i:s'});
    $('#thursdaytimeout').timepicker({'timeFormat':'H:i:s'});
    $('#fridaytimein').timepicker({'timeFormat':'H:i:s'});
    $('#fridaytimeout').timepicker({'timeFormat':'H:i:s'});
    $('#saturdaytimein').timepicker({'timeFormat':'H:i:s'});
    $('#saturdaytimeout').timepicker({'timeFormat':'H:i:s'});

    //manage schedule
    $('#securityguard-list').on('click', '#btnManage', function() {
        applicantid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/applicant/one",
            data: { inputApplicantID: applicantid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#applicantName').text(data.firstname+" "+data.middlename+" "+data.lastname);
            },
        });

        $('#modalSchedule').modal('show');
    });

    //save schedule
    $('#btnSaveSchedule').click(function(e) {
        if ($('#formSchedule').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            //32 min, 40 max; no of hours per week
            //4 min, 5 max; no of days per week
            //8 min, 10 max; no of hours per day
            var check = true, noofdays = 0, noofminutes = 0;
            if ($('#sundaytimein').val() == "" && $('#sundaytimeout').val() == "") {
                
            } else if ($('#sundaytimein').inputmask('isComplete') && $('#sundaytimeout').inputmask('isComplete')) {
                noofdays++;

                var start = moment($('#sundaytimein').val(), "HH:mm:ss");
                var end = moment($('#sundaytimeout').val(), "HH:mm:ss");
                var duration = moment.duration(end.diff(start));

                if (parseInt(duration.asMinutes()) >= 480 && parseInt(duration.asMinutes()) <= 600) {
                    noofminutes += parseInt(duration.asMinutes());
                } else if (parseInt(duration.asMinutes()) < 480) {
                    toastr.error("SUNDAY: INVALID MINIMUM HOURS PER DAY");
                    return;
                } else if (parseInt(duration.asMinutes()) > 600) {
                    toastr.error("SUNDAY: INVALID MAXIMUM HOURS PER DAY");
                    return;
                }
            } else {
                check = false;
            }
            if ($('#mondaytimein').val() == "" && $('#mondaytimeout').val() == "") {
                
            } else if ($('#mondaytimein').inputmask('isComplete') && $('#mondaytimeout').inputmask('isComplete')) {
                noofdays++;

                var start = moment($('#mondaytimein').val(), "HH:mm:ss");
                var end = moment($('#mondaytimeout').val(), "HH:mm:ss");
                var duration = moment.duration(end.diff(start));
                
                if (parseInt(duration.asMinutes()) >= 480 && parseInt(duration.asMinutes()) <= 600) {
                    noofminutes += parseInt(duration.asMinutes());
                } else if (parseInt(duration.asMinutes()) < 480) {
                    toastr.error("MONDAY: INVALID MINIMUM HOURS PER DAY");
                    return;
                } else if (parseInt(duration.asMinutes()) > 600) {
                    toastr.error("MONDAY: INVALID MAXIMUM HOURS PER DAY");
                    return;
                }
            } else {
                check = false;
            }
            if ($('#tuesdaytimein').val() == "" && $('#tuesdaytimeout').val() == "") {
                
            } else if ($('#tuesdaytimein').inputmask('isComplete') && $('#tuesdaytimeout').inputmask('isComplete')) {
                noofdays++;

                var start = moment($('#tuesdaytimein').val(), "HH:mm:ss");
                var end = moment($('#tuesdaytimeout').val(), "HH:mm:ss");
                var duration = moment.duration(end.diff(start));
                
                if (parseInt(duration.asMinutes()) >= 480 && parseInt(duration.asMinutes()) <= 600) {
                    noofminutes += parseInt(duration.asMinutes());
                } else if (parseInt(duration.asMinutes()) < 480) {
                    toastr.error("TUESDAY: INVALID MINIMUM HOURS PER DAY");
                    return;
                } else if (parseInt(duration.asMinutes()) > 600) {
                    toastr.error("TUESDAY: INVALID MAXIMUM HOURS PER DAY");
                    return;
                }
            } else {
                check = false;
            }
            if ($('#wednesdaytimein').val() == "" && $('#wednesdaytimeout').val() == "") {
                
            } else if ($('#wednesdaytimein').inputmask('isComplete') && $('#wednesdaytimeout').inputmask('isComplete')) {
                noofdays++;

                var start = moment($('#wednesdaytimein').val(), "HH:mm:ss");
                var end = moment($('#wednesdaytimeout').val(), "HH:mm:ss");
                var duration = moment.duration(end.diff(start));
                
                if (parseInt(duration.asMinutes()) >= 480 && parseInt(duration.asMinutes()) <= 600) {
                    noofminutes += parseInt(duration.asMinutes());
                } else if (parseInt(duration.asMinutes()) < 480) {
                    toastr.error("WEDNESDAY: INVALID MINIMUM HOURS PER DAY");
                    return;
                } else if (parseInt(duration.asMinutes()) > 600) {
                    toastr.error("WEDNESDAY: INVALID MAXIMUM HOURS PER DAY");
                    return;
                }
            } else {
                check = false;
            }
            if ($('#thursdaytimein').val() == "" && $('#thursdaytimeout').val() == "") {
                
            } else if ($('#thursdaytimein').inputmask('isComplete') && $('#thursdaytimeout').inputmask('isComplete')) {
                noofdays++;

                var start = moment($('#thursdaytimein').val(), "HH:mm:ss");
                var end = moment($('#thursdaytimeout').val(), "HH:mm:ss");
                var duration = moment.duration(end.diff(start));
                
                if (parseInt(duration.asMinutes()) >= 480 && parseInt(duration.asMinutes()) <= 600) {
                    noofminutes += parseInt(duration.asMinutes());
                } else if (parseInt(duration.asMinutes()) < 480) {
                    toastr.error("THURSDAY: INVALID MINIMUM HOURS PER DAY");
                    return;
                } else if (parseInt(duration.asMinutes()) > 600) {
                    toastr.error("THURSDAY: INVALID MAXIMUM HOURS PER DAY");
                    return;
                }
            } else {
                check = false;
            }
            if ($('#fridaytimein').val() == "" && $('#fridaytimeout').val() == "") {
                
            } else if ($('#fridaytimein').inputmask('isComplete') && $('#fridaytimeout').inputmask('isComplete')) {
                noofdays++;

                var start = moment($('#fridaytimein').val(), "HH:mm:ss");
                var end = moment($('#fridaytimeout').val(), "HH:mm:ss");
                var duration = moment.duration(end.diff(start));
                
                if (parseInt(duration.asMinutes()) >= 480 && parseInt(duration.asMinutes()) <= 600) {
                    noofminutes += parseInt(duration.asMinutes());
                } else if (parseInt(duration.asMinutes()) < 480) {
                    toastr.error("FRIDAY: INVALID MINIMUM HOURS PER DAY");
                    return;
                } else if (parseInt(duration.asMinutes()) > 600) {
                    toastr.error("FRIDAY: INVALID MAXIMUM HOURS PER DAY");
                    return;
                }
            } else {
                check = false;
            }
            if ($('#saturdaytimein').val() == "" && $('#saturdaytimeout').val() == "") {
                
            } else if ($('#saturdaytimein').inputmask('isComplete') && $('#saturdaytimeout').inputmask('isComplete')) {
                noofdays++;

                var start = moment($('#saturdaytimein').val(), "HH:mm:ss");
                var end = moment($('#saturdaytimeout').val(), "HH:mm:ss");
                var duration = moment.duration(end.diff(start));
                
                if (parseInt(duration.asMinutes()) >= 480 && parseInt(duration.asMinutes()) <= 600) {
                    noofminutes += parseInt(duration.asMinutes());
                } else if (parseInt(duration.asMinutes()) < 480) {
                    toastr.error("SATURDAY: INVALID MINIMUM HOURS PER DAY");
                    return;
                } else if (parseInt(duration.asMinutes()) > 600) {
                    toastr.error("SATURDAY: INVALID MAXIMUM HOURS PER DAY");
                    return;
                }
            } else {
                check = false;
            }

            if (check) {
                if (noofdays < 4) {
                    toastr.error("MINIMUM DAYS FOR A WEEK")
                    return;
                } else if (noofdays > 5) {
                    toastr.error("MAXIMUM DAYS FOR A WEEK");
                    return;
                } else if (noofminutes < 1920) {
                    console.log(noofminutes);
                    toastr.error("MINIMUM HOURS FOR A WEEK");
                    return;
                } else if (noofminutes > 2400) {
                    toastr.error("MAXIMUM HOURS FOR A WEEK");
                    return;
                }

                $('#modalSchedule').loading({
                    message: "SAVING..."
                });

                var formData = {
                    inputApplicantID: applicantid,
                    inputSundayTimeIN: $('#sundaytimein').val(),
                    inputSundayTimeOUT: $('#sundaytimeout').val(),
                    inputMondayTimeIN: $('#mondaytimein').val(),
                    inputMondayTimeOUT: $('#mondaytimeout').val(),
                    inputTuesdayTimeIN: $('#tuesdaytimein').val(),
                    inputTuesdayTimeOUT: $('#tuesdaytimeout').val(),
                    inputWednesdayTimeIN: $('#wednesdaytimein').val(),
                    inputWednesdayTimeOUT: $('#wednesdaytimeout').val(),
                    inputThursdayTimeIN: $('#thursdaytimein').val(),
                    inputThursdayTimeOUT: $('#thursdaytimeout').val(),
                    inputFridayTimeIN: $('#fridaytimein').val(),
                    inputFridayTimeOUT: $('#fridaytimeout').val(),
                    inputSaturdayTimeIN: $('#saturdaytimein').val(),
                    inputSaturdayTimeOUT: $('#saturdaytimeout').val()
                };

                $.ajax({
                    type: "POST",
                    url: "/client/schedule",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);

                        var dt = [
                            table.cell('#id'+applicantid, 0).data(),
                            table.cell('#id'+applicantid, 1).data(),
                            table.cell('#id'+applicantid, 2).data(),
                            "",
                            "<button class='btn btn-primary btn-xs' id='btnUpdate' id="+applicantid+">Update</button>"
                        ];
                        table.row('#id'+applicantid).data(dt).draw(false);

                        $('#modalSchedule').modal('hide');
                        $('#modalSchedule').loading('stop');
                        toastr.success("SAVE SUCCESSFUL");
                    },
                });
            } else {
                toastr.error("INVALID INPUT TIME");
            }
        }
    });
});