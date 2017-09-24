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
            { "bSearchable": false, "bSortable": false, },
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



    //request security guard
    $('#btnNewRequestSG').click(function(e) {
        e.preventDefault();
        $('input').iCheck('uncheck');
        $('#deploymentsitelistsg').empty();
        $('#deploymentsitelistsg').prop('disabled', false);
        $('#formQualification').trigger('reset');
        $('#formQualification').parsley().reset();
        tableQualification.clear().draw();

        requestid = null;

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

    //update the qualification
    $('#request-list').on('click', '#btnUpdateQualification', function(e) {
        e.preventDefault();
        $('input').iCheck('uncheck');
        $('#deploymentsitelistsg').empty();
        $('#deploymentsitelistsg').prop('disabled', true);
        $('#formQualification').trigger('reset');
        $('#formQualification').parsley().reset();
        tableQualification.clear().draw();

        requestid = $(this).val();

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

    //save the qualification list
    $('#btnSaveQualification').click(function(e) {
        e.preventDefault();

        if (tableQualification.rows().count() != 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
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
            });
        } else {
            toastr.error("NO QUALIFICATION IN THE LIST");
        }
    });

    $('#request-list').on('click', '#btnAcceptSecurityGuard', function(e) {
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
        });

        $('#modalSecurityGuard').modal('show');
    });

    $('#btnSecurityGuardSave').click(function(e) {
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
                    inputRequestID: requestid,
                    formData: formData,
                };

                $.ajax({
                    type: "POST",
                    url: "/client/request/securityguard/list",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);

                        table.row('#id' + requestid).remove().draw(false);

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



    //request item
    $('#btnNewRequestItem').click(function(e) {
        $('#deploymentsitelistitem').empty();
        tableInventory.clear().draw();
        tableRequestItem.clear().draw();
        e.preventDefault();

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

        $.ajax({
            type: "GET",
            url: "/client/request/inventory",
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr id=id" + value.itemid + ">" +
                        "<td id='name'>" + value.name + "</td>" +
                        "<td id='itemtypename'>" + value.item_type.name + "</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-primary btn-xs' id='btnAdd' value="+value.itemid+">Add</button> " +
                        "</td>" +
                        "</tr>";
                    tableInventory.row.add($(row)[0]).draw();
                });
            },
        });

        $('#modalRequestItem').modal('show');
    });

    $('#inventory-list').on('click', '#btnAdd', function(e) {
        e.preventDefault();
        itemid = $(this).val();

        var row = "<tr id=id" + itemid + ">" +
            "<td id='name'>" + $('#inventory-list').find('#id'+itemid).find('#name').text() + "</td>" +
            "<td id='itemtypename'>" + $('#inventory-list').find('#id'+itemid).find('#itemtypename').text() + "</td>" +
            "<td style='text-align: center;'>" +
                "<input type='text' id='approxqty' class='form-control' style='text-align: right; width: 75px;' pattern='^[1-9][0-9]*$' placeholder='Qty'>" +
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

    $('#btnRequestItemSave').click(function(e) {
        if ($('#formRequestItem').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            if (tableRequestItem.row().count() == 0) {
                toastr.error("NO REQUEST ITEM");
                return;
            }

            var formData = [];
            $('#tblRequestItem > tbody > tr').each(function() {
                var data = {
                    inputItemID: $(this).find('#btnRemove').val(),
                    inputQty: $(this).find('#approxqty').val(),
                };
                formData.push(data);
            });

            formData = {
                inputDeploymentSiteID: $('#deploymentsitelistitem').val(),
                formData: formData,
            };

            $.ajax({
                type: "POST",
                url: "/client/request/inventory",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var row = "<tr id=id" + data.requestid + ">" +
                        "<td>" + data.requestid + "</td>" +
                        "<td>" + data.type + "</td>" +
                        "<td>" + data.deploymentsite.sitename + "</td>" +
                        "<td>" + data.deploymentsite.location + "</td>" +
                        "<td>Me</td>" +
                        "<td>Right Now</td>" +
                        "<td style='text-align: center;'>PENDING</td>" +
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-danger btn-xs' id='btnCancel' value="+data.requestid+">Cancel</button> " +
                        "</td>" +
                        "</tr>";
                    table.row.add($(row)[0]).draw();

                    $('#modalRequestItem').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
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

    $('#btnReceive').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/client/request/item",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + requestid).remove().draw(false);

                $('#modalItem').modal('hide');
                toastr.success("SAVE SUCCESSFUL");
            },
        });
    });



});