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

        $('#modalSchedule').modal('show');
    });

    //save schedule
    $('#btnSaveSchedule').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
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

                $('#modalSchedule').modal('hide');
                $('#modalSchedule').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });



});