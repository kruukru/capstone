$(document).ready(function() {
    var accountid;
    var table = $('#tblAccount').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    //validate username
    $('#username').on('focusout', function() {
        if ($(this).val() != "") {
            $('#username').parsley().removeError('forcederror', {updateClass: true});
            $.ajax({
                type: "GET",
                url: "/json/validate-username",
                data: { inputUsername: $('#username').val() },
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

    //modal account clear
    function modalAccountClear() {
        $('#formAccount').trigger('reset');
        $('#formAccount').parsley().reset();
        $('#position').prop('disabled', false);
    }

    //modal remove
    $('#account-list').on('click', '#btnRemove', function() {
        accountid = $(this).val();

        $('#modalAccountRemove').modal('show');
    });

    //confirm remove
    $('#btnRemoveConfirm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#modalAccountRemove').loading({
            message: "REMOVING...",
        });

        $.ajax({
            type: "POST",
            url: "/admin/utility/account/remove",
            data: { inputAccountID: accountid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                table.row('#id' + accountid).remove().draw(false);

                $('#modalAccountRemove').modal('hide');
                $('#modalAccountRemove').loading('stop');
                toastr.success("REMOVE SUCCESSFUL");
            },
            error: function(data) {
                console.log(data);

                $('#modalAccountRemove').loading('stop');
                if (data.responseJSON == "CANNOT REMOVE") {
                    toastr.error("CANNOT REMOVE WHILE BEING USED");
                }
            }
        });
    });

    //new account
    $('#btnNew').click(function() {
        modalAccountClear();

        $('#btnSave').val("New");
        $('#modalTitle').text("New Account");
        $('#modalAccount').modal('show');
    });

    //update account
    $('#account-list').on('click', '#btnUpdate', function() {
        modalAccountClear();
        accountid = $(this).val();

        if (accountid == 1) {
            $('#position').prop('disabled', true);
        }

        $.ajax({
            type: "GET",
            url: "/json/account/one",
            data: { inputAccountID: accountid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.admin.middlename == null) {
                    data.admin.middlename = "";
                }

                $('#lastname').val(data.admin.lastname);
                $('#firstname').val(data.admin.firstname);
                $('#middlename').val(data.admin.middlename);
                $('#username').val(data.username);
                $('#position').val(data.admin.position);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Account");
                $('#modalAccount').modal('show');
            },
        });
    });

    //save account new / update
    $('#btnSave').click(function(e) {
        if ($('#formAccount').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            if ($('#password').val() != $('#confirmpassword').val()) {
                toastr.error("PASSWORD MISMATCH");
                return;
            }

            $('#modalAccount').loading({
                message: "SAVING..."
            });

            if ($('#btnSave').val() == "New") {
                var my_url = "/admin/utility/account/new";
                var formData = {
                    inputLastName: $('#lastname').val(),
                    inputFirstName: $('#firstname').val(),
                    inputMiddleName: $('#middlename').val(),
                    inputPosition: $('#position').val(),
                    inputUsername: $('#username').val(),
                    inputPassword: $('#password').val()
                }
            } else {
                var my_url = "/admin/utility/account/update";
                var formData = {
                    inputAccountID: accountid,
                    inputLastName: $('#lastname').val(),
                    inputFirstName: $('#firstname').val(),
                    inputMiddleName: $('#middlename').val(),
                    inputPosition: $('#position').val(),
                    inputUsername: $('#username').val(),
                    inputPassword: $('#password').val(),
                }
            }

            $.ajax({
                type: "POST",
                url: my_url,
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (data.middlename == null) {
                        data.middlename = "";
                    }

                    if ($('#btnSave').val() == "New") {
                        var row = "<tr id=id" + data.account.accountid + ">" +
                            "<td>" + data.lastname + ", " + data.firstname + " " + data.middlename + "</td>" +
                            "<td>" + data.account.username + "</td>" +
                            "<td>" + data.position + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.account.accountid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.account.accountid+">Remove</button>" +
                            "</td>" +
                            "</tr>";
                        table.row.add($(row)[0]).draw();
                    } else {
                        var button = data.account.accountid == 1 ? "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.account.accountid+">Update</button>" :
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.account.accountid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.account.accountid+">Remove</button>";
                        var dt = [
                            data.lastname + ", " + data.firstname + " " + data.middlename,
                            data.account.username,
                            data.position,
                            button,
                        ];
                        table.row('#id' + accountid).data(dt).draw(false);
                    }

                    $('#modalAccount').modal('hide');
                    $('#modalAccount').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalAccount').loading('stop');
                    if (data.responseJSON == "SAME USERNAME") {
                        toastr.error("USERNAME ALREADY EXIST");
                    }
                }
            });
        }
    });



});