$(document).ready(function() {
    var requestid, itemid, qtyavailable, qtyinput, name, itemtype, countFirearm = 0;
    var firearmsave = [];
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
    var tableRequestItem = $('#tblRequestItem').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    var tableInventory = $('#tblInventory').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableDeployItem = $('#tblDeployItem').DataTable({
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
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableDeployFirearm = $('#tblDeployFirearm').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tablePool = $('#tblPool').DataTable({
        "aoColumns": [
            null,
            null,
            null,
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
    var tableDeploy = $('#tblDeploy').DataTable({
        "aoColumns": [
            null,
            null,
            null,
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

    //reset the modal
    $('#modalItem').on('hide.bs.modal', function() {
        firearmsave = [];
        tableRequestItem.clear().draw();
        tableInventory.clear().draw();
        tableDeployItem.clear().draw();
    });
    $('#modalFirearm').on('hide.bs.modal', function() {
        countFirearm = 0;
        tableFirearm.clear().draw();
        tableDeployFirearm.clear().draw();
    });
    $('#modalSecurityGuard').on('hide.bs.modal', function() {
        tablePool.clear().draw();
        tableDeploy.clear().draw();
        $('#clientqualification-list').empty();
        $('#clientqualification-number').empty();
    });

    //confirm decline request
    $('#request-list').on('click', '#btnDecline', function(e) {
        e.preventDefault();
        requestid = $(this).val();

        $('#modalDeclineConfirmation').modal('show');
    });
    $('#btnDeclineConfirm').on('click', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalDeclineConfirmation').loading({
            message: "REMOVING..."
        });

        $.ajax({
            type: "POST",
            url: "/admin/transaction/request/decline",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + requestid).remove().draw(false);

                $('#modalDeclineConfirmation').modal('hide');
                $('#modalDeclineConfirmation').loading('stop');
                toastr.success("REMOVE SUCCESSFUL");
            },
        });
    });

    //deploy modal
    $('#request-list').on('click', '#btnDeploy', function(e) {
        e.preventDefault();
        requestid = $(this).val();
        var requesttype = $(this).closest('tr').find('#requesttype').text();

        if (requesttype == "ITEM") {
            $.ajax({
                type: "GET",
                url: "/admin/transaction/request/item/inventory",
                data: { inputRequestID: requestid },
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    $.each(data.requestitem, function(index, value) {
                        if (value.qty == null) {
                            value.qty = "";
                        }

                        var row = "<tr id=id" + value.requestid + ">" +
                            "<td>" + value.item.name + "</td>" +
                            "<td>" + value.item.itemtype.name + "</td>" +
                            "<td>" + value.qty + "</td>" +
                            "</tr>";
                        tableRequestItem.row.add($(row)[0]).draw();
                    });

                    $.each(data.item, function(index, value) {
                        var row = "<tr id=id" + value.itemid + ">" +
                            "<td id='name'>" + value.name + "</td>" +
                            "<td id='itemtype'>" + value.itemtype.name + "</td>" +
                            "<td id='qtyavailable' style='text-align: right;'>" + value.qtyavailable + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<form id=form"+value.itemid+" data-parsley-validate>" +
                                "<input type='text' id=inputQty"+value.itemid+" placeholder='Qty' " +
                                    "class='form-control' style='text-align: right; width: 75px;' pattern='^[1-9][0-9]*$' required>" +
                                "<button class='btn btn-primary btn-sm' id='btnAdd' value="+value.itemid+">Add</button>" +
                            "</form>" +
                            "</td>" +
                            "</tr>";
                        tableInventory.row.add($(row)[0]).draw();
                    });
                },
            });

            $('#modalItem').modal('show');
        } else if (requesttype == "PERSONNEL") {
            $('#btnSaveSecurityGuard').val(0);
            getSecurityGuard();

            $('#modalSecurityGuard').modal('show');
        }
    });

    //deploy security guard
    //update security guard
    $('#request-list').on('click', '#btnUpdateSecurityGuard', function(e) {
        e.preventDefault();
        requestid = $(this).val();
        $('#btnSaveSecurityGuard').val(1);

        getSecurityGuard();

        $('#modalSecurityGuard').modal('show');
    });

    //change of client qualification
    $('#clientqualification-number').on('change', function() {
        clientqualificationid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/clientqualification/one",
            data: { inputClientQualificationID: clientqualificationid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#clientqualification-list').empty();
                tablePool.clear().draw();

                var age = data.age.split(",");
                var height = data.height.split(",");
                var weight = data.weight.split(",");

                var row = "<tr><td>Number of Security Guards</td><td>"+data.requireno+"</td></tr>" +
                    "<tr><td>Gender</td><td>"+data.gender+"</td></tr>" +
                    "<tr><td>Level of Attainment</td><td>"+data.attainment+"</td></tr>" +
                    "<tr><td>Civil Status</td><td>"+data.civilstatus+"</td></tr>" +
                    "<tr><td>Working Experience (months)</td><td>"+data.workexp+"</td></tr>" +
                    "<tr><td>Age</td><td>[ "+age[0]+" to "+age[2]+" ] Prefer Age: "+age[1]+"</td></tr>" +
                    "<tr><td>Height (cm)</td><td>[ "+height[0]+" to "+height[2]+" ] Prefer Height: "+height[1]+"</td></tr>" +
                    "<tr><td>Weight (kg)</td><td>[ "+weight[0]+" to "+weight[2]+" ] Prefer Weight: "+weight[1]+"</td></tr>";
                $('#clientqualification-list').append(row);

                $.ajax({
                    type: "GET",
                    url: "/admin/transaction/deploysecurityguard/securityguard/percent",
                    data: { inputClientQualificationID: clientqualificationid, },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);

                        $.each(data.pool, function(index, value) {
                            var check = true;
                            tableDeploy.rows().every(function(rowIdx, tableLoop, rowLoop) {
                                if (this.cell(rowIdx, 0).data() == value.applicantid) {
                                    check = false;
                                }
                            });

                            if (check) {
                                var row = "<tr id=id" + value.applicantid + ">" +
                                    "<td>" + value.applicantid + "</td>" +
                                    "<td>" + value.name + "</td>";
                                //gender
                                var str = value.gender.split(",");
                                if (str.length == 2) {
                                    row += "<td id='gender' class='posi'>" + str[0] + "</td>";
                                } else {
                                    row += "<td id='gender' class='nega'>" + str[0] + "</td>";
                                }
                                //civilstatus
                                var str = value.civilstatus.split(",");
                                if (str.length == 2) {
                                    row += "<td id='civilstatus' class='posi'>" + str[0] + "</td>";
                                } else {
                                    row += "<td id='civilstatus' class='nega'>" + str[0] + "</td>";
                                }
                                //attainment
                                var str = value.attainment.split(",");
                                if (str.length == 2) {
                                    row += "<td id='attainment' class='posi'>" + str[0] + "</td>";
                                } else {
                                    row += "<td id='attainment' class='nega'>" + str[0] + "</td>";
                                }
                                //work experience
                                var str = value.workexp.toString().split(",");
                                if (str.length == 2) {
                                    row += "<td id='workexp' class='posi' style='text-align: center'>" + str[0] + "</td>";
                                } else {
                                    row += "<td id='workexp' class='nega' style='text-align: center'>" + str[0] + "</td>";
                                }
                                //age, height, weight
                                row += "<td style='text-align: center'>" + value.age.toFixed(2) + "%</td>" +
                                    "<td style='text-align: center'>" + value.height.toFixed(2) + "%</td>" +
                                    "<td style='text-align: center'>" + value.weight.toFixed(2) + "%</td>";
                                //distance
                                if (value.distance == null) {
                                    row += "<td style='text-align: center'>N/A</td>";
                                } else {
                                    row += "<td style='text-align: center'>" + value.distance.toFixed(2) + "</td>";
                                }
                                //vacant
                                row += "<td style='text-align: center;'>" + value.vacant + "</td>" +
                                    "<td style='text-align: center;'>" +
                                    "<button class='btn btn-primary btn-xs' id='btnAdd' value="+value.applicantid+">Add</button> " +
                                    "</td>" +
                                    "</tr>";

                                tablePool.row.add($(row)[0]);
                            }
                        });

                        tablePool.order([10, 'desc']).draw();
                    },
                });
            },
        });
    });

    //adding of security guard to the deploy
    $('#pool-list').on('click', '#btnAdd', function(e) {
        e.preventDefault();

        var row = "<tr id=id" + $(this).val() + ">" +
            "<td>" + $(this).val() + "</td>" +
            "<td>" + tablePool.cell('#id'+$(this).val(), 1).data() + "</td>" +
            "<td id='gender' class='" + $(this).parents('tr').find('#gender').attr('class') + "'>" + 
                tablePool.cell('#id'+$(this).val(), 2).data() + "</td>" +
            "<td id='civilstatus' class='" + $(this).parents('tr').find('#civilstatus').attr('class') + "'>" + 
                tablePool.cell('#id'+$(this).val(), 3).data() + "</td>" +
            "<td id='attainment' class='" + $(this).parents('tr').find('#attainment').attr('class') + "'>" + 
                tablePool.cell('#id'+$(this).val(), 4).data() + "</td>" +
            "<td id='workexp' class='" + $(this).parents('tr').find('#workexp').attr('class') + "' style='text-align: center;'>" +
                tablePool.cell('#id'+$(this).val(), 5).data() + "</td>" +
            "<td style='text-align: center;'>" + 
                tablePool.cell('#id'+$(this).val(), 6).data() + "</td>" +
            "<td style='text-align: center;'>" + 
                tablePool.cell('#id'+$(this).val(), 7).data() + "</td>" +
            "<td style='text-align: center;'>" + 
                tablePool.cell('#id'+$(this).val(), 8).data() + "</td>" +
            "<td style='text-align: center;'>" + 
                tablePool.cell('#id'+$(this).val(), 9).data() + "</td>" +
            "<td style='text-align: center;'>" + 
                tablePool.cell('#id'+$(this).val(), 10).data() + "</td>" +
            "<td style='text-align: center;'>" +
                "<button class='btn btn-warning btn-xs' id='btnRemove' value=" + $(this).val() + ">Remove</button> " +
            "</td>" +
            "</tr>";

        tablePool.row('#id'+$(this).val()).remove().draw(false);
        tableDeploy.row.add($(row)[0]).order([10, 'desc']).draw();
    });

    //removing of security guard from the deploy
    $('#deployed-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();

        tableDeploy.row('#id'+$(this).val()).remove().draw(false);
    });

    //saving of deploy security guard
    $('#btnSaveSecurityGuard').click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        if (requireno <= tableDeploy.rows().count()) {
            $('#modalSecurityGuard').loading({
                message: "SAVING..."
            });

            var formData = [];
            tableDeploy.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = {
                    inputApplicantID: this.cell(rowIdx, 0).data(),
                }
                formData.push(data);
            });
            formData = {
                inputRequestID: requestid,
                inputType: $('#btnSaveSecurityGuard').val(),
                formData: formData,
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/request/clientqualification",
                data: formData,
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
                        "PENDING APPROVAL",
                        "<button class='btn btn-primary btn-xs' id='btnUpdateSecurityGuard' value='"+data.requestid+"'>Update</button>"
                    ];
                    table.row('#id'+requestid).data(dt).draw(false);

                    $('#modalSecurityGuard').modal('hide');
                    $('#modalSecurityGuard').loading('stop');
                    toastr.success("SAVE SUCCESSFULLY");
                },
            });
        } else {
            toastr.error("YOU NEED " + (requireno - tableDeploy.rows().count()) + " MORE SECURITY GUARD");
        }
    });

    //deploy item
    //add item to the deploy list
    $('#inventory-list').on('click', '#btnAdd', function(e) {
        itemid = $(this).val();
        qtyinput = parseInt($('#inputQty'+itemid).val());
        name = $(this).closest('tr').find('#name').text();
        qtyavailable = parseInt($(this).closest('tr').find('#qtyavailable').text());
        itemtype = $(this).closest('tr').find('#itemtype').text();

        if ($('#form'+itemid).parsley().isValid()) {
            e.preventDefault();

            if (parseInt($(this).closest('tr').find('#qtyavailable').text()) < $('#inputQty'+itemid).val()) {
                toastr.error("INVALID QUANTITY");
            } else {
                if (itemtype.toUpperCase() == "FIREARM" || itemtype.toUpperCase() == "FIREARMS") {
                    $.ajax({
                        type: "GET",
                        url: "/admin/transaction/request/firearm",
                        data: { inputItemID: itemid, },
                        dataType: "json",
                        success: function(data) {
                            console.log(data);

                            $.each(data, function(index, value) {
                                var check = true;
                                $.each(firearmsave, function(index1, value1) {
                                    if (value.license == value1.inputLicense) {
                                        check = false;
                                    }
                                });

                                if (check) {
                                    var row = "<tr id=id" + value.firearmid + ">" +
                                        "<td id='license'>" + value.license + "</td>" +
                                        "<td id='expiration'>" + $.format.date(value.expiration, "MMM. d, yyyy") + "</td>" +
                                        "<td style='text-align: center;'>" +
                                            "<button class='btn btn-primary btn-xs' id='btnAdd' value="+value.firearmid+">Add</button>" +
                                        "</td>" +
                                        "</tr>";
                                    tableFirearm.row.add($(row)[0]).draw();
                                }
                            });

                            $.each(firearmsave, function(index, value) {
                                if (value.inputItemID == itemid) {
                                    var row = "<tr id=id" + value.inputFirearmID + ">" +
                                        "<td id='license'>" + value.inputLicense + "</td>" +
                                        "<td id='expiration'>" + $.format.date(value.inputExpiration, "MMM. d, yyyy") + "</td>" +
                                        "<td style='text-align: center;'>" +
                                            "<button class='btn btn-warning btn-xs' id='btnRemove' value="+value.inputFirearmID+">Remove</button>" +
                                        "</td>" +
                                        "</tr>";
                                    tableDeployFirearm.row.add($(row)[0]).draw();
                                }
                            });

                            $('#firearm-need').text("0/" + qtyinput + " Firearm(s)");
                        },
                    });

                    $('#modalFirearm').modal('show');
                } else {
                    $(this).closest('tr').find('#qtyavailable').text(qtyavailable - qtyinput);

                    var check = true;
                    if (tableDeployItem.rows().count()) { 
                        tableDeployItem.rows().every(function(rowIdx, tableLoop, rowLoop) {
                            if (this.cell(rowIdx, 0).data() == name) {
                                this.cell(rowIdx, 2).data(parseInt(this.cell(rowIdx, 2).data()) + qtyinput);
                                check = false;
                            }
                        });
                    }
                    
                    if (check) {
                        var row = "<tr id=id" + itemid + ">" +
                            "<td id='name'>" + $(this).closest('tr').find('#name').text() + "</td>" +
                            "<td id='itemtype'>" + $(this).closest('tr').find('#itemtype').text() + "</td>" +
                            "<td id='qtyavailable' style='text-align: right;'>" + $('#inputQty'+itemid).val() + "</td>" +
                            "<td style='text-align: center;'>" +
                                "<button class='btn btn-warning btn-xs' id='btnRemove' value="+itemid+">Remove</button>" +
                            "</td>" +
                            "</tr>";
                        tableDeployItem.row.add($(row)[0]).draw();
                    }

                    $('#form'+itemid).trigger('reset');
                    $('#form'+itemid).parsley().reset();
                }
            }
        }
    });

    //remove item to the deploy list
    $('#deployitem-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();
        itemid = $(this).val();
        qtyavailable = parseInt($('#inventory-list').find('#id' + itemid).find('#qtyavailable').text());
        qtyinput = parseInt($(this).closest('tr').find('#qtyavailable').text());
        itemtype = $(this).closest('tr').find('#itemtype').text();

        var firearmtemp = [];
        if (itemtype.toUpperCase() == "FIREARM" || itemtype.toUpperCase() == "FIREARMS") {
            $.each(firearmsave, function(index, value) {
                if (value.inputItemID != itemid) {
                    var data = {
                        inputItemID: value.inputItemID,
                        inputFirearmID: value.inputFirearmID,
                        inputLicense: value.inputLicense,
                        inputExpiration: value.inputExpiration,
                    };
                    firearmtemp.push(data);
                }
            });

            firearmsave = firearmtemp;
        }

        $('#inventory-list').find('#id' + itemid).find('#qtyavailable').text(qtyavailable + qtyinput);
        tableDeployItem.row('#id' + itemid).remove().draw(false);
    });

    //add firearm to the deploy list
    $('#firearm-list').on('click', '#btnAdd', function(e) {
        e.preventDefault();
        var firearmid = $(this).val();

        var row = "<tr id=id" + firearmid + ">" +
            "<td id='license'>" + $(this).closest('tr').find('#license').text() + "</td>" +
            "<td id='expiration'>" + $(this).closest('tr').find('#expiration').text() + "</td>" +
            "<td style='text-align: center;'>" +
                "<button class='btn btn-warning btn-xs' id='btnRemove' value="+firearmid+">Remove</button>" +
            "</td>" +
            "</tr>";
        tableDeployFirearm.row.add($(row)[0]).draw();
        tableFirearm.row('#id' + firearmid).remove().draw(false);

        countFirearm++;
        $('#firearm-need').text(countFirearm + "/" +qtyinput + " Firearm(s)");
    });

    //remove firearm from the deploy list
    $('#deployfirearm-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();
        var firearmid = $(this).val();

        var row = "<tr id=id" + firearmid + ">" +
            "<td id='license'>" + $(this).closest('tr').find('#license').text() + "</td>" +
            "<td id='expiration'>" + $(this).closest('tr').find('#expiration').text() + "</td>" +
            "<td style='text-align: center;'>" +
                "<button class='btn btn-primary btn-xs' id='btnAdd' value="+firearmid+">Add</button>" +
            "</td>" +
            "</tr>";
        tableFirearm.row.add($(row)[0]).draw();
        tableDeployFirearm.row('#id' + firearmid).remove().draw(false);

        countFirearm--;
        $('#firearm-need').text(countFirearm + "/" +qtyinput + " Firearm(s)");
    });

    //saving of firearm item
    $('#btnFirearmSave').click(function(e) {
        e.preventDefault();

        var firearmtemp = [];
        if (countFirearm == qtyinput) {
            $('#tblDeployFirearm > tbody > tr').each(function() {
                var data = {
                    inputItemID: itemid,
                    inputFirearmID: $(this).find('#btnRemove').val(),
                    inputLicense: $(this).find('#license').text(),
                    inputExpiration: $(this).find('#expiration').text(),
                };
                firearmtemp.push(data);
            });

            $('#tblInventory').find('#id'+itemid).find('#qtyavailable').text(qtyavailable - qtyinput);

            var check = true;
            if (tableDeployItem.rows().count()) { 
                tableDeployItem.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    if (this.cell(rowIdx, 0).data() == name) {
                        this.cell(rowIdx, 2).data(parseInt(this.cell(rowIdx, 2).data()) + qtyinput);
                        check = false;
                    }
                });
            }
            
            if (check) {
                var row = "<tr id=id" + itemid + ">" +
                    "<td id='name'>" + name + "</td>" +
                    "<td id='itemtype'>" + itemtype + "</td>" +
                    "<td id='qtyavailable' style='text-align: right;'>" + $('#inputQty'+itemid).val() + "</td>" +
                    "<td style='text-align: center;'>" +
                        "<button class='btn btn-warning btn-xs' id='btnRemove' value="+itemid+">Remove</button>" +
                    "</td>" +
                    "</tr>";
                tableDeployItem.row.add($(row)[0]).draw();
            }

            var firearminitvalue = [];
            $.each(firearmsave, function(index, value) {
                if (value.inputItemID != itemid) {
                    var data = {
                        inputItemID: value.inputItemID,
                        inputFirearmID: value.inputFirearmID,
                        inputLicense: value.inputLicense,
                        inputExpiration: value.inputExpiration,
                    };
                    firearminitvalue.push(data);
                }
            });

            firearmsave = firearminitvalue.concat(firearmtemp);

            $('#form'+itemid).trigger('reset');
            $('#form'+itemid).parsley().reset();
            $('#modalFirearm').modal('hide');
        } else if (countFirearm < qtyinput) {
            toastr.error("YOU NEED " + (qtyinput - countFirearm) + " MORE FIREARM(S)");
        } else if (countFirearm > qtyinput) {
            toastr.error("YOU EXCEED " + (countFirearm - qtyinput) + " FIREARM(S)");
        }
    });

    //saving of deploy item
    $('#btnItemSave').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        if (tableDeployItem.rows().count() != 0) {
            var formData = [];
            $('#tblDeployItem > tbody > tr').each(function() {
                var data = {
                    inputItemID: $(this).find('#btnRemove').val(),
                    inputQty: $(this).find('#qtyavailable').text(),
                };
                formData.push(data);
            });

            formData = {
                inputRequestID: requestid,
                inputItemList: formData,
                inputFirearmList: firearmsave,
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/request/item",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var name;
                    if (data.account.client == null) {
                        name = data.account.manager.firstname + " " + data.account.manager.lastname;
                    } else {
                        name = data.account.client.contactperson;
                    }

                    var dt = [
                        data.requestid,
                        data.type,
                        data.deploymentsite.sitename,
                        data.deploymentsite.location,
                        name,
                        $.format.date(data.datecreated, "yyyy-MM-dd"),
                        "PENDING RECEIVE",
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnUpdate' value='"+data.requestid+"'>Update</button>" +
                        "</td>",
                    ];
                    table.row('#id' + requestid).data(dt).draw(false);

                    $('#modalItem').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
            });
        } else {
            toastr.error("NO DEPLOY ITEM");
        }
    });

    function getSecurityGuard() {
        $.ajax({
            type: "GET",
            url: "/admin/transaction/request/clientqualification",
            data: { inputRequestID: requestid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var count = 1;
                requireno = 0;
                $.each(data, function(index, value) {
                    $('#clientqualification-number').append("<option value="+value.clientqualificationid+">"+count+"</option>");
                    requireno += value.requireno;
                    count++;
                });

                clientqualificationid = data[0].clientqualificationid;

                var age = data[0].age.split(",");
                var height = data[0].height.split(",");
                var weight = data[0].weight.split(",");

                var row = "<tr><td>Number of Security Guards</td><td>"+data[0].requireno+"</td></tr>" +
                    "<tr><td>Gender</td><td>"+data[0].gender+"</td></tr>" +
                    "<tr><td>Level of Attainment</td><td>"+data[0].attainment+"</td></tr>" +
                    "<tr><td>Civil Status</td><td>"+data[0].civilstatus+"</td></tr>" +
                    "<tr><td>Working Experience (months)</td><td>"+data[0].workexp+"</td></tr>" +
                    "<tr><td>Age</td><td>[ "+age[0]+" to "+age[2]+" ] Prefer Age: "+age[1]+"</td></tr>" +
                    "<tr><td>Height (cm)</td><td>[ "+height[0]+" to "+height[2]+" ] Prefer Height: "+height[1]+"</td></tr>" +
                    "<tr><td>Weight (kg)</td><td>[ "+weight[0]+" to "+weight[2]+" ] Prefer Weight: "+weight[1]+"</td></tr>";
                $('#clientqualification-list').append(row);

                $.ajax({
                    type: "GET",
                    url: "/admin/transaction/request/securityguard/percent",
                    data: { inputClientQualificationID: clientqualificationid },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);

                        $.each(data.pool, function(index, value) {
                            var row = "<tr id=id" + value.applicantid + ">" +
                                "<td>" + value.applicantid + "</td>" +
                                "<td>" + value.name + "</td>";
                            //gender
                            var str = value.gender.split(",");
                            if (str.length == 2) {
                                row += "<td id='gender' class='posi'>" + str[0] + "</td>";
                            } else {
                                row += "<td id='gender' class='nega'>" + str[0] + "</td>";
                            }
                            //civilstatus
                            var str = value.civilstatus.split(",");
                            if (str.length == 2) {
                                row += "<td id='civilstatus' class='posi'>" + str[0] + "</td>";
                            } else {
                                row += "<td id='civilstatus' class='nega'>" + str[0] + "</td>";
                            }
                            //attainment
                            var str = value.attainment.split(",");
                            if (str.length == 2) {
                                row += "<td id='attainment' class='posi'>" + str[0] + "</td>";
                            } else {
                                row += "<td id='attainment' class='nega'>" + str[0] + "</td>";
                            }
                            //work experience
                            var str = value.workexp.toString().split(",");
                            if (str.length == 2) {
                                row += "<td id='workexp' class='posi' style='text-align: center'>" + str[0] + "</td>";
                            } else {
                                row += "<td id='workexp' class='nega' style='text-align: center'>" + str[0] + "</td>";
                            }
                            //age, height, weight
                            row += "<td style='text-align: center'>" + value.age.toFixed(2) + "%</td>" +
                                "<td style='text-align: center'>" + value.height.toFixed(2) + "%</td>" +
                                "<td style='text-align: center'>" + value.weight.toFixed(2) + "%</td>";
                            //distance
                            if (value.distance == null) {
                                row += "<td style='text-align: center'>N/A</td>";
                            } else {
                                row += "<td style='text-align: center'>" + value.distance.toFixed(2) + "</td>";
                            }
                            //vacant
                            row += "<td style='text-align: center;'>" + value.vacant + "</td>" +
                                "<td style='text-align: center;'>" +
                                "<button class='btn btn-primary btn-xs' id='btnAdd' value="+value.applicantid+">Add</button> " +
                                "</td>" +
                                "</tr>";

                            tablePool.row.add($(row)[0]);
                        });

                        $.each(data.poolsent, function(index, value) {
                            var row = "<tr id=id" + value.applicantid + ">" +
                                "<td>" + value.applicantid + "</td>" +
                                "<td>" + value.name + "</td>";
                            //gender
                            var str = value.gender.split(",");
                            if (str.length == 2) {
                                row += "<td id='gender' class='posi'>" + str[0] + "</td>";
                            } else {
                                row += "<td id='gender' class='nega'>" + str[0] + "</td>";
                            }
                            //civilstatus
                            var str = value.civilstatus.split(",");
                            if (str.length == 2) {
                                row += "<td id='civilstatus' class='posi'>" + str[0] + "</td>";
                            } else {
                                row += "<td id='civilstatus' class='nega'>" + str[0] + "</td>";
                            }
                            //attainment
                            var str = value.attainment.split(",");
                            if (str.length == 2) {
                                row += "<td id='attainment' class='posi'>" + str[0] + "</td>";
                            } else {
                                row += "<td id='attainment' class='nega'>" + str[0] + "</td>";
                            }
                            //work experience
                            var str = value.workexp.toString().split(",");
                            if (str.length == 2) {
                                row += "<td id='workexp' class='posi' style='text-align: center'>" + str[0] + "</td>";
                            } else {
                                row += "<td id='workexp' class='nega' style='text-align: center'>" + str[0] + "</td>";
                            }
                            //age, height, weight
                            row += "<td style='text-align: center'>" + value.age.toFixed(2) + "%</td>" +
                                "<td style='text-align: center'>" + value.height.toFixed(2) + "%</td>" +
                                "<td style='text-align: center'>" + value.weight.toFixed(2) + "%</td>";
                            //distance
                            if (value.distance == null) {
                                row += "<td style='text-align: center'>N/A</td>";
                            } else {
                                row += "<td style='text-align: center'>" + value.distance.toFixed(2) + "</td>";
                            }
                            //vacant
                            row += "<td style='text-align: center;'>" + value.vacant + "</td>" +
                                "<td style='text-align: center;'>" +
                                "<button class='btn btn-warning btn-xs' id='btnRemove' value="+value.applicantid+">Remove</button> " +
                                "</td>" +
                                "</tr>";

                            tableDeploy.row.add($(row)[0]);
                        });

                        tablePool.order([10, 'desc']).draw();
                        tableDeploy.order([10, 'desc']).draw();
                    },
                });
            },
        });
    }



});