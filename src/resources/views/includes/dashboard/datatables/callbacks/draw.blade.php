<script>
    function() {
        let table = this;
        let dTColumns = dataTable.collection;

        let optionsNormal = ['', '1', '2', '3'];
        let optionsDeleted = ['4'];
        let bulkNormal = ['bulk_delete'];
        let bulkDeleted = ['bulk_restore', 'bulk_force_delete'];

        let statusElement = $('#status.datatable-input');
        let statusValue = $(statusElement).val();

        let bulkActionElement = $('#bulk_action_select');
        let bulkActionValue = $(bulkActionElement).val();

        let optionBulkRestore = $('#bulk_action_select').find('.option_bulk_restore');
        let optionBulkDelete = $('#bulk_action_select').find('.option_bulk_delete');
        let optionBulkForceDelete = $('#bulk_action_select').find('.option_bulk_force_delete');

        if (optionsNormal.includes(statusValue)) {
            if (!bulkNormal.includes(bulkActionValue)) {
                $(bulkActionElement).val('');
            }

            if (optionBulkDelete) $(optionBulkDelete).show();
            if (optionBulkRestore) $(optionBulkRestore).hide();
            if (optionBulkForceDelete) $(optionBulkForceDelete).hide();
        }

        if (optionsDeleted.includes(statusValue)) {
            if (!bulkDeleted.includes(bulkActionValue)) {
                $(bulkActionElement).val('');
            }

            if (optionBulkDelete) $(optionBulkDelete).hide();
            if (optionBulkRestore) $(optionBulkRestore).show();
            if (optionBulkForceDelete) $(optionBulkForceDelete).show();
        }

        $(bulkActionElement).selectpicker('refresh');
    }
</script>
