$(document).ready(function() {
    var startDateFirearm = moment();
    var endDateFirearm = moment().add(1, 'months');

    $('#btnDateRangeFirearm span').html(startDateFirearm.format('MMMM D, YYYY') + ' - ' + endDateFirearm.format('MMMM D, YYYY'));
    $('#firearmstartdate').val(startDateFirearm.format('YYYY-MM-DD'));
    $('#firearmenddate').val(endDateFirearm.format('YYYY-MM-DD'));

    $('#btnDateRangeFirearm').daterangepicker({
        startDate: startDateFirearm,
        endDate: endDateFirearm,
        ranges: {
            'None': [null, null],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'After 1 Month': [moment(), moment().add(1, 'months')],
            'After 2 Months': [moment(), moment().add(2, 'months')],
            'After 1 Year': [moment(), moment().add(1, 'years')],
            'After 2 Years': [moment(), moment().add(2, 'years')],
            'After 5 Years': [moment(), moment().add(5, 'years')]
        }
    }, function(start, end) {
        startDateFirearm = start; endDateFirearm = end;
        if (startDateFirearm._d == "Invalid Date" && endDateFirearm._d == "Invalid Date") {
            startDateFirearm = null; endDateFirearm = null;
            $('#firearmstartdate').val(null);
            $('#firearmenddate').val(null);
            $('#btnDateRangeFirearm span').html('None');
        } else {
            $('#firearmstartdate').val(startDateFirearm.format('YYYY-MM-DD'));
            $('#firearmenddate').val(endDateFirearm.format('YYYY-MM-DD'));
            $('#btnDateRangeFirearm span').html(startDateFirearm.format('MMMM D, YYYY') + ' - ' + endDateFirearm.format('MMMM D, YYYY'));
        }
    });

    var startDateLicense = moment();
    var endDateLicense = moment().add(1, 'months');

    $('#btnDateRangeSecurity span').html(startDateLicense.format('MMMM D, YYYY') + ' - ' + endDateLicense.format('MMMM D, YYYY'));
    $('#securitystartdate').val(startDateLicense.format('YYYY-MM-DD'));
    $('#securityenddate').val(endDateLicense.format('YYYY-MM-DD'));

    $('#btnDateRangeSecurity').daterangepicker({
        startDate: startDateLicense,
        endDate: endDateLicense,
        ranges: {
            'None': [null, null],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'After 1 Month': [moment(), moment().add(1, 'months')],
            'After 2 Months': [moment(), moment().add(2, 'months')],
            'After 1 Year': [moment(), moment().add(1, 'years')],
            'After 2 Years': [moment(), moment().add(2, 'years')],
            'After 5 Years': [moment(), moment().add(5, 'years')]
        }
    }, function(start, end) {
        startDateLicense = start; endDateLicense = end;
        if (startDateLicense._d == "Invalid Date" && endDateLicense._d == "Invalid Date") {
            startDateLicense = null; endDateLicense = null;
            $('#securitystartdate').val(null);
            $('#securityenddate').val(null);
            $('#btnDateRangeSecurity span').html('None');
        } else {
            $('#securitystartdate').val(startDateLicense.format('YYYY-MM-DD'));
            $('#securityenddate').val(endDateLicense.format('YYYY-MM-DD'));
            $('#btnDateRangeSecurity span').html(startDateLicense.format('MMMM D, YYYY') + ' - ' + endDateLicense.format('MMMM D, YYYY'));
        }
    });



});