$(document).ready(function() {
    var deploymentsiteid, idTable = 0, requireno = 0;
	var table = $('#tblDeploymentSite').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
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

    //declare all checkbox an icheck
    $('input').iCheck({
        radioClass: 'iradio_flat-blue',
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

    //add qualification to the table
    $('#btnQualificationAdd').click(function(e) {
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

    //remove qualiftion from the table
    $('#qualification-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();

        tableQualification.row('#id' + $(this).val()).remove().draw(false);
    });

    //input a qualification
    $('#deploymentsite-list').on('click', '#btnQualification', function(e) {
        $('input').iCheck('uncheck');
        $('#formQualification').trigger('reset');
        $('#formQualification').parsley().reset();
        tableQualification.clear().draw();

        deploymentsiteid = $(this).val();

        $('#modalQualification').modal('show');
    });

    //update of qualificication
    $('#deploymentsite-list').on('click', '#btnUpdateQualification', function(e) {
        $('input').iCheck('uncheck');
        $('#formQualification').trigger('reset');
        $('#formQualification').parsley().reset();
        tableQualification.clear().draw();
        
        deploymentsiteid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/client/deploymentsite/clientqualification",
            data: { inputDeploymentSiteID: deploymentsiteid },
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

                $('#modalQualification').modal('show');
            },
            error: function(data) {
                console.log(data);
            },
        });
    });

    $('#btnQualificationSave').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalQualification').loading({
            message: "SAVING..."
        });

        if (tableQualification.rows().count() != 0) {
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
                inputDeploymentSiteID: deploymentsiteid, 
                formData: formData,
            };

            $.ajax({
                type: "POST",
                url: "/client/deploymentsite/clientqualification",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        data.sitename,
                        data.location + ", " + data.city + ", " + data.province,
                        "PENDING REQUEST",
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnUpdateQualification' value='"+data.deploymentsiteid+"'>Update</button>" +
                        "</td>",
                    ];
                    table.row('#id' + deploymentsiteid).data(dt).draw(false);

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
                },
            });
        } else {
            $('#modalQualification').loading('stop');
            toastr.error("NO QUALIFICATION IN THE LIST");
        }
    });

    $('#deploymentsite-list').on('click', '#btnSGList', function(e) {
        tableSecurityGuard.clear().draw();

        deploymentsiteid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/client/deploymentsite/securityguard/list",
            data: { inputDeploymentSiteID: deploymentsiteid },
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
                        row += "<td style='text-align: center;'>NOT AVAILABLE</td>";
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
            },
            error: function(data) {
                console.log(data);
            },
        });

        $('#modalSecurityGuard').modal('show');
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

    $('#btnSGSave').click(function(e) {
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
            inputDeploymentSiteID: deploymentsiteid,
            inputStatus: $('#btnConfirm').val(),
            formData: formData
        };

        $.ajax({
            type: "POST",
            url: "/client/deploymentsite/securityguard/list",
            data: formData,
            dataType: "json",
            success: function(data) {
                console.log(data);

                if ($('#btnConfirm').val() == 0) {
                    var dt = [
                        data.sitename,
                        data.location + ", " + data.city + ", " + data.province,
                        "PENDING ITEMS",
                        "<td style='text-align: center;'></td>"
                    ];
                    table.row('#id' + deploymentsiteid).data(dt).draw(false);
                } else {
                    var dt = [
                        data.sitename,
                        data.location + ", " + data.city + ", " + data.province,
                        "PENDING REQUEST",
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnUpdateQualification' value='"+data.deploymentsiteid+"'>Update</button>" +
                        "</td>"
                    ];
                    table.row('#id' + deploymentsiteid).data(dt).draw(false);
                }

                $('#modalConfirmation').modal('hide');
                $('#modalSecurityGuard').modal('hide');
                $('#modalConfirmation').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            }
        });
    });

    $('#deploymentsite-list').on('click', '#btnItem', function(e) {
        e.preventDefault();
        deploymentsiteid = $(this).val();
        tableFirearm.clear().draw();
        tableItem.clear().draw();

        $.ajax({
            type: "GET",
            url: "/client/deploymentsite/item",
            data: { inputDeploymentSiteID: deploymentsiteid },
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
            url: "/client/deploymentsite/firearm",
            data: { inputDeploymentSiteID: deploymentsiteid },
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

    $('#btnReceive').click(function(e) {
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
            url: "/client/deploymentsite/item",
            data: { inputDeploymentSiteID: deploymentsiteid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var dt = [
                    data.sitename,
                    data.location + ", " + data.city + ", " + data.province,
                    "ACTIVE",
                    "<td style='text-align: center;'>" +
                        "<button class='btn btn-primary btn-xs' id='btnView' value='"+data.deploymentsiteid+"'>View</button>" +
                    "</td>",
                ];
                table.row('#id' + deploymentsiteid).data(dt).draw(false);

                $('#modalItem').modal('hide');
                $('#modalItem').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });



});