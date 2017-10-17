$(document).ready(function() {
    var requireno, clientqualificationid, deploymentsiteid;
	var table = $('#tblDeploymentSite').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'desc']]).draw();
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

    //reset the modal deploy when hide
    $('#modalDeploy').on('hide.bs.modal', function() {
        tablePool.clear().draw();
        tableDeploy.clear().draw();
        $('#clientqualification-list').empty();
        $('#clientqualification-number').empty();
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

    //change of client qualification
    $('#clientqualification-number').on('change', function() {
        clientqualificationid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/clientqualification/one",
            data: { inputClientQualificationID: clientqualificationid, },
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

    //deploy sg
	$('#deploy-list').on('click', '#btnDeploy', function(e) {
        e.preventDefault();
        deploymentsiteid = $(this).val();
        $('#btnDeploySave').val(0);

        getSecurityGuard();

		$('#modalDeploy').modal('show');
	});

    //update of sent sg
    $('#deploy-list').on('click', '#btnUpdateDeploy', function(e) {
        e.preventDefault();
        deploymentsiteid = $(this).val();
        $('#btnDeploySave').val(1);

        getSecurityGuard();

        $('#modalDeploy').modal('show');
    });

    $('#btnDeploySave').click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        //if (requireno <= tableDeploy.rows().count()) {
            $('#modalDeploy').loading({
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
                inputDeploymentSiteID: deploymentsiteid,
                inputType: $('#btnDeploySave').val(),
                formData: formData,
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/deploysecurityguard",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        data.sitename,
                        data.location + ", " + data.city + ", " + data.province,
                        "PENDING APPROVAL",
                        "<button class='btn btn-primary btn-xs' id='btnUpdateDeploy' value="+data.deploymentsiteid+">Update</button>",
                    ];
                    table.row('#id' + deploymentsiteid).data(dt).draw(false);

                    $('#modalDeploy').modal('hide');
                    $('#modalDeploy').loading('stop');
                    toastr.success("SAVE SUCCESSFULLY");
                }
            });
        // } else {
        //     toastr.error("YOU NEED " + (requireno - tableDeploy.rows().count()) + " MORE SECURITY GUARD");
        // }
    });

    function getSecurityGuard() {
        $.ajax({
            type: "GET",
            url: "/admin/transaction/deploysecurityguard/clientqualification",
            data: { inputDeploymentSiteID: deploymentsiteid },
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
                    url: "/admin/transaction/deploysecurityguard/securityguard/percent",
                    data: { inputClientQualificationID: clientqualificationid, },
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

