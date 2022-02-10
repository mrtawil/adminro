const initDateRangePicker2 = (key) => {
    let dateRangePickerKey = `#kt_daterangepicker_${key}`;
    $(dateRangePickerKey).daterangepicker({
        buttonClasses: ' btn',
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',
        autoUpdateInput: false,

        startDate: moment("1970-01-01"),
        endDate: moment(),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(1, 'week'), moment()],
            'Last 30 Days': [moment().subtract(1, 'month'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month').add(1, 'days')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month').add(1, 'days')],
            'All Time': [moment("1970-01-01"), moment()]
        }
    });

    $(`${dateRangePickerKey}`).on('apply.daterangepicker', function (ev, picker) {
        $(`${dateRangePickerKey} .form-control`).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
    });
}
