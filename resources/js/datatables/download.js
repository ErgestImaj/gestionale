var table = $('#document-list')
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
        "ajax": window.Laravel.baseURL + '/amministrazione/documents',
        "columns": [
            {"data": "DT_RowIndex","orderable":false},
            {"data": "category"},
            {"data": "name"},
            {"data": "created_by"},
            {"data": "updated_by"},
            {"data": "actions", "orderable":false},
            {"data": "id", "visible": false,"orderable":false},
        ],
    });
