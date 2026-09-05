var TableDatatablesButtons = function () {

    var initTable3 = function () {
        var table = $('#deletedcustomersdata');

        var oTable = table.dataTable({
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },
            buttons: [
                { extend: 'print', className: 'btn dark btn-outline', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] } },
                { extend: 'copy', className: 'btn red btn-outline' },
                { extend: 'pdf', className: 'btn green btn-outline', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] } },
                { extend: 'excel', className: 'btn yellow btn-outline ', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ], format: { body: function(data) { if (!data) return ''; var d = document.createElement('div'); d.innerHTML = data; return (d.textContent || d.innerText || '').trim().replace(/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/g, ''); } } } },
                { extend: 'csv', className: 'btn purple btn-outline ', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ] } },
                { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'},
                { text: 'Reload', className: 'btn default', action: function ( e, dt, node, config ) { dt.ajax.reload(); } }
            ],
            "ajax": {
                "url": "../_data/deletedcustomersdata.php",
            },
            responsive: false,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ],
            "order": [
                [0, 'asc']
            ],
            "lengthMenu": [
                [50, 100, 500, -1],
                [50, 100, 500, "All"]
            ],
            "pageLength": 50,
            "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });

        $('#deletedcustomersdata_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.DataTable().button(action).trigger();
        });
    };

    return {
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable3();
        }
    };
}();

jQuery(document).ready(function() {
    TableDatatablesButtons.init();
});
