$(document).ready(function() {
    var applicantid, adminid, idTable = 0;
    var table = $('#tblAssessInterview').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[1, 'asc']]).draw();
    var tableTestAssessment = $('#tblTestAssessment').DataTable({
        "aoColumns": [
            null,
            null,
        ]
    });
    var tableAssessment = $('#tblAssessment').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    })

    //reset modal when hide
    $('#modalAssess').on('hide.bs.modal', function() {
        $('#formAssessment').trigger('reset');
        $('#formAssessment').parsley().reset();
        $('#assessmenttopic').empty();
        tableTestAssessment.clear().draw();
        tableAssessment.clear().draw();
    });

    //add topic
    $('#btnAdd').click(function(e) {
        if ($('#formAssessment').parsley().isValid()) {
            e.preventDefault();

            var row = "<tr id='id" + idTable + "'>" +
                "<td>" + $('#assessmenttopic').val() + "</td>" +
                "<td>" + $('#inputAssessment').val() +"</td>" +
                "<td style='text-align: center;'>" +
                "<button class='btn btn-danger btn-xs' value='" + idTable + "' id='btnRemove'>Remove</button>" +
                "</td>" +
                "</tr>";
            tableAssessment.row.add($(row)[0]).draw(false);
            idTable++;

            $('#formAssessment').trigger('reset');
            $('#formAssessment').parsley().reset();
        }
    });

    //remove topic
    $('#assessment-list').on('click', '#btnRemove', function(e) {
        tableAssessment.row("#id" + $(this).val()).remove().draw(false);
    });

    //save interview assessment
    $('#btnSubmit').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        adminid = $('meta[name="AuthenticatedID"]').attr('content');

        var formData = [];
        tableAssessment.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var data = {
                inputAssessmentTopic: this.cell(rowIdx, 0).data(),
                inputAssessment: this.cell(rowIdx, 1).data(),
            };
            formData.push(data);
        });    

        formData = { 
            inputApplicantID: applicantid,
            inputAdminID: adminid,
            formData: formData,
        };

        $.ajax({
            type: "POST",
            url: "/admin/transaction/assessmentinterview",
            data: formData,
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + data.applicantid).remove().draw(false);

                $('#modalAssess').modal('hide');
                toastr.success("ASSESS SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);
            },
        });
    });

    $('#applicant-list').on('click', '#btnAssess', function() { 
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
            url: "/json/assessmenttopic/all",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<option value='" + value.name + "'>" + value.name + "</option>";

                    $('#assessmenttopic').append(row);
                });
            },
            error: function(data) {
                console.log(data);
            },
        });

        $.ajax({
            type: "GET",
            url: "/admin/transaction/testassessment",
            data: { inputApplicantID: applicantid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr>" +
                        "<td>" + value.assessment_topic.name + "</td>" +
                        "<td>" + value.message + "</td>" +
                        "</tr>";
                    tableTestAssessment.row.add($(row)[0]).draw(false);
                });
            },
            error: function(data) {
                console.log(data);
            },
        });

        $('#modalAssess').modal('show');
    });



});