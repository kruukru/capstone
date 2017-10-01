$(document).ready(function() {
    var reportid;
    var table = $('#tblReport').DataTable({
        "aoColumns": [
            null,
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
    var tableInvolveSecurityGuard = $('#tblInvolveSecurityGuard').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    function modalReportClear() {
        $('#formReport').trigger('reset');
        $('#formReport').parsley().reset();
        $('#reporttype').empty();
        tableSecurityGuard.clear();
        tableInvolveSecurityGuard.clear();
    }

    function getSecurityGuard() {
        $.ajax({
            type: "GET",
            url: "/client/report/securityguard",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.middlename == null) {
                        value.middlename = "";
                    }

                    var row = "<tr id=id" + value.applicantid + ">" +
                        "<td>" + value.lastname + ", " + value.firstname + " " + value.middlename + "</td>" +
                        "<td>" + value.qualificationcheck.deploymentsite.sitename + "</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-primary btn-xs' id='btnUpdate' value="+value.applicantid+">Add</button>" +
                        "</td>" +
                        "</tr>";
                    tableSecurityGuard.row.add($(row)[0]).draw();
                });
            },
        });
    }

    $('#btnNewCommendReport').click(function(e) {
        e.preventDefault();
        modalReportClear();

        $.ajax({
            type: "GET",
            url: "/json/commend/all",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    $('#reporttype').append('<option value='+value.commendid+'>'+value.name+'</option>');
                });
            },
        });
        getSecurityGuard();

        $('#modalTitle').text("REPORT TYPE: COMMEND");
        $('#btnSaveReport').val(0);
        $('#modalReport').modal('show');
    });

    $('#btnNewViolationReport').click(function(e) {
        e.preventDefault();
        modalReportClear();

        $.ajax({
            type: "GET",
            url: "/json/violation/all",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    $('#reporttype').append('<option value='+value.violationid+'>'+value.name+'</option>');
                });
            },
        });
        getSecurityGuard();
        
        $('#modalTitle').text("REPORT TYPE: VIOLATION");
        $('#btnSaveReport').val(0);
        $('#modalReport').modal('show');
    });



});