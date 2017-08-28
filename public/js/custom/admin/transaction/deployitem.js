$(document).ready(function() {
	var deploymentsiteid, itemid, qtyavailable, qtyinput, name, itemtype, countFirearm = 0;
	var firearmsave = [];
	var table = $('#tblDeploymentSite').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();
    var tableSecurityGuard = $('#tblSecurityGuard').DataTable({
        "aoColumns": [
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

    $('#modalDeploy').on('hide.bs.modal', function() {
    	firearmsave = [];
    	tableSecurityGuard.clear().draw();
    	tableInventory.clear().draw();
    	tableDeployItem.clear().draw();
    });
    $('#modalFirearm').on('hide.bs.modal', function() {
    	countFirearm = 0;
    	tableFirearm.clear().draw();
    	tableDeployFirearm.clear().draw();
    });

	$('#deploy-list').on('click', '#btnDeploy', function() {
		deploymentsiteid = $(this).val();

    	$.ajax({
            type: "GET",
            url: "/admin/transaction/deployitem/inventory/securityguard",
            data: { inputDeploymentSiteID: deploymentsiteid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data.applicant, function(index, value) {
                	if (data.middlename === null) {
                        data.middlename = '';
                    }

                	var row = "<tr id=id" + value.applicantid + ">" +
	                    "<td>" + value.lastname + ", " + value.firstname + ", " + value.middlename + "</td>" +
	                    "</tr>";
	                tableSecurityGuard.row.add($(row)[0]).draw();
                });

                $.each(data.item, function(index, value) {
                	var row = "<tr id=id" + value.itemid + ">" +
	                    "<td id='name'>" + value.name + "</td>" +
	                    "<td id='itemtype'>" + value.item_type.name + "</td>" +
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

				$('#modalDeploy').modal('show');
            },
        });
	});

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
			            url: "/admin/transaction/deployitem/firearm",
			            data: { inputItemID: itemid },
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
	$('#btnSave').click(function(e) {
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
				inputDeploymentSiteID: deploymentsiteid,
				inputItemList: formData,
				inputFirearmList: firearmsave,
			};

			$.ajax({
	            type: "POST",
	            url: "/admin/transaction/deployitem",
	            data: formData,
	            dataType: "json",
	            success: function(data) {
	                console.log(data);

					var dt = [
                        data.sitename,
                        data.location + " " + data.city + " " + data.province,
                        "PENDING RECEIVE",
                        "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnUpdate' value='"+data.deploymentsiteid+"'>Update</button>" +
                        "</td>",
                    ];
                    table.row('#id' + deploymentsiteid).data(dt).draw(false);

					$('#modalDeploy').modal('hide');
	                toastr.success("SAVE SUCCESSFUL");
	            },
	        });
		} else {
			toastr.error("NO DEPLOY ITEM");
		}
	});



});