<script>
    function() {
        let table = this;
        let dTColumns = dataTable.collection;

        $('#kt_search').on('click', function(e) {
            e.preventDefault();

            var params = {};
            $('.datatable-input').each(function() {
                var i = $(this).data('col-index');
                if (params[i]) {
                    params[i] += '|' + $(this).val();
                } else {
                    params[i] = $(this).val();
                }
            });

            $.each(params, function(i, val) {
                table.api().column(i).search(val ? val : '', false, false);
            });

            table.api().draw();
        });

        $('#kt_reset').on('click', function(e) {
            e.preventDefault();

            $('.datatable-input').each(function() {
                $(this).val('');
                $(this).selectpicker('refresh');
            });

            table.api().button('.buttons-reset').trigger();
        });

        $('#export-print').on('click', () => {
            table.api().button('.buttons-print').trigger();
        });

        $('#export-copy').on('click', () => {
            table.api().button('.buttons-copy').trigger();
        });

        $('#export-excel').on('click', () => {
            table.api().button('.buttons-excel').trigger();
        });

        $('#export-csv').on('click', () => {
            table.api().button('.buttons-csv').trigger();
        });

        $('#export-pdf').on('click', () => {
            table.api().button('.buttons-pdf').trigger();
        });

        $('#search-colvis').on('click', () => {
            table.api().button('.buttons-colvis').trigger();
        });

        table.api().buttons().container().appendTo($('#buttons-container'));

        dTColumns.forEach(function(column, i) {
            if (column.type == 'date_range') {
                initDateRangePicker2(column.data);
            }
        });

        $('th.datatable-checkbox').html(
            $(document.createElement('label')).prop({
                for: 'checkbox-all',
                class: 'checkbox checkbox-single',
            })
            .append($(document.createElement('input')).prop({
                id: 'checkbox-all',
                type: 'checkbox',
                class: 'checkable',
            }))
            .append(document.createElement('span'))
        );

        $('#checkbox-all').on('click', (e) => {
            let value = e.target.value;

            $('.checkable').each(function() {
                $(this).prop('checked', value);
            });

            if (value) {
                e.target.value = '';
            } else {
                e.target.value = 'on';
            }
        });

        $('.bulk-action-container').append($('#bulk_action_form'));
        $('#bulk_action_form').show();
    }
</script>
