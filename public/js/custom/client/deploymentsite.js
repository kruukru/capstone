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
        checkboxClass: 'icheckbox_flat-blue',
    });

    //reset modal when hide
    $('#modalQualification').on('hide.bs.modal', function() {
        $('input').iCheck('uncheck');
        $('#formQualification').trigger('reset');
        $('#formQualification').parsley().reset();
        tableQualification.clear().draw();
    })

    $('#modalSecurityGuard').on('hide.bs.modal', function() {
        tableSecurityGuard.clear().draw();
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

            if (check) {
                var formData = {
                    inputMinAge: age[0],
                    inputMaxAge: age[1],
                    inputPreferAge: $('#preferage').val(),
                    inputMinHeight: height[0],
                    inputMaxHeight: height[1],
                    inputPreferHeight: $('#preferheight').val(),
                    inputMinWeight: weight[0],
                    inputMaxWeight: weight[1],
                    inputPreferWeight: $('#preferweight').val(),
                };

                $.ajax({
                    type: "GET",
                    url: "/client/deploymentsite/qualification/validate",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);

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
                    },
                    error: function(data) {
                        console.log(data);

                        if (data.responseJSON == "INVALID AGE") {
                            toastr.error("AGE: PREFER AGE MUST BE INSIDE OF AGE RANGE");
                        } else if (data.responseJSON == "INVALID HEIGHT") {
                            toastr.error("HEIGHT: PREFER HEIGHT MUST BE INSIDE OF HEIGHT RANGE");
                        } else if (data.responseJSON == "INVALID WEIGHT") {
                            toastr.error("WEIGHT: PREFER WEIGHT MUST BE INSIDE OF WEIGHT RANGE");
                        }
                    },
                });
            }
        }
    });

    //remove qualiftion from the table
    $('#qualification-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();

        tableQualification.row('#id' + $(this).val()).remove().draw(false);
    });

    //input a qualification button
    $('#deploymentsite-list').on('click', '#btnQualification', function(e) {
        deploymentsiteid = $(this).val();

        $('#modalQualification').modal('show');
    });

    $('#btnQualificationSave').click(function(e) {
        e.preventDefault();
        if (tableQualification.row().count() != 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
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
                inputDeploymentSiteID: deploymentsiteid, 
                formData: formData,
            };

            $.ajax({
                type: "POST",
                url: "/client/deploymentsite/qualification/new",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        data.sitename,
                        data.location + ", " + data.city + ", " + data.province,
                        "PENDING REQUEST",
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnApprove' value='"+data.deploymentsiteid+"'>Update</button>" +
                        "</td>",
                    ];
                    table.row('#id' + deploymentsiteid).data(dt).draw(false);

                    $('#modalQualification').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);
                },
            });
        } else {
            toastr.error("NO QUALIFICATION IN THE LIST");
        }
    });

    $('#deploymentsite-list').on('click', '#btnSGList', function(e) {
        deploymentsiteid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/client/deploymentsite/securityguard/list",
            data: { inputDeploymentSiteID: $(this).val(), },
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
                            "<button class='btn btn-default btn-xs' id='Accept' value="+value.applicantid+">Accept</button> " +
                            "<button class='btn btn-default btn-xs' id='Decline' value="+value.applicantid+">Decline</button>" +
                        "</td>" +
                        "</tr>";
                    tableSecurityGuard.row.add($(row)[0]);
                });
                tableSecurityGuard.order([2, 'asc']).draw();
            },
            error: function(data) {
                console.log(data);
            },
        });

        $('#modalSecurityGuard').modal('show');
    });

    $('#securityguard-list').on('click', '.btn', function() {
        $(this).parents('tr').find('.btn').addClass('btn-default');
        $(this).parents('tr').find('.btn').removeClass('btn-primary');
        $(this).addClass('btn-primary');
        $(this).removeClass('btn-default');
    });

    $('#btnSGSave').click(function(e) {
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
            var acceptsgno = 0;
            $('#tblSecurityGuard > tbody > tr').each(function() {
                if ($(this).find('.btn-primary').attr('id') == "Accept") {
                    acceptsgno++;
                }
                var data = {
                    inputApplicantID: $(this).find('.btn-primary').val(),
                    inputStatus: $(this).find('.btn-primary').attr('id'),
                };
                formData.push(data);
            });

            if (acceptsgno >= requireno) {
                formData = { 
                    inputDeploymentSiteID: deploymentsiteid,
                    formData: formData,
                };

                $.ajax({
                    type: "POST",
                    url: "/client/deploymentsite/securityguard/list",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);

                        var dt = [
                            data.sitename,
                            data.location + ", " + data.city + ", " + data.province,
                            "PENDING ITEMS",
                            "<td style='text-align: center;'>" +
                                "<button class='btn btn-primary btn-xs' id='btnUpdate' value='"+data.deploymentsiteid+"'>Update</button>" +
                            "</td>",
                        ];
                        table.row('#id' + deploymentsiteid).data(dt).draw(false);

                        $('#modalSecurityGuard').modal('hide');
                        toastr.success("SAVE SUCCESSFUL");
                    },
                });
            } else {
                toastr.error("YOU NEED TO ACCEPT " + (requireno - acceptsgno) + " MORE SECURITY GUARD");
            }
        } else {
            toastr.error("PICK AN ACTION IN EVERY SECURITY GUARD");
        }
    });

    $('#deploymentsite-list').on('click', '#btnItem', function(e) {
        e.preventDefault();
        deploymentsiteid = $(this).val();
        tableFirearm.clear().draw();
        tableItem.clear().draw();

        $.ajax({
            type: "GET",
            url: "/client/deploymentsite/item/get",
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
            url: "/client/deploymentsite/firearm/get",
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
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });



});