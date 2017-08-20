$(document).ready(function() {
    var managerid, deploymentsiteid;
    var table = $('#tblManager').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
    var tableDeploymentSite = $('#tblDeploymentSite').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tableAssignDeploymentSite = $('#tblAssignDeploymentSite').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });

    //validate the username
    $('#username').on('focusout', function() {
        if ($(this).val() != "") {
            $('#username').parsley().removeError('forcederror', {updateClass: true});
            $.ajax({
                type: "GET",
                url: "/json/validate-username",
                data: { inputUsername: $('#username').val(), },
                dataType: "json",
                success: function(data) {
                    $('#username').parsley().removeError('forcederror', {updateClass: true});
                },
                error: function(data) {
                    if (data.responseJSON == "SAME USERNAME") {
                        $('#username').parsley().addError('forcederror', {
                            message: 'Username already exist.',
                            updateClass: true,
                        });
                    }
                },
            });
        }
    });
    
    //validate password
    $('.input-password').on('keyup', function() {
        if ($('#confirmpassword').val() != "") {
            $('#password').parsley().removeError('forcederror', {updateClass: true});
            $('#confirmpassword').parsley().removeError('forcederror', {updateClass: true});
            if ($('#password').val() != $('#confirmpassword').val()) {
                $('#password').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
                $('#confirmpassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
            }
        }
    });
    $('.input-confirmpassword').on('keyup', function() {
        if ($('#password').val() != "") {
            $('#password').parsley().removeError('forcederror', {updateClass: true});
            $('#confirmpassword').parsley().removeError('forcederror', {updateClass: true});
            if ($('#password').val() != $('#confirmpassword').val()) {
                $('#password').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
                $('#confirmpassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
            }
        }
    });

    //validate the username
    $('#updateusername').on('focusout', function() {
        if ($(this).val() != "") {
            $('#updateusername').parsley().removeError('forcederror', {updateClass: true});
            $.ajax({
                type: "GET",
                url: "/json/validate-username",
                data: { inputUsername: $('#updateusername').val(), },
                dataType: "json",
                success: function(data) {
                    $('#updateusername').parsley().removeError('forcederror', {updateClass: true});
                },
                error: function(data) {
                    if (data.responseJSON == "SAME USERNAME") {
                        $('#updateusername').parsley().addError('forcederror', {
                            message: 'Username already exist.',
                            updateClass: true,
                        });
                    }
                },
            });
        }
    });
    
    //validate password
    $('.updateinput-password').on('keyup', function() {
        if ($('#updateconfirmpassword').val() != "") {
            $('#updatepassword').parsley().removeError('forcederror', {updateClass: true});
            $('#updateconfirmpassword').parsley().removeError('forcederror', {updateClass: true});
            if ($('#updatepassword').val() != $('#updateconfirmpassword').val()) {
                $('#updatepassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
                $('#updateconfirmpassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
            }
        }
    });
    $('.updateinput-confirmpassword').on('keyup', function() {
        if ($('#updatepassword').val() != "") {
            $('#updatepassword').parsley().removeError('forcederror', {updateClass: true});
            $('#updateconfirmpassword').parsley().removeError('forcederror', {updateClass: true});
            if ($('#updatepassword').val() != $('#updateconfirmpassword').val()) {
                $('#updatepassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
                $('#updateconfirmpassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
            }
        }
    });

    //reset the modal when hide
    $('#modalManager').on('hide.bs.modal', function() {
        $('#formManager').trigger('reset');
        $('#formManager').parsley().reset();
    });
    $('#modalManagerUpdate').on('hide.bs.modal', function() {
        $('#formAccountUpdate').trigger('reset');
        $('#formAccountUpdate').parsley().reset();
        $('#formManagerUpdate').trigger('reset');
        $('#formManagerUpdate').parsley().reset();
    });
    $('#modalAssign').on('hide.bs.modal', function() {
        tableDeploymentSite.clear().draw();
        tableAssignDeploymentSite.clear().draw();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#modalManager').modal('show');
    });

    //display modal for update task
    $('#manager-list').on('click', '#btnUpdate', function() { 
        managerid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/manager/one",
            data: { inputManagerID: managerid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.middlename == null) {
                    data.middlename = "";
                }

                $('#updateinputLastname').val(data.lastname);
                $('#updateinputFirstname').val(data.firstname);
                $('#updateinputMiddlename').val(data.middlename);

                $('#modalManagerUpdate').modal('show');
            },
        });
    });

    //display modal for confirmation of remove
    $('#manager-list').on('click', '#btnRemove', function() {
        managerid = $(this).val();

        $('#modalManagerRemove').modal('show');
    });

    //remove task and remove it from the list
    $('#btnRemoveConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/client/manager/remove",
            data: { inputManagerID: managerid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + managerid).remove().draw(false);

                $('#modalManagerRemove').modal('hide');
                toastr.success("REMOVE SUCCESSFUL");
            },
        });
    });

    //update account
    $('#btnAccountSave').click(function(e) {
        if ($('#formAccountUpdate').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            var formData = {
                inputManagerID: managerid,
                inputUsername: $('#updateusername').val(),
                inputPassword: $('#updatepassword').val(),
            };

            $.ajax({
                type: "POST",
                url: "/client/manager/update-account",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (data.middlename == null) {
                        data.middlename = "";
                    }

                    var dt = [
                        data.lastname + ", " + data.firstname + " " + data.middlename,
                        data.account.username,
                        "<button class='btn btn-primary btn-xs' id='btnAssign' value="+managerid+">Assign</button> " +
                        "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+managerid+">Update</button> " +
                        "<button class='btn btn-danger btn-xs' id='btnRemove' value="+managerid+">Remove</button>",
                    ];
                    table.row('#id' + managerid).data(dt).draw(false);

                    $('#formAccountUpdate').trigger('reset');
                    $('#formAccountUpdate').parsley().reset();
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    if (data.responseJSON == "SAME USERNAME") {
                        toastr.error("USERNAME ALREADY EXISTS");
                    }
                }
            });
        }
    });

    //update task
    $('#btnManagerSave').click(function(e) {
        if ($('#formManagerUpdate').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            var formData = {
                inputManagerID: managerid,
                inputLastname: $('#updateinputLastname').val(),
                inputFirstname: $('#updateinputFirstname').val(),
                inputMiddlename: $('#updateinputMiddlename').val(),
            };

            $.ajax({
                type: "POST",
                url: "/client/manager/update",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (data.middlename == null) {
                        data.middlename = "";
                    }

                    var dt = [
                        data.lastname + ", " + data.firstname + " " + data.middlename,
                        data.account.username,
                        "<button class='btn btn-primary btn-xs' id='btnAssign' value="+managerid+">Assign</button> " +
                        "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+managerid+">Update</button> " +
                        "<button class='btn btn-danger btn-xs' id='btnRemove' value="+managerid+">Remove</button>",
                    ];
                    table.row('#id' + managerid).data(dt).draw(false);

                    $('#modalManagerUpdate').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
            });
        }
    });

    //create new task
    $('#btnSave').click(function(e) {
        if ($('#formManager').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            var formData = {
                inputUsername: $('#username').val(),
                inputPassword: $('#password').val(),
                inputLastname: $('#inputLastname').val(),
                inputFirstname: $('#inputFirstname').val(),
                inputMiddlename: $('#inputMiddlename').val(),
            };

            $.ajax({
                type: "POST",
                url: "/client/manager/new",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (data.middlename == null) {
                        data.middlename = '';
                    }

                    var row = "<tr id=id" + data.managerid + ">" +
                        "<td>" + data.lastname + ", " + data.firstname + " " + data.middlename + "</td>" +
                        "<td>" + data.account.username + "</td>" +
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnAssign' value="+data.managerid+">Assign</button> " +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.managerid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.managerid+">Remove</button>" +
                        "</td>" +
                        "</tr>";
                    table.row.add($(row)[0]).draw();

                    $('#modalManager').modal('hide');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    if (data.responseJSON == "SAME USERNAME") {
                        toastr.error("USERNAME ALREADY EXISTS");
                    }
                }
            });
        }
    });

    $('#manager-list').on('click', '#btnAssign', function(e) {
        managerid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/manager/one",
            data: { inputManagerID: managerid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.middlename == null) {
                    data.middlename = "";
                }

                $('#managerName').text(data.lastname+", "+data.firstname+" "+data.middlename);

                $('#modalAssign').modal('show');
            },
        });

        $.ajax({
            type: "GET",
            url: "/client/manager/deploymentsite",
            data: { inputManagerID: managerid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr id=id" + value.deploymentsiteid + ">" +
                        "<td>" + value.sitename + "</td>" +
                        "<td>" + value.location + "</td>" +
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnAssign' value="+value.deploymentsiteid+">Assign</button> " +
                        "</td>" +
                        "</tr>";
                    tableDeploymentSite.row.add($(row)[0]).draw();
                });
            },
        });

        $.ajax({
            type: "GET",
            url: "/client/manager/assigndeploymentsite",
            data: { inputManagerID: managerid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    var row = "<tr id=id" + value.deploymentsiteid + ">" +
                        "<td>" + value.sitename + "</td>" +
                        "<td>" + value.location + "</td>" +
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+value.deploymentsiteid+">Remove</button> " +
                        "</td>" +
                        "</tr>";
                    tableAssignDeploymentSite.row.add($(row)[0]).draw();
                });
            },
        });
    });

    $('#deploymentsite-list').on('click', '#btnAssign', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        deploymentsiteid = $(this).val();

        $.ajax({
            type: "POST",
            url: "/client/manager/deploymentsite",
            data: { inputDeploymentSiteID: deploymentsiteid, inputManagerID: managerid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var row = "<tr id=id" + data.deploymentsiteid + ">" +
                    "<td>" + data.sitename + "</td>" +
                    "<td>" + data.location + "</td>" +
                    "<td style='text-align: center;'>" +
                        "<button class='btn btn-danger btn-xs' id='btnAssign' value="+data.deploymentsiteid+">Remove</button> " +
                    "</td>" +
                    "</tr>";
                tableAssignDeploymentSite.row.add($(row)[0]).draw();
                tableDeploymentSite.row('#id' + deploymentsiteid).remove().draw(false);
            },
        });
    });

    $('#assigndeploymentsite-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        deploymentsiteid = $(this).val();

        $.ajax({
            type: "POST",
            url: "/client/manager/assigndeploymentsite",
            data: { inputDeploymentSiteID: deploymentsiteid, inputManagerID: managerid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                var row = "<tr id=id" + data.deploymentsiteid + ">" +
                    "<td>" + data.sitename + "</td>" +
                    "<td>" + data.location + "</td>" +
                    "<td style='text-align: center;'>" +
                        "<button class='btn btn-primary btn-xs' id='btnAssign' value="+data.deploymentsiteid+">Assign</button> " +
                    "</td>" +
                    "</tr>";
                tableDeploymentSite.row.add($(row)[0]).draw();
                tableAssignDeploymentSite.row('#id' + deploymentsiteid).remove().draw(false);
            },
        });
    });



});