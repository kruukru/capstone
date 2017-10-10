$(document).ready(function() {
    //security guard score
    var tableSecurityGuardScore = $('#tblSecurityGuardScore').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
        ]
    });
    tableSecurityGuardScore.order([[3, 'desc']]).draw();

    //security guard vacant
    var tableSecurityGuardVacant = $('#tblSecurityGuardVacant').DataTable({
        "aoColumns": [
            null,
            null,
        ]
    });
    tableSecurityGuardVacant.order([[1, 'desc']]).draw();

    //security guard commend
    var tableSecurityGuardCommend = $('#tblSecurityGuardCommend').DataTable({
        "aoColumns": [
            null,
            null,
        ]
    });
    tableSecurityGuardCommend.order([[1, 'desc']]).draw();

    //security guard violation
    var tableSecurityGuardViolation = $('#tblSecurityGuardViolation').DataTable({
        "aoColumns": [
            null,
            null,
        ]
    });
    tableSecurityGuardViolation.order([[1, 'desc']]).draw();

    //client contract
    var tableClientContract = $('#tblClientContract').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
        ]
    });
    tableClientContract.order([[3, 'desc']]).draw();

    //deploymentsite area
    var tableDeploymentSiteArea = $('#tblDeploymentSiteArea').DataTable({
        "aoColumns": [
            null,
            null,
            null,
        ]
    });
    tableDeploymentSiteArea.order([[2, 'desc']]).draw();



});