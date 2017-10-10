$(document).ready(function() {
    var startDate = moment();
    var endDate = moment().add(1, 'months');

    $('#btnDateRangeFirearm span').html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
    $('#btnDateRangeFirearm').daterangepicker({
        startDate: startDate,
        endDate: endDate,
        ranges: {
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'After 1 Month': [moment(), moment().add(1, 'months')],
           'After 2 Months': [moment(), moment().add(2, 'months')]
        }
    }, function(start, end) {
        startDate = start; endDate = end;
        $('#btnDateRangeFirearm span').html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
    });

    $('#btntest').click(function() {
        console.log(startDate.format('YYYY-MM-DD') + " - " + endDate.format('YYYY-MM-DD'));
    });

});