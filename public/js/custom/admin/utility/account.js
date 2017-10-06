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

    //update the picture in the img source
    $("#picture").change(function() {
        readURL(this);
    });

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
    //validate update username
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
    //validate update password
    $('.input-updatepassword').on('keyup', function() {
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
    $('.input-updateconfirmpassword').on('keyup', function() {
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

    //modal account clear
    function modalAccountClear() {
        $('#formAccount').trigger('reset');
        $('#formAccount').parsley().reset();
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

        $('#modalAccount').modal('show');
    });

    //update account
    $('#account-list').on('click', '#btnUpdate', function() {
        $('#formAdminInformation').trigger('reset');
        $('#formAdminInformation').parsley().reset();
        $('#formAccountInformation').trigger('reset');
        $('#formAccountInformation').parsley().reset();
        accountid = $(this).val();

        if (accountid == 1) {
            $('#updateposition').prop('disabled', true);
        } else {
            $('#updateposition').prop('disabled', false);
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

                $('#pictureview').attr('src', '/admin/' + data.admin.picture);
                $('#updatelastname').val(data.admin.lastname);
                $('#updatefirstname').val(data.admin.firstname);
                $('#updatemiddlename').val(data.admin.middlename);
                $('#updateposition').val(data.admin.position);
            },
        });

        $('#modalUpdateAccount').modal('show');
    });

    $('#btnSaveAdminInformation').click(function(e) {
        if ($('#formAdminInformation').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $('#modalUpdateAccount').loading({
                message: "SAVING..."
            });

            var formData = {
                inputAccountID: accountid,
                inputLastName: $('#updatelastname').val(),
                inputFirstName: $('#updatefirstname').val(),
                inputMiddleName: $('#updatemiddlename').val(),
                inputPosition: $('#updateposition').val()
            };

            $.ajax({
                type: "POST",
                url: "/admin/utility/account/admininformation",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (data.middlename == null) {
                        data.middlename = "";
                    }

                    var dt = [
                        data.lastname+", "+data.firstname+" "+data.middlename,
                        table.cell('#id'+accountid, 1).data(),
                        data.position,
                        table.cell('#id'+accountid, 3).data()
                    ];
                    table.row('#id'+accountid).data(dt).draw(false);

                    $('#formAdminInformation').parsley().reset();
                    $('#modalUpdateAccount').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalUpdateAccount').loading('stop');
                    if (data.responseJSON == "SAME USERNAME") {
                        toastr.error("USERNAME ALREADY EXIST");
                    }
                }
            });
        }
    });

    $('#btnSaveAccountInformation').click(function(e) {
        if ($('#formAccountInformation').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            if ($('#updatepassword').val() != $('#updateconfirmpassword').val()) {
                toastr.error("PASSWORD MISMATCH");
                return;
            }

            $('#modalUpdateAccount').loading({
                message: "SAVING..."
            });

            var formData = {
                inputAccountID: accountid,
                inputUsername: $('#updateusername').val(),
                inputPassword: $('#updatepassword').val()
            };

            $.ajax({
                type: "POST",
                url: "/admin/utility/account/accountinformation",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        table.cell('#id'+accountid, 0).data(),
                        data.username,
                        table.cell('#id'+accountid, 2).data(),
                        table.cell('#id'+accountid, 3).data()
                    ];
                    table.row('#id'+accountid).data(dt).draw(false);

                    $('#formAccountInformation').parsley().reset();
                    $('#modalUpdateAccount').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalUpdateAccount').loading('stop');
                    if (data.responseJSON == "SAME USERNAME") {
                        toastr.error("USERNAME ALREADY EXIST");
                    }
                }
            });
        }
    });

    $('#btnSaveImage').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var ext = $('#picture').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            toastr.error("INVALID IMAGE INPUT");
            return;
        }
        
        $('#modalUpdateAccount').loading({
            message: "SAVING..."
        });

        var image = $('#picture')[0].files[0];
        var form = new FormData();

        form.append('accountid', accountid);
        form.append('image', image);

        $.ajax({
            type: "POST",
            url: "/admin/utility/account/profileimage",
            data: form,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {

                $('#formImage').trigger('reset');
                $('#modalUpdateAccount').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            }
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

            var formData = {
                inputLastName: $('#lastname').val(),
                inputFirstName: $('#firstname').val(),
                inputMiddleName: $('#middlename').val(),
                inputPosition: $('#position').val(),
                inputUsername: $('#username').val(),
                inputPassword: $('#password').val()
            }

            $.ajax({
                type: "POST",
                url: "/admin/utility/account/new",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (data.middlename == null) {
                        data.middlename = "";
                    }

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

                    // var button = data.account.accountid == 1 ? "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.account.accountid+">Update</button>" :
                    //     "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.account.accountid+">Update</button> " +
                    //     "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.account.accountid+">Remove</button>";
                    // var dt = [
                    //     data.lastname + ", " + data.firstname + " " + data.middlename,
                    //     data.account.username,
                    //     data.position,
                    //     button,
                    // ];
                    // table.row('#id' + accountid).data(dt).draw(false);

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

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#pictureview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        $('#pictureview').attr('src', '/images/default.png');
    }
}