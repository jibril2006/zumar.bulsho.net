var TableDatatablesButtons = function () {

    var initTable = function () {
        var table = $('#recentpaymentsdata');

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
            "processing": true,
            "serverSide": true,
            "autoWidth": true,
            "scrollX": true,
            "stripeClasses": ['odd', 'even'],
            buttons: [
                { extend: 'print', className: 'btn dark btn-outline', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
                { extend: 'copy', className: 'btn red btn-outline' },
                { extend: 'pdf', className: 'btn green btn-outline', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
                { extend: 'excel', className: 'btn yellow btn-outline ', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6], format: { body: function(data) { if (!data) return ''; var d = document.createElement('div'); d.innerHTML = data; return (d.textContent || d.innerText || '').trim().replace(/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/g, ''); } } } },
                { extend: 'csv', className: 'btn purple btn-outline ', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
                { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns' }
            ],
            "ajax": {
                "url": "../_data/recentpaymentsdata.php"
            },
            responsive: false,
            columnDefs: [
                { width: "8%", targets: 0, className: "text-end" },
                { width: "7%", targets: 1, className: "text-end" },
                { width: "28%", targets: 2, className: "km-col-name" },
                { width: "10%", targets: 3 },
                { width: "12%", targets: 4 },
                { width: "11%", targets: 5, className: "text-end km-col-num" },
                { width: "9%", targets: 6, className: "text-end km-col-num" },
                { width: "15%", targets: 7, orderable: false, className: "km-col-actions" },
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ],
            "order": [[0, 'desc']],
            "lengthMenu": [
                [25, 50, 100, 250],
                [25, 50, 100, 250]
            ],
            "pageLength": 50,
            "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#recentpaymentsdata_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.DataTable().button(action).trigger();
        });
    };

    return {
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable();
        }
    };
}();

jQuery(document).ready(function() {
    TableDatatablesButtons.init();
});
