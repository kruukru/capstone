$(document).ready(function() {
    var holidayid;
    var tableHoliday = $('#tblHoliday').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ],
    });
    tableHoliday.order([[3, 'asc']]).draw();

    //checkbox
    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
    });

    //datepicker
    $('.mydatepicker').change(function() {
        $(this).parsley().validate();
    });
    $('#inputHolidayDate').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

    //new holiday
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Holiday");
        $('#formHoliday').trigger('reset');
        $('#formHoliday').parsley().reset();
        $('#inputHolidayYearly').prop('checked', false).iCheck('update');
        $('#modalHoliday').modal('show');
    });

    //view task
    $('#holiday-list').on('click', '#btnUpdate', function() {
        holidayid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/holiday/one",
            data: { inputHolidayID: holidayid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#modalTitle').text("Update Holiday");
                $('#inputHoliday').val(data.name);
                $('#inputHolidayDate').val($.format.date(data.date, "yyyy-MM-dd"));
                if (data.yearly == 1) {
                    $('#inputHolidayYearly').prop('checked', true).iCheck('update');
                } else {
                    $('#inputHolidayYearly').prop('checked', false).iCheck('update');
                }
                $('#btnSave').val("Update");

                $('#modalHoliday').modal('show');
            },
            error: function(data) {
                console.log(data);
            },
        });
    });

    //remove confirm box
    $('#holiday-list').on('click', '#btnRemove', function() {
        holidayid = $(this).val();

        $('#modalHolidayRemove').modal('show');
    });

    //remove a task
    $('#btnRemoveConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/admin/utility/holiday/remove",
            data: { inputHolidayID: holidayid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                tableHoliday.row('#id' + data.holidayid).remove().draw(false);
                $('#modalHolidayRemove').modal('hide');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);
            },
        });
    });

    //save holiday
    //create new task / update existing task
    $('#btnSave').click(function(e) {
        if($('#formHoliday').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            //determine what type of task
            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/utility/holiday/new";
                var formData = {
                    inputHoliday: $('#inputHoliday').val(),
                    inputHolidayDate: $('#inputHolidayDate').val(),
                    inputHolidayYearly: $('#inputHolidayYearly').iCheck('update')[0].checked,
                }
            } else {
                var my_url = "/admin/utility/holiday/update";
                var formData = {
                    inputHolidayID: holidayid,
                    inputHoliday: $('#inputHoliday').val(),
                    inputHolidayDate: $('#inputHolidayDate').val(),
                    inputHolidayYearly: $('#inputHolidayYearly').iCheck('update')[0].checked,
                }
            }

            $.ajax({
                type: "POST",
                url: my_url,
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (data.yearly == 1) {
                        data.date = $.format.date(data.date, "MMMM dd");
                        data.yearly = "YES";
                    } else {
                        data.date = $.format.date(data.date, "MMMM dd, yyyy");
                        data.yearly = "NO";
                    }
                    
                    if ($('#btnSave').val() == "New") {
                        var row = "<tr id=id" + data.holidayid + ">" +
                            "<td>" + data.holidayid + "</td>" +
                            "<td>" + data.name + "</td>" + 
                            "<td>" + data.date + "</td>" +
                            "<td style='text-align: center;'>" + data.yearly + "</td>" +
                            "<td style='text-align: center;'>" +
                                "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.holidayid+">Update</button> " +
                                "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.holidayid+">Remove</button>" +
                            "</td>" +
                            "</tr>";

                        tableHoliday.row.add($(row)[0]).draw();
                    } else {
                        var dt = [
                            data.holidayid,
                            data.name,
                            data.date,
                            data.yearly,
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.holidayid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.holidayid+">Remove</button>",
                        ];

                        tableHoliday.row('#id' + data.holidayid).data(dt).draw(false);
                    }

                    $('#modalHoliday').modal('hide');
                    $('#formHoliday').trigger('reset');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("HOLIDAY ALREADY EXIST");
                    } else if (data.responseJSON == "SAME DATE") {
                        toastr.error("DATE ALREADY EXIST");
                    }
                },
            });
        }
    });

    //save appointment
    $('#btnAppointmentSave').click(function(e) {
        if ($('#formAppointment').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            var formData = {
                inputSunday: $('#inputSunday').iCheck('update')[0].checked,
                inputMonday: $('#inputMonday').iCheck('update')[0].checked,
                inputTuesday: $('#inputTuesday').iCheck('update')[0].checked,
                inputWednesday: $('#inputWednesday').iCheck('update')[0].checked,
                inputThursday: $('#inputThursday').iCheck('update')[0].checked,
                inputFriday: $('#inputFriday').iCheck('update')[0].checked,
                inputSaturday: $('#inputSaturday').iCheck('update')[0].checked,
                inputSlot: $('#inputSlot').val(),
                inputDay: $('#inputDay').val(),
            };

            $.ajax({
                type: "POST",
                url: "/admin/utility/appointment",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);
                },
            });
        }
    });



});