$(document).ready(function() {
	var tableLicense = $('#tblLicense').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    tableLicense.order([[2, 'asc']]).draw();
    var tableRequest = $('#tblRequest').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    tableRequest.order([[0, 'asc']]).draw();

	var csgstatus = $('#sgstatus');
	var csgpriority = $('#sgpriority');

	$.ajax({
        type: "GET",
        url: "/admin/hr/dashboard",
        dataType: "json",
        success: function(data) {
            console.log(data);

            var chartsgstatus = new Chart(csgstatus, {
			    type: 'pie',
			    data: {
			        labels: ["DEPLOYED", "IN POOLING", "APPLICATION"],
			        datasets: [{
			            data: data.status,
			            backgroundColor: [
			                'rgba(255, 99, 132, .75)',
			                'rgba(54, 162, 235, .75)',
			                'rgba(255, 206, 86, .75)',
			            ],
			        }]
			    }
			});

			var chartsgpriority = new Chart(csgpriority, {
			    type: 'pie',
			    data: {
			        labels: ["MOST PRIORITY", "LEAST PRIORITY"],
			        datasets: [{
			            data: data.priority,
			            backgroundColor: [
			                'rgba(255, 99, 132, .75)',
			                'rgba(54, 162, 235, .75)'
			            ],
			        }]
			    }
			});
        }
    });



});