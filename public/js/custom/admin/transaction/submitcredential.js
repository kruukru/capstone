$(document).ready(function() {
    var applicantid, qid;

    var table = $('#tblApplicant').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[1, 'asc']]).draw();
    var tableRequirement = $('#tblRequirement').DataTable({
        "aoColumns": [
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tablePass = $('#tblPass').DataTable({
        "aoColumns": [
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    $('#modalCredential').on('hide.bs.modal', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        $.ajax({
            type: "POST",
            url: "/admin/transaction/submitcredential/applicantrequirement/assess",
            data: { inputApplicantID: applicantid, inputStatus: tableRequirement.data().count(), },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (tableRequirement.data().count() == 0) {
                    table.row('#id' + data.applicantid).remove().draw(false);
                } else {
                    var dt = [
                        table.cell('#id'+applicantid, 0).data(),
                        table.cell('#id'+applicantid, 1).data(),
                        table.cell('#id'+applicantid, 2).data(),
                        table.cell('#id'+applicantid, 3).data(),
                        "FOR FOLLOW UP",
                        table.cell('#id'+applicantid, 5).data(),
                    ];
                    table.row('#id' + data.applicantid).data(dt).draw(false);
                }

                tableRequirement.clear().draw();
                tablePass.clear().draw();
                toastr.success("SAVE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);
            },
        });
    });

    $('#applicant-list').on('click', '#btnAssess', function(e) {
        e.preventDefault();
        applicantid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/applicant/one",
            data: { inputApplicantID: applicantid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.middlename == null) {
                    data.middlename = "";
                }

                $('#applicantName').text(data.lastname+", "+data.firstname+" "+data.middlename);
            },
            error: function(data) {
                console.log(data);
            },
        });

        $.ajax({
            type: "GET",
            url: "/admin/transaction/submitcredential/applicantrequirement",
            data: { inputApplicantID: applicantid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.issubmitted == 0) {
                        var row = "<tr id=out" + value.applicantrequirementid + ">" +
                            "<td>" + value.requirement.name + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnPass' value="+value.applicantrequirementid+">Submit</button> " +
                            "</td>" +
                            "</tr>";
                        tableRequirement.row.add($(row)[0]).draw();
                    } else {
                        var row = "<tr id=in" + value.applicantrequirementid + ">" +
                            "<td>" + value.requirement.name + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+value.applicantrequirementid+">Remove</button> " +
                            "</td>" +
                            "</tr>";
                        tablePass.row.add($(row)[0]).draw();
                    }
                });
            },
            error: function(data) {
                console.log(data);
            },
        });

        $('#modalCredential').modal('show');
    });

    //pass a requirement
    $('#requirement-list').on('click', '#btnPass', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var qid = $(this).val();

        $.ajax({
            type: "POST",
            url: "/admin/transaction/submitcredential/applicantrequirement/pass",
            data: { inputApplicantRequirementID: qid, inputApplicantID: applicantid, },
            dataType: "json",
            success: function(data) {
                console.log(data);
                
                var row = "<tr id=in"+data.applicantrequirementid+">" +
                    "<td>" + data.requirement.name + "</td>" +
                    "<td style='text-align: center;'>" +
                    "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.applicantrequirementid+">Remove</button> " +
                    "</td>" +
                    "</tr>";

                tablePass.row.add($(row)[0]).draw();
                tableRequirement.row('#out' + qid).remove().draw(false);
            },
        });
    });

    //remove a requirement
    $('#pass-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var qid = $(this).val();

        $.ajax({
            type: "POST",
            url: "/admin/transaction/submitcredential/applicantrequirement/remove",
            data: { inputApplicantRequirementID: qid, inputApplicantID: applicantid, },
            dataType: "json",
            success: function(data) {
                console.log(data);
                
                var row = "<tr id=out"+data.applicantrequirementid+">" +
                    "<td>" + data.requirement.name + "</td>" +
                    "<td style='text-align: center;'>" +
                    "<button class='btn btn-primary btn-xs' id='btnPass' value="+data.applicantrequirementid+">Submit</button> " +
                    "</td>" +
                    "</tr>";

                tableRequirement.row.add($(row)[0]).draw();
                tablePass.row("#in" + qid).remove().draw(false);
            },
        });
    });

});