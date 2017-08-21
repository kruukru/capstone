$(document).ready(function() {
    var deploymentsiteid;
    var table = $('#tblDeploymentSite').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
    var tableSecurityGuard = $('#tblSecurityGuard').DataTable({
        "aoColumns": [
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    $('#modalAttendance').on('hide.bs.modal', function() {
        tableSecurityGuard.clear().draw();
    });

    $('#securityguard-list').on('click', '.btn', function() {
        $(this).parents('tr').find('.btn').addClass('btn-default');
        $(this).parents('tr').find('.btn').removeClass('btn-primary');
        $(this).addClass('btn-primary');
        $(this).removeClass('btn-default');
    });

    $('#deploymentsite-list').on('click', '#btnAttendance', function(e) {
        e.preventDefault();
        deploymentsiteid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/manager/attendance/securityguard",
            data: { inputDeploymentSiteID: deploymentsiteid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr id=id" + value.applicantid + ">" +
                        "<td>" + value.lastname + ", " + value.firstname + " " + value.middlename + "</td>" +
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-default btn-xs' id='Present' value="+value.applicantid+">Present</button> " +
                            "<button class='btn btn-default btn-xs' id='Late' value="+value.applicantid+">Late</button> " +
                            "<button class='btn btn-default btn-xs' id='Absent' value="+value.applicantid+">Absent</button>" +
                        "</td>" +
                        "</tr>";
                    tableSecurityGuard.row.add($(row)[0]).draw();
                });
            },
        });

        $('#modalAttendance').modal('show');
    });

    $('#btnSave').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var check = true;
        $('#tblSecurityGuard > tbody > tr').each(function() {
            if (!$(this).find('.btn').hasClass('btn-primary')) {
                check = false;
            }
        });

        if (check) {
            var formData = [];
            $('#tblSecurityGuard > tbody > tr').each(function() {
                var data = {
                    inputApplicantID: $(this).find('.btn-primary').val(),
                    inputStatus: $(this).find('.btn-primary').attr('id'),
                };
                formData.push(data);
            });

            formData = {
                inputDeploymentSiteID: deploymentsiteid,
                formData: formData,
            };

            $.ajax({
                type: "POST",
                url: "/manager/attendance/securityguard",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    table.row('#id' + deploymentsiteid).remove().draw(false);
                    
                    $('#modalAttendance').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
            });
        } else {
            toastr.error("PICK AN ACTION IN EVERY SECURITY GUARD");
        }
    });



});