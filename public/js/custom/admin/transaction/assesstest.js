$(document).ready(function() {
    var applicantid, adminid, idTable = 0;
    var table = $('#tblAssessTest').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[1, 'asc']]).draw();
    var tablePassFail = $('#tblPassFail').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    var tableEssay = $('#tblEssay').DataTable({
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
    });

    //reset when modal hide
    $('#modalAssess').on('hide.bs.modal', function() {
        $('#formAssessment').trigger('reset');
        $('#formAssessment').parsley().reset();
        $('#assessmenttopic').empty();
        tableAssessment.clear().draw();
        tableEssay.clear().draw();
        tablePassFail.clear().draw();
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

    //saving of test assessment
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
            url: "/admin/transaction/assessmenttest",
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
            url: "/admin/transaction/testscore",
            data: { inputApplicantID: applicantid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.item != 0) {
                        var percent = (value.score / value.item) * 100;
                        var row = "<tr>" +
                            "<td>" + value.name + "</td>" +
                            "<td style='text-align: center;'>" + value.score + " / " + value.item +"</td>" +
                            "<td style='text-align: center;'>" + percent.toFixed(2) + "%</td>" +
                            "</tr>";
                        tablePassFail.row.add($(row)[0]).draw(false);
                    }
                });
            },
            error: function(data) {
                console.log(data);
            },
        });

        $.ajax({
            type: "GET",
            url: "/admin/transaction/essayanswer",
            data: { inputApplicantID: applicantid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.answer == null) {
                        value.answer = "";
                    }

                    var row = "<tr>" +
                        "<td>" + value.question + "</td>" +
                        "<td>" + value.answer + "</td>" +
                        "</tr>";
                    tableEssay.row.add($(row)[0]).draw(false);
                });
            },
            error: function(data) {
                console.log(data);
            },
        });

        $('#modalAssess').modal('show');
    });


});