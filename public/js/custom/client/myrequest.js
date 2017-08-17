$(document).ready(function() {
	$('#btnPersonnelRequest').click(function() {
		$('#modalPersonnel').modal('show');
	});

	$('#btnRepairRequest').click(function() {
		$('#modalRepair').modal('show');
	});

	$('#btnRestockRequest').click(function() {
		$('#modalRestock').modal('show');
	});
});