var table = $('#order-listing')
    .on('preXhr.dt', function (e, settings, data) {
        data.visible = $('#visibleid').val();
    })
    .DataTable({
        "aLengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        "language": {search: ""},
        oLanguage: {
            "sProcessing": "<i class=\"fa fa-spinner fa-spin fa-3x fa-fw\"></i><span class=\"sr-only\">Loading...</span> '",
        },
        "processing": true,
        "serverSide": true,
        "ajax": actionUrl,
        "columns": [
            {"data": "DT_RowIndex","orderable":false},
            {"data": "subject"},
            {"data": "description"},
            {"data": "target"},
            {"data": "exclude"},
            {"data": "created"},
            {"data": "created_by"},
            {"data": "actions", "orderable":false},
            {"data": "id", "visible": false,"orderable":false},
        ],
        initComplete: function(){
            $("#filter-category select").on( 'change', function () {
                var val = $(this).val()
                table.column(2)
                    .search( val ? '^'+val+'$' : '', true, false )
                    .draw();

            });
        },
    });

