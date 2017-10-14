$(document).ready(function() {
    var startDate = moment().add(5, 'days');
    var endDate = moment().add(7, 'days');

    $('#daterange').daterangepicker({
        locale: {
            format: 'MMMM DD, YYYY'
        },
        minDate: moment($('#contractstartdate').val()),
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

            var formData = {
                inputStartDate: startDate.format('YYYY-MM-DD'),
                inputEndDate: endDate.format('YYYY-MM-DD'),
                inputReason: $('#reason').val()
            };

            $.ajax({
                type: "POST",
                url: "/applicant/schedule/requestleave",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    alert("SAVE SUCCESSFUL");
                    window.location.href = "/applicant/schedule";
                },
            });
        }
    });

    //cancel request leave
    $('#btnCancelRequestLeave').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/applicant/schedule/requestleave/cancel",
            dataType: "json",
            success: function(data) {
                console.log(data);

                alert("CANCEL SUCCESSFUL");
                window.location.href = "/applicant/schedule";
            },
        });
    })
});