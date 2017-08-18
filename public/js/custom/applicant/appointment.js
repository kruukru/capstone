$(document).ready(function() {
	var appointmentdateid;

    //show and hide tab event
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        var $target = $(e.target);

        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $('#calendar').fullCalendar({
        eventSources: [{
            type: "GET",
            url: "/applicant/appointmentdate",
            success: function(data) {
                console.log(data);
            },
            error: function(data) {
                console.log(data);
            },
        }],

        eventClick: function(calEvent, jsEvent, view) {
            appointmentdateid = calEvent.id;

            if (calEvent.holiday != 1) {
                $('.modal-body').empty();
                $('.modal-body').append("Are you sure you want to appoint on this date? ("+$.format.date(calEvent.start._d, "ddd, MMMM d, yyyy")+")");
                $('#modalAppointment').modal('show');
            }
        },
        eventMouseover: function(event, jsEvent, view) {
            $(this).css({"background-color":"purple"});
        },
        eventMouseout: function(event, jsEvent, view) {
            if (event.holiday == 1) {
                $(this).css({"background-color":"red"});
            } else {
                $(this).css({"background-color":"rgb(58, 135, 173)"});
            }
        },
        eventRender: function(event, element) {
            if (event.holiday == 1) {
                element.css({"background-color":"red"});
            }
            element.find('.fc-content').css({"text-align":"center", "margin":"10px"});
            element.find('.fc-title').css({"white-space":"normal"});
        },
    });

    $('#appointment-list').on('click', '#btnCancel', function() {
        appointmentdateid = $(this).val();

        $('#modalAppointmentRemove').modal('show');
    });

    $('#btnConfirmAppointment').click(function(e) {
    	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        e.preventDefault();

    	$.ajax({
            type: "POST",
            url: "/applicant/appointment/set",
            data: { inputAppointmentDateID: appointmentdateid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#modalAppointment').modal('hide');
                alert("APPOINT SUCCESSFUL");
            	window.location.href = "/applicant/appointment";
            },
            error: function(data) {
                console.log(data);
            },
        });
    });

    $('#btnConfirmAppointmentRemove').click(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/applicant/appointment/remove",
            data: { inputAppointmentDateID: appointmentdateid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#modalAppointmentRemove').modal('hide');
                alert("REMOVE SUCCESSFUL");
                window.location.href = "/applicant/appointment";
            },
            error: function(data) {
                console.log(data);
            },
        });
    })



});