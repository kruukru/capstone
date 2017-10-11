$(document).ready(function() {
    var startDate = moment();
    var endDate = moment().add(1, 'months');

    $('#btnDateRangeFirearm span').html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
    $('#firearmstartdate').val(startDate.format('YYYY-MM-DD'));
    $('#firearmenddate').val(endDate.format('YYYY-MM-DD'));
    $('#btnDateRangeFirearm').daterangepicker({
        startDate: startDate,
        endDate: endDate,
        ranges: {
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'After 1 Month': [moment(), moment().add(1, 'months')],
            'After 2 Months': [moment(), moment().add(2, 'months')],
            'After 1 Year': [moment(), moment().add(1, 'years')],
            'After 2 Years': [moment(), moment().add(2, 'years')],
            'After 5 Years': [moment(), moment().add(5, 'years')]
        }
    }, function(start, end) {
        startDate = start; endDate = end;
        $('#firearmstartdate').val(startDate.format('YYYY-MM-DD'));
        $('#firearmenddate').val(endDate.format('YYYY-MM-DD'));
        $('#btnDateRangeFirearm span').html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
    });



});