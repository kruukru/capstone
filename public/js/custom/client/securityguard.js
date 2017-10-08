$(document).ready(function() {
    var applicantid;
	var table = $('#tblSecurityGuard').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false },
        ]
    });
    table.order([[0, 'asc']]).draw();

    //security guard profile
    $('#securityguard-list').on('click', '#btnProfile', function() {
        $('#applicantinfo-list').empty();
        $('#education-list').empty();
        $('#employment-list').empty();
        $('#training-list').empty();

        $.ajax({
            type: "GET",
            url: "/json/applicant/one",
            data: { inputApplicantID: $(this).val() },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.middlename == null) {
                    data.middlename = "";
                }
                if (data.provincialaddress == null) {
                    data.provincialaddress = "";
                }
                if (data.provincialaddresscity == null) {
                    data.provincialaddresscity = "";
                }
                if (data.provincialaddressprovince == null) {
                    data.provincialaddressprovince = "";
                }
                if (data.hobby == null) {
                    data.hobby = "";
                }
                if (data.skill == null) {
                    data.skill = "";
                }
                if (data.contacttelno == null) {
                    data.contacttelno = "";
                }

                $('#pictureview').attr('src', '/applicant/'+data.picture);

                var row = "<tr><td>NAME</td><td>"+data.lastname+", "+data.firstname+" "+data.middlename+"</td></tr>" + 
                    "<tr><td>ADDRESS</td><td>"+data.cityaddress+", "+data.cityaddresscity+", "+data.cityaddressprovince+"</td></tr>" + 
                    "<tr><td>PROVINCIAL ADDRESS</td><td>"+data.provincialaddress+", "+data.provincialaddresscity+", "+data.provincialaddressprovince+"</td></tr>" + 
                    "<tr><td>GENDER</td><td>"+data.gender+"</td></tr>" + 
                    "<tr><td>BIRTHDATE</td><td>"+$.format.date(data.birthdate, "yyyy-MM-dd")+"</td></tr>" + 
                    "<tr><td>BIRTHPLACE</td><td>"+data.birthplace+"</td></tr>" + 
                    "<tr><td>AGE</td><td>"+data.age+"</td></tr>" + 
                    "<tr><td>CIVIL STATUS</td><td>"+data.civilstatus+"</td></tr>" + 
                    "<tr><td>RELIGION</td><td>"+data.religion+"</td></tr>" + 
                    "<tr><td>BLOOD TYPE</td><td>"+data.bloodtype+"</td></tr>" + 
                    "<tr><td>CONTACT NO.</td><td>"+data.appcontactno+"</td></tr>" + 
                    "<tr><td>HEIGHT</td><td>"+data.height+" cm</td></tr>" + 
                    "<tr><td>WEIGHT</td><td>"+data.weight+" kg</td></tr>" + 
                    "<tr><td>LICENSE</td><td>"+data.license+"</td></tr>" + 
                    "<tr><td>LICENSE EXPIRATION</td><td>"+$.format.date(data.licenseexpiration, "yyyy-MM-dd")+"</td></tr>" + 
                    "<tr><td>SSS</td><td>"+data.sss+"</td></tr>" + 
                    "<tr><td>PHILHEALTH</td><td>"+data.philhealth+"</td></tr>" + 
                    "<tr><td>PAGIBIG</td><td>"+data.pagibig+"</td></tr>" + 
                    "<tr><td>TIN</td><td>"+data.tin+"</td></tr>" + 
                    "<tr><td>HOBBIES</td><td>"+data.hobby+"</td></tr>" + 
                    "<tr><td>SKILLS</td><td>"+data.skill+"</td></tr>" + 
                    "<tr><td>CONTACT PERSON</td><td>"+data.contactperson+"</td></tr>" + 
                    "<tr><td>CONTACT PERSON NO.</td><td>"+data.contactno+"</td></tr>" + 
                    "<tr><td>CONTACT PERSON TEL NO.</td><td>"+data.contacttelno+"</td></tr>";
                $('#applicantinfo-list').append(row);
            }
        });

        $.ajax({
            type: "GET",
            url: "/json/applicant/educationbackground",
            data: { inputApplicantID: $(this).val() },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.degree == null) {
                        value.degree = "";
                    }

                    var row = "<tr>" +
                        "<td>" + value.graduatetype + "</td>" +
                        "<td>" + value.degree + "</td>" +
                        "<td>" + value.dategraduated + "</td>" +
                        "<td>" + value.schoolgraduated + "</td>" +
                        "</tr>";
                    $('#education-list').append(row);
                });
            },
        });

        $.ajax({
            type: "GET",
            url: "/json/applicant/employmentrecord",
            data: { inputApplicantID: $(this).val() },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.reason == null) {
                        value.reason = "";
                    }

                    var row = "<tr>" +
                        "<td>" + value.company + "</td>" +
                        "<td>" + value.industrytype + "</td>" +
                        "<td>" + value.duration + "</td>" +
                        "<td>" + value.reason + "</td>" +
                        "</tr>";
                    $('#employment-list').append(row);
                });
            },
        });

        $.ajax({
            type: "GET",
            url: "/json/applicant/trainingcertificate",
            data: { inputApplicantID: $(this).val() },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr>" +
                        "<td>" + value.certificate + "</td>" +
                        "<td>" + value.conductedby + "</td>" +
                        "<td>" + value.dateconducted + "</td>" +
                        "</tr>";
                    $('#training-list').append(row);
                });
            },
        });

        $('#modalProfile').modal('show');
    });

    //repalce security guard
    $('#securityguard-list').on('click', '#btnReplace', function() {
        $('#formReplace').trigger('reset');
        $('#formReplace').parsley().reset();
        applicantid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/applicant/one",
            data: { inputApplicantID: applicantid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.middlename == "") {
                    data.middlename = "";
                }

                $('#securityGuardName').text(data.firstname+" "+data.middlename+" "+data.lastname);
            },
        });

        $('#modalReplace').modal('show');
    });

    //save replace security guard
    $('#btnSaveReplace').click(function(e) {
        if ($('#formReplace').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $('#modalReplace').loading({
                message: "SAVING..."
            });

            var formData = {
                inputApplicantID: applicantid,
                inputReason: $('#reason').val()
            };

            $.ajax({
                type: "POST",
                url: "/client/securityguard/replace",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        table.cell('#id'+applicantid, 0).data(),
                        table.cell('#id'+applicantid, 1).data(),
                        table.cell('#id'+applicantid, 2).data(),
                        table.cell('#id'+applicantid, 3).data(),
                        "<button class='btn btn-primary btn-xs' id='btnProfile' value="+applicantid+">View Profile</button> " +
                        "<button class='btn btn-warning btn-xs' id='btnCancelReplace' value="+applicantid+">Cancel Replacement</button>"
                    ];
                    table.row('#id'+applicantid).data(dt).draw(false);

                    $('#modalReplace').loading('stop');
                    $('#modalReplace').modal('hide');
                },
            });
        }
    });

    //cancel replacement
    $('#securityguard-list').on('click', '#btnCancelReplace', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        applicantid = $(this).val();
        
        $('#modalReplace').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/client/securityguard/replace/cancel",
            data: { inputApplicantID: applicantid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var dt = [
                    table.cell('#id'+applicantid, 0).data(),
                    table.cell('#id'+applicantid, 1).data(),
                    table.cell('#id'+applicantid, 2).data(),
                    table.cell('#id'+applicantid, 3).data(),
                    "<button class='btn btn-primary btn-xs' id='btnProfile' value="+applicantid+">View Profile</button> " +
                    "<button class='btn btn-primary btn-xs' id='btnReplace' value="+applicantid+">Replace SG</button>"
                ];
                table.row('#id'+applicantid).data(dt).draw(false);

                $('#modalReplace').modal('hide');
                $('#modalReplace').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });



});