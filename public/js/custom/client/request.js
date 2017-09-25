$(document).ready(function() {
    var itemid, requestid, idTable = 0;
    var table = $('#tblRequest').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false },
        ]
    });
    table.order([[5, 'asc']]).draw();
    var tableInventory = $('#tblInventory').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableRequestItem = $('#tblRequestItem').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableFirearm = $('#tblFirearm').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    var tableItem = $('#tblItem').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    var tableQualification = $('#tblQualification').DataTable({
        "aoColumns": [
            null,
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
    var tableSecurityGuard = $('#tblSecurityGuard').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    //declare all checkbox an icheck
    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
    });

    //declare slider
    $('#agerange').slider({
        min: 18,
        max: 80,
        range: true,
        value: [18, 80],
        tooltip: 'always',
    });
    $('#heightrange').slider({
        min: 120,
        max: 300,
        range: true,
        value: [120, 300],
        tooltip: 'always',
    });
    $('#weightrange').slider({
        min: 40,
        max: 200,
        range: true,
        value: [40, 200],
        tooltip: 'always',
    });

    //show / unhide the working experience
    $('#workingexperience').on('ifChecked', function(event) {
        $('#workingexperience-info').show();
    });
    $('#workingexperience').on('ifUnchecked', function(event) {
        $('#workexp').val("");
        $('#workingexperience-info').hide();
    });

    //declaring of attainment nice
    $('#attainment[value="College"]').on('ifChecked', function(event) {
        $('#attainment[value="High School"]').prop('checked', false).iCheck('update');
        $('#attainment[value="Elementary"]').prop('checked', false).iCheck('update');
    });
    $('#attainment[value="College"]').on('ifUnchecked', function(event) {
        $('#attainment[value="High School"]').prop('checked', false).iCheck('update');
        $('#attainment[value="Elementary"]').prop('checked', false).iCheck('update');
    });
    $('#attainment[value="High School"]').on('ifChecked', function(event) {
        $('#attainment[value="Elementary"]').prop('checked', false).iCheck('update');
        $('#attainment[value="College"]').prop('checked', true).iCheck('update');
    });
    $('#attainment[value="High School"]').on('ifUnchecked', function(event) {
        $('#attainment[value="Elementary"]').prop('checked', false).iCheck('update');
        $('#attainment[value="College"]').prop('checked', true).iCheck('update');
    });
    $('#attainment[value="Elementary"]').on('ifChecked', function(event) {
        $('#attainment[value="High School"]').prop('checked', true).iCheck('update');
        $('#attainment[value="College"]').prop('checked', true).iCheck('update');
    });

    //request security guard
    $('#btnNewRequestSecurityGuard').click(function(e) {
        e.preventDefault();
        $('#deploymentsitelistsg').prop('disabled', false);
        requestid = null;

        clearClientQualification();

        $.ajax({
            type: "GET",
            url: "/client/request/deploymentsite",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    $('#deploymentsitelistsg').append('<option value='+value.deploymentsiteid+'>'+value.sitename+'</option>');
                });
            },
        });

        $('#modalQualification').modal('show');
    });

    //request item
    $('#btnNewRequestItem').click(function(e) {
        e.preventDefault();
        $('#deploymentsitelistitem').prop('disabled', false);
        requestid = null;

        getItem();

        $.ajax({
            type: "GET",
            url: "/client/request/deploymentsite",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    $('#deploymentsitelistitem').append('<option value='+value.deploymentsiteid+'>'+value.sitename+'</option>');
                });
            },
        });

        $('#modalRequestItem').modal('show');
    });

    //cancel of request
    $('#request-list').on('click', '#btnCancel', function(e) {
        e.preventDefault();
        requestid = $(this).val();

        $('#modalCancelConfirmation').modal('show');
    });
    $('#btnRemoveConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalCancelConfirmation').loading({
            message: "REMOVING..."
        });

        $.ajax({
            type: "POST",
            url: "/client/request/remove",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + requestid).remove().draw(false);
                
                $('#modalCancelConfirmation').modal('hide');
                $('#modalCancelConfirmation').loading('stop');
                toastr.success("CANCEL SUCCESSFUL");
            },
        });
    });

    //security guard security guard security guard security guard security guard security guard security guard 
    //update qualification
    $('#request-list').on('click', '#btnUpdateQualification', function(e) {
        e.preventDefault();
        $('#deploymentsitelistsg').prop('disabled', true);
        requestid = $(this).val();

        clearClientQualification();

        $.ajax({
            type: "GET",
            url: "/json/request/one",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#deploymentsitelistsg').append('<option value='+data.deploymentsiteid+'>'+data.deploymentsite.sitename+'</option>');
            }
        });

        $.ajax({
            type: "GET",
            url: "/client/request/clientqualification",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr id=id" + idTable + ">" +
                        "<td>" + value.requireno + "</td>" +
                        "<td>" + value.gender + "</td>" +
                        "<td>" + value.attainment + "</td>" +
                        "<td>" + value.civilstatus + "</td>" +
                        "<td>" + value.age + "</td>" +
                        "<td>" + value.height + "</td>" +
                        "<td>" + value.weight + "</td>" +
                        "<td>" + value.workexp + "</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-danger btn-xs' id='btnRemove' value=" + idTable + ">Remove</button>" +
                        "</td>" +
                        "</tr>";
                    tableQualification.row.add($(row)[0]).draw();
                    idTable++;
                });
            }
        });

        $('#modalQualification').modal('show');
    });

    //add qualification to the table
    $('#btnAddQualification').click(function(e) {
        if ($('#formQualification').parsley().isValid()) {
            e.preventDefault();

            var gender = "", attainment = "", civilstatus = "", duration = 0;
            var age = $('#agerange').val().split(",");
            var height = $('#heightrange').val().split(",");
            var weight = $('#weightrange').val().split(",");
            var check = true;

            $('[type="checkbox"]#gender:checked').each(function() {
                gender += $(this).val() + ",";
            });
            $('[type="checkbox"]#attainment:checked').each(function() {
                attainment += $(this).val() + ",";
            });
            $('[type="checkbox"]#civilstatus:checked').each(function() {
                civilstatus += $(this).val() + ",";
            });

            if (gender == "") {
                toastr.error("GENDER: PICK ATLEAST 1");
                check = false;
            }
            if (attainment == "") {
                toastr.error("ATTAINMENT: PICK ATLEAST 1");
                check = false;
            }
            if (civilstatus == "") {
                toastr.error("CIVIL STATUS: PICK ATLEAST 1");
                check = false;
            }
            if ((age[1] - age[0]) <= 5) {
                toastr.error("AGE: ATLEAST MINIMUM OF 5 RANGE");
                check = false;
            }
            if ((height[1] - height[0]) <= 5) {
                toastr.error("HEIGHT: ATLEAST MINIMUM OF 5 RANGE");
                check = false;
            }
            if ((weight[1] - weight[0]) <= 5) {
                toastr.error("WEIGHT: ATLEAST MINIMUM OF 5 RANGE");
                check = false;
            }
            if ($('#preferage').val() == "") {
                $('#preferage').val(age[0]);
            }
            if ($('#preferheight').val() == "") {
                var out = (Number(height[0]) + Number(height[1])) / 2;
                $('#preferheight').val(Math.round(out));
            }
            if ($('#preferweight').val() == "") {
                var out = (Number(weight[0]) + Number(weight[1])) / 2;
                $('#preferweight').val(Math.round(out));
            }

            if (!(Number(age[0]) <= Number($('#preferage').val()) && Number(age[1]) >= Number($('#preferage').val()))) {
                toastr.error("AGE: PREFER AGE MUST BE INSIDE OF AGE RANGE");
                check = false;
            }
            if (!(Number(height[0]) <= Number($('#preferheight').val()) && Number(height[1]) >= Number($('#preferheight').val()))) {
                toastr.error("HEIGHT: PREFER HEIGHT MUST BE INSIDE OF HEIGHT RANGE");
                check = false;
            }
            if (!(Number(weight[0]) <= Number($('#preferweight').val()) && Number(weight[1]) >= Number($('#preferweight').val()))) {
                toastr.error("WEIGHT: PREFER HEIGHT MUST BE INSIDE OF HEIGHT RANGE");
                check = false;
            }

            if (check) {
                var row = "<tr id=id" + idTable + ">" +
                    "<td>" + $('#requireno').val() + "</td>" +
                    "<td>" + gender + "</td>" +
                    "<td>" + attainment + "</td>" +
                    "<td>" + civilstatus + "</td>" +
                    "<td>" + age[0] + "," + $('#preferage').val() + "," + age[1] + "</td>" +
                    "<td>" + height[0] + "," + $('#preferheight').val() + "," + height[1] + "</td>" +
                    "<td>" + weight[0] + "," + $('#preferweight').val() + "," + weight[1] + "</td>";
                if ($('#workingexperiencetype').val() == "day") {
                    duration = $('#workexp').val() / 30;
                    row += "<td>" + duration.toFixed(2) + "</td>";
                } else if ($('#workingexperiencetype').val() == "month") {
                    duration = $('#workexp').val();
                    row += "<td>" + duration + "</td>";
                } else if ($('#workingexperiencetype').val() == "year") {
                    duration = $('#workexp').val() * 365;
                    row += "<td>" + duration + "</td>";
                }
                row += "<td style='text-align: center;'>" +
                    "<button class='btn btn-danger btn-xs' id='btnRemove' value=" + idTable + ">Remove</button>" +
                    "</td>" +
                    "</tr>";
                tableQualification.row.add($(row)[0]).draw();
                idTable++;

                $('input').iCheck('uncheck');
                $('#formQualification').trigger('reset');
                $('#formQualification').parsley().reset();
            }
        }
    });
    //remove qualification from the table
    $('#qualification-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();

        tableQualification.row('#id' + $(this).val()).remove().draw(false);
    });

    //save the qualification list
    $('#btnSaveQualification').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        if (tableQualification.rows().count() != 0) {
            $('#modalQualification').loading({
                message: "SAVING..."
            });

            var formData = [];
            tableQualification.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = {
                    inputRequireNo: this.cell(rowIdx, 0).data(),
                    inputGender: this.cell(rowIdx, 1).data(),
                    inputAttainment: this.cell(rowIdx, 2).data(),
                    inputCivilStatus: this.cell(rowIdx, 3).data(),
                    inputAge: this.cell(rowIdx, 4).data(),
                    inputHeight: this.cell(rowIdx, 5).data(),
                    inputWeight: this.cell(rowIdx, 6).data(),
                    inputWorkExp: this.cell(rowIdx, 7).data(),
                };
                formData.push(data);
            });

            var formData = {
                inputRequestID: requestid,
                inputDeploymentSiteID: $('#deploymentsitelistsg').val(), 
                formData: formData,
            };

            $.ajax({
                type: "POST",
                url: "/client/request/clientqualification",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (requestid == null) {
                        var row = "<tr id=id" + data.requestid + ">" +
                            "<td>" + data.requestid + "</td>" +
                            "<td>" + data.type + "</td>" +
                            "<td>" + data.deploymentsite.sitename + "</td>" +
                            "<td>" + data.deploymentsite.location + "</td>" +
                            "<td>Me</td>" +
                            "<td>Right Now</td>" +
                            "<td style='text-align: center;'>PENDING</td>" +
                            "<td style='text-align: center;'>" +
                                "<button class='btn btn-primary btn-xs' id='btnUpdateQualification' value="+data.requestid+">Update</button> " +
                                "<button class='btn btn-danger btn-xs' id='btnCancel' value="+data.requestid+">Cancel</button>" +
                            "</td>" +
                            "</tr>";
                        table.row.add($(row)[0]).draw();
                    }

                    $('#modalQualification').modal('hide');
                    $('#modalQualification').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalQualification').loading('stop');
                    if (data.responseJSON == "INSUFFICIENT REQUIRE NO") {
                        toastr.error("INVALID REQUIRE NO");
                    }
                }
            });
        } else {
            toastr.error("NO QUALIFICATION IN THE LIST");
        }
    });

    $('#request-list').on('click', '#btnAcceptSecurityGuard', function(e) {
        tableSecurityGuard.clear().draw();
        requestid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/client/request/securityguard/list",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                requireno = data.requireno;
                $.each(data.pool, function(index, value) {
                    console.log(index + " / " + value);

                    var row = "<tr id=id" + value.applicantid + ">" +
                        "<td>" + value.name + "</td>" +
                        "<td style='text-align: center;'>" + value.workexp + "</td>";
                    if (value.distance == null) {
                        row += "<td style='text-align: center;'>N/A</td>";
                    } else {
                        row += "<td style='text-align: center;'>" + value.distance.toFixed(2) + "</td>";
                    }
                    row += "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnProfile' value="+value.applicantid+">View Profile</button>&emsp;&emsp;&emsp;" +
                            "<label><input type='radio' name='status"+value.applicantid+"' id='status' value='Accept'> Accept</label>&emsp;" +
                            "<label><input type='radio' name='status"+value.applicantid+"' id='status' value='Decline'> Decline</label>" +
                        "</td>" +
                        "</tr>";
                    tableSecurityGuard.row.add($(row)[0]);
                });
                tableSecurityGuard.order([2, 'asc']).draw();

                $('input').iCheck({
                    radioClass: 'iradio_flat-blue',
                    checkboxClass: 'icheckbox_flat-blue',
                });
            }
        });

        $('#modalSecurityGuard').modal('show');
    });

    $('#securityguard-list').on('click', '#btnProfile', function(e) {
        e.preventDefault();
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

    $('#btnRequest').click(function(e) {
        e.preventDefault();

        var check = true, acceptedsg = 0;
        tableSecurityGuard.rows().every(function(rowIdx, tableLoop, rowLoop) {
            if (this.cell(rowIdx, 3).nodes().to$().find('#status:checked').val() == "Accept") {
                acceptedsg++;
            }
            if (this.cell(rowIdx, 3).nodes().to$().find(':checked').length == 0) {
                check = false;
            }
        });

        if (check) {
            if (acceptedsg == requireno) {
                toastr.error("CANNOT REQUEST WHEN YOUR SECURITY GUARD IS COMPLETE");
            } else if (acceptedsg > requireno) {
                toastr.error("ACCEPTED SECURITY GUARD EXCEED");
            } else {
                $('#btnConfirm').val(1);

                $('#modalConfirmation').modal('show');
            }
        } else {
            toastr.error("PICK AN ACTION IN EVERY SECURITY GUARD");
        }
    });

    $('#btnSaveSecurityGuard').click(function(e) {
        e.preventDefault();

        var check = true, acceptedsg = 0;
        tableSecurityGuard.rows().every(function(rowIdx, tableLoop, rowLoop) {
            if (this.cell(rowIdx, 3).nodes().to$().find('#status:checked').val() == "Accept") {
                acceptedsg++;
            }
            if (this.cell(rowIdx, 3).nodes().to$().find(':checked').length == 0) {
                check = false;
            }
        });

        if (check) {
            if (acceptedsg < requireno) {
                toastr.error("YOU NEED TO ACCEPT " + (requireno - acceptedsg) + " MORE SECURITY GUARD");
            } else if (acceptedsg > requireno) {
                toastr.error("ACCEPTED SECURITY GUARD EXCEED");
            } else {
                $('#btnConfirm').val(0);

                $('#modalConfirmation').modal('show');
            }
        } else {
            toastr.error("PICK AN ACTION IN EVERY SECURITY GUARD");
        }
    });

    $('#btnConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalConfirmation').loading({
            message: "SAVING..."
        });

        var formData = [];
        tableSecurityGuard.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var data = {
                inputApplicantID: this.cell(rowIdx, 3).nodes().to$().find('#btnProfile').val(),
                inputStatus: this.cell(rowIdx, 3).nodes().to$().find('#status:checked').val()
            };
            formData.push(data);
        });

        formData = { 
            inputRequestID: requestid,
            inputStatus: $('#btnConfirm').val(),
            formData: formData
        };

        $.ajax({
            type: "POST",
            url: "/client/request/securityguard/list",
            data: formData,
            dataType: "json",
            success: function(data) {
                console.log(data);

                if ($('#btnConfirm').val() == 0) {
                    var dt = [
                        table.cell('#id'+requestid, 0).data(),
                        table.cell('#id'+requestid, 1).data(),
                        table.cell('#id'+requestid, 2).data(),
                        table.cell('#id'+requestid, 3).data(),
                        table.cell('#id'+requestid, 4).data(),
                        table.cell('#id'+requestid, 5).data(),
                        "COMPLETE",
                        ""
                    ];
                    table.row('#id'+requestid).data(dt).draw(false);
                } else {
                    var dt = [
                        table.cell('#id'+requestid, 0).data(),
                        table.cell('#id'+requestid, 1).data(),
                        table.cell('#id'+requestid, 2).data(),
                        table.cell('#id'+requestid, 3).data(),
                        table.cell('#id'+requestid, 4).data(),
                        table.cell('#id'+requestid, 5).data(),
                        "PENDING",
                        "<button class='btn btn-primary btn-xs' id='btnUpdateQualification' value='"+data.requestid+"'>Update</button>"
                    ];
                    table.row('#id'+requestid).data(dt).draw(false);
                }

                $('#modalConfirmation').modal('hide');
                $('#modalSecurityGuard').modal('hide');
                $('#modalConfirmation').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            }
        });
    });



    //item item item item item item item item item item item item item item item item item item item item item item item 
    $('#inventory-list').on('click', '#btnAdd', function(e) {
        e.preventDefault();
        itemid = $(this).val();

        var row = "<tr id=id" + itemid + ">" +
            "<td id='name'>" + $('#inventory-list').find('#id'+itemid).find('#name').text() + "</td>" +
            "<td id='itemtypename'>" + $('#inventory-list').find('#id'+itemid).find('#itemtypename').text() + "</td>" +
            "<td style='text-align: center;'>" +
                "<input type='text' id='approxqty' class='form-control' style='text-align: right; width: 75px;' pattern='^[1-9][0-9]*$' maxlength='5' placeholder='Qty'>" +
            "</td>" +
            "<td style='text-align: center;'>" +
                "<button class='btn btn-danger btn-xs' id='btnRemove' value=" + itemid + ">Remove</button> " +
            "</td>" +
            "</tr>";
        tableRequestItem.row.add($(row)[0]).draw();
        tableInventory.row('#id' + itemid).remove().draw(false);
    });

    $('#requestitem-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();
        itemid = $(this).val();

        var row = "<tr id=id" + itemid + ">" +
            "<td id='name'>" + $('#requestitem-list').find('#id'+itemid).find('#name').text() + "</td>" +
            "<td id='itemtypename'>" + $('#requestitem-list').find('#id'+itemid).find('#itemtypename').text() + "</td>" +
            "<td style='text-align: center;'>" +
                "<button class='btn btn-primary btn-xs' id='btnAdd' value=" + itemid + ">Add</button> " +
            "</td>" +
            "</tr>";
        tableInventory.row.add($(row)[0]).draw();
        tableRequestItem.row('#id' + itemid).remove().draw(false);
    });

    $('#request-list').on('click', '#btnUpdateItem', function(e) {
        e.preventDefault();
        $('#deploymentsitelistitem').prop('disabled', true);
        requestid = $(this).val();

        getItem();

        $.ajax({
            type: "GET",
            url: "/json/request/one",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#deploymentsitelistitem').append('<option value='+data.deploymentsiteid+'>'+data.deploymentsite.sitename+'</option>');
            }
        });

        $('#modalRequestItem').modal('show');
    });

    $('#btnSaveRequestItem').click(function(e) {
        if ($('#formRequestItem').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            if (tableRequestItem.rows().count() == 0) {
                toastr.error("NO REQUEST ITEM");
                return;
            }

            $('#modalRequestItem').loading({
                message: "SAVING..."
            });

            var formData = [];
            tableRequestItem.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = {
                    inputItemID: this.cell(rowIdx, 3).nodes().to$().find('#btnRemove').val(),
                    inputQty: this.cell(rowIdx, 2).nodes().to$().find('#approxqty').val()
                };
                formData.push(data);
            });

            formData = {
                inputRequestID: requestid,
                inputDeploymentSiteID: $('#deploymentsitelistitem').val(),
                formData: formData
            };

            $.ajax({
                type: "POST",
                url: "/client/request/inventory",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (requestid == null) {
                        var row = "<tr id=id" + data.requestid + ">" +
                            "<td>" + data.requestid + "</td>" +
                            "<td>" + data.type + "</td>" +
                            "<td>" + data.deploymentsite.sitename + "</td>" +
                            "<td>" + data.deploymentsite.location + "</td>" +
                            "<td>Me</td>" +
                            "<td>Right Now</td>" +
                            "<td style='text-align: center;'>PENDING</td>" +
                            "<td style='text-align: center;'>" +
                                "<button class='btn btn-primary btn-xs' id='btnUpdateItem' value="+data.requestid+">Update</button> " +
                                "<button class='btn btn-danger btn-xs' id='btnCancel' value="+data.requestid+">Cancel</button>" +
                            "</td>" +
                            "</tr>";
                        table.row.add($(row)[0]).draw();
                    }

                    $('#modalRequestItem').modal('hide');
                    $('#modalRequestItem').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                }
            });
        }
    });

    $('#request-list').on('click', '#btnAcceptItem', function(e) {
        e.preventDefault();
        requestid = $(this).val();
        tableFirearm.clear().draw();
        tableItem.clear().draw();

        $.ajax({
            type: "GET",
            url: "/client/request/item",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr id=id" + value.issueditemid + ">" +
                        "<td>" + value.item.name + "</td>" +
                        "<td>" + value.item.itemtype.name + "</td>" +
                        "<td>" + value.qty + "</td>" +
                        "</tr>";
                    tableItem.row.add($(row)[0]).draw();
                });
            },
        });

        $.ajax({
            type: "GET",
            url: "/client/request/firearm",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr id=id" + value.issuedfirearmid + ">" +
                        "<td>" + value.firearm.item.name + "</td>" +
                        "<td>" + value.firearm.license + "</td>" +
                        "<td>" + $.format.date(value.firearm.expiration, "MMM. d, yyyy") + "</td>" +
                        "</tr>";
                    tableFirearm.row.add($(row)[0]).draw();
                });
            },
        });

        $('#modalItem').modal('show');
    });

    $('#btnReceiveItem').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalItem').loading({
            message: "SAVING..."
        });

        $.ajax({
            type: "POST",
            url: "/client/request/item",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var dt = [
                    table.cell('#id'+requestid, 0).data(),
                    table.cell('#id'+requestid, 1).data(),
                    table.cell('#id'+requestid, 2).data(),
                    table.cell('#id'+requestid, 3).data(),
                    table.cell('#id'+requestid, 4).data(),
                    table.cell('#id'+requestid, 5).data(),
                    "COMPLETE",
                    ""
                ];
                table.row('#id'+requestid).data(dt).draw(false);

                $('#modalItem').modal('hide');
                $('#modalItem').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });

    function getItem() {
        $('#deploymentsitelistitem').empty();
        tableInventory.clear().draw();
        tableRequestItem.clear().draw();

        $.ajax({
            type: "GET",
            url: "/client/request/inventory",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data.item, function(index, value) {
                    var check = true;
                    $.each(data.itemsent, function(index1, value1) {
                        if (value.itemid == value1.item.itemid) {
                            value = value1;
                            check = false;
                        }
                    });

                    if (check) {
                        var row = "<tr id=id" + value.itemid + ">" +
                            "<td id='name'>" + value.name + "</td>" +
                            "<td id='itemtypename'>" + value.itemtype.name + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnAdd' value="+value.itemid+">Add</button> " +
                            "</td>" +
                            "</tr>";
                        tableInventory.row.add($(row)[0]).draw();
                    } else {
                        if (value.qty == null) {
                            value.qty = "";
                        }

                        var row = "<tr id=id" + value.item.itemid + ">" +
                            "<td id='name'>" + value.item.name + "</td>" +
                            "<td id='itemtypename'>" + value.item.itemtype.name + "</td>" +
                            "<td style='text-align: center;'>" +
                                "<input type='text' id='approxqty' class='form-control' style='text-align: right; width: 75px;' pattern='^[1-9][0-9]*$' placeholder='Qty' maxlength='5' value="+value.qty+">" +
                            "</td>" +
                            "<td style='text-align: center;'>" +
                                "<button class='btn btn-danger btn-xs' id='btnRemove' value=" + value.item.itemid + ">Remove</button> " +
                            "</td>" +
                            "</tr>";
                        tableRequestItem.row.add($(row)[0]).draw();
                    }     
                });
            },
        });
    }

    function clearClientQualification() {
        $('input').iCheck('uncheck');
        $('#deploymentsitelistsg').empty();
        $('#formQualification').trigger('reset');
        $('#formQualification').parsley().reset();
        tableQualification.clear().draw();
    }



});