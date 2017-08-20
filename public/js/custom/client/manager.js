$(document).ready(function() {
    var managerid;
    var table = $('#tblManager').DataTable({
        "aoColumns": [
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    //reset the modal when hide
    $('#modalManager').on('hide.bs.modal', function() {
        $('#formManager').trigger('reset');
        $('#formManager').parsley().reset();
    });

    //display modal for new task
    $('#btnNew').click(function() {
        $('#btnSave').val("New");
        $('#modalTitle').text("New Manager");
        $('#modalManager').modal('show');
    });

    //display modal for update task
    $('#requirement-list').on('click', '#btnUpdate', function() { 
        managerid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/manager/one",
            data: { inputManagerid: managerid, },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#inputRequirement').val(data.name);
                $('#inputRequirementDescription').val(data.description);
                $('#btnSave').val("Update");
                $('#modalTitle').text("Update Applicant Requirement");
                $('#modalRequirement').modal('show');
            },
        });
    });

    //create new task / update existing task
    $('#btnSave').click(function(e) {
        if($('#formManager').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            //used to determine the http verb to use
            if ($('#btnSave').val() == "New") {
                var my_url = "/client/manager/new";
                var formData = {
                    inputUsername: $('#username').val(),
                    inputPassword: $('#password').val(),
                    inputLastname: $('#inputLastname').val(),
                    inputFirstname: $('#inputFirstname').val(),
                    inputMiddlename: $('#inputMiddlename').val(),
                }
            } else {
                var my_url = "/client/manager/update";
                var formData = {
                    inputManagerID: managerid,
                    inputUsername: $('#username').val(),
                    inputPassword: $('#password').val(),
                    inputLastname: $('#inputLastname').val(),
                    inputFirstname: $('#inputFirstname').val(),
                    inputMiddlename: $('#inputMiddlename').val(),
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
                        data.middlename = '';
                    }

                    if ($('#btnSave').val() == "New") {
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
                    } else {
                        var data = [
                            data.lastname + ", " + data.firstname + " " + data.middlename,
                            data.account.username,
                            "<button class='btn btn-primary btn-xs' id='btnAssign' value="+data.managerid+">Assign</button> " +
                            "<button class='btn btn-warning btn-xs' id='btnUpdate' value="+data.managerid+">Update</button> " +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.managerid+">Remove</button>",
                        ];
                        table.row('#id' + managerid).data(data).draw(false);
                    }

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



});