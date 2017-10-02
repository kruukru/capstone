$(document).ready(function() {
    var reportid, reporttype;
    var table = $('#tblReport').DataTable({
        "aoColumns": [
            null,
            null,
            null,
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

    //report clear
    function modalReportClear() {
        $('#formReport').trigger('reset');
        $('#formReport').parsley().reset();
        $('#reporttype').empty();
        $('#reporttype').prop('disabled', false);
        $('#divSecurityGuard').show();
        $('#divInvolveSecurityGuard').show();
        tableSecurityGuard.clear().draw();
        tableInvolveSecurityGuard.clear().draw();
    }

    //get security guard
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
                        "<button class='btn btn-primary btn-xs' id='btnAdd' value="+value.applicantid+">Add</button>" +
                        "</td>" +
                        "</tr>";
                    tableSecurityGuard.row.add($(row)[0]).draw();
                });
            },
        });
    }

    //add security guard to involve
    $('#securityguard-list').on('click', '#btnAdd', function(e) {
        e.preventDefault();

        var row = "<tr id=id" + $(this).val() + ">" +
            "<td>" + tableSecurityGuard.cell('#id'+$(this).val(), 0).data() + "</td>" +
            "<td>" + tableSecurityGuard.cell('#id'+$(this).val(), 1).data() + "</td>" +
            "<td style='text-align: center;'>" +
            "<button class='btn btn-warning btn-xs' id='btnRemove' value="+$(this).val()+">Remove</button>" +
            "</td>" +
            "</tr>";
        tableSecurityGuard.row('#id'+$(this).val()).remove().draw(false);
        tableInvolveSecurityGuard.row.add($(row)[0]).draw();
    });

    //remove security guard from involve
    $('#involvesecurityguard-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();

        var row = "<tr id=id" + $(this).val() + ">" +
            "<td>" + tableInvolveSecurityGuard.cell('#id'+$(this).val(), 0).data() + "</td>" +
            "<td>" + tableInvolveSecurityGuard.cell('#id'+$(this).val(), 1).data() + "</td>" +
            "<td style='text-align: center;'>" +
            "<button class='btn btn-primary btn-xs' id='btnAdd' value="+$(this).val()+">Add</button>" +
            "</td>" +
            "</tr>";
        tableInvolveSecurityGuard.row('#id'+$(this).val()).remove().draw(false);
        tableSecurityGuard.row.add($(row)[0]).draw();
    });

    //remove report
    $('#report-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();
        reportid = $(this).val();

        $('#modalRemoveReport').modal('show');
    });

    //remove confirm remove
    $('#btnRemoveConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalRemoveReport').loading({
            message: "REMOVING...",
        });

        $.ajax({
            type: "POST",
            url: "/client/report/remove",
            data: { inputReportID: reportid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id'+reportid).remove().draw(false);

                $('#modalRemoveReport').modal('hide');
                $('#modalRemoveReport').loading('stop');
                toastr.success("REMOVE SUCCESSFUL");
            }
        });
    });

    //new commend
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

        reporttype = 0;
        $('#modalTitle').text("REPORT TYPE: COMMEND");
        $('#btnSaveReport').val(0);
        $('#modalReport').modal('show');
    });

    //new violation
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
        
        reporttype = 1;
        $('#modalTitle').text("REPORT TYPE: VIOLATION");
        $('#btnSaveReport').val(0);
        $('#modalReport').modal('show');
    });

    //update report
    $('#report-list').on('click', '#btnUpdate', function(e){
        e.preventDefault();
        $('#formReport').trigger('reset');
        $('#formReport').parsley().reset();
        $('#reporttype').empty();
        $('#reporttype').prop('disabled', true);
        $('#divSecurityGuard').hide();
        $('#divInvolveSecurityGuard').hide();
        $('#btnSaveReport').val(1);
        reportid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/report/one",
            data: { inputReportID: reportid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var reporttxt = data.violationid == null ? data.commend.name : data.violation.name;

                $('#reporttype').append('<option>'+ reporttxt +'</option>');
                $('#placehappen').val(data.placehappen);
                $('#subject').val(data.subject);
                $('#detail').val(data.detail);
            }
        });

        $('#modalReport').modal('show');
    });

    //save report
    $('#btnSaveReport').click(function(e) {
        if ($('#formReport').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            if (tableInvolveSecurityGuard.rows().count() == 0 && $('#btnSaveReport').val() == 0) {
                toastr.error("NO PERSONNEL");
                return;
            }

            $('#modalReport').loading({
                message: "SAVING..."
            });

            var formData = [];
            tableInvolveSecurityGuard.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = {
                    inputApplicantID: this.cell(rowIdx, 2).nodes().to$().find('#btnRemove').val()
                };
                formData.push(data);
            });

            if ($('#btnSaveReport').val() == 0) {
                var my_url = "/client/report/new";
                var formData = {
                    inputReportStatus: reporttype,
                    inputReportType: $('#reporttype').val(),
                    inputPlaceHappen: $('#placehappen').val(),
                    inputSubject: $('#subject').val(),
                    inputDetail: $('#detail').val(),
                    formData: formData
                }
            } else {
                var my_url = "/client/report/update";
                var formData = {
                    inputReportID: reportid,
                    inputPlaceHappen: $('#placehappen').val(),
                    inputSubject: $('#subject').val(),
                    inputDetail: $('#detail').val()
                }
            }

            $.ajax({
                type: "POST",
                url: my_url,
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if ($('#btnSaveReport').val() == 0) {
                        var personinvolve = "";
                        $.each(data.personinvolve, function(index, value) {
                            if (value.applicant.middlename == null) {
                                value.applicant.middlename = "";
                            }
                            personinvolve += "<li>" + value.applicant.firstname + " " + value.applicant.middlename + " " + value.applicant.lastname + "</li>";
                        });

                        var row = "<tr id=id" + data.reportid + ">" +
                            "<td>" + $('#reporttype option:selected').text() + "</td>" +
                            "<td>" + data.subject + "</td>" +
                            "<td>" + data.placehappen + "</td>" +
                            "<td>" + data.detail + "</td>" +
                            "<td><ul>" + personinvolve + "</ul></td>" +
                            "<td>Me</td>" +
                            "<td>Right Now</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.reportid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.reportid+">Remove</button>" +
                            "</td>" +
                            "</tr>";
                        table.row.add($(row)[0]).draw();
                    } else {
                        var dt = [
                            table.cell('#id'+reportid, 0).data(),
                            data.subject,
                            data.placehappen,
                            data.detail,
                            table.cell('#id'+reportid, 4).data(),
                            table.cell('#id'+reportid, 5).data(),
                            table.cell('#id'+reportid, 6).data(),
                            table.cell('#id'+reportid, 7).data()
                        ];
                        table.row('#id'+reportid).data(dt).draw(false);
                    }

                    $('#modalReport').modal('hide');
                    $('#modalReport').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                }
            });
        }
    });



});