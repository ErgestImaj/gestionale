var table = $('#order-listing')
    .on('preXhr.dt', function (e, settings, data) {
        data.visible = $('#visibleid').val();
    })
    .DataTable({
        "aLengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        "iDisplayLength": 10,
        "language": {search: ""},
        oLanguage: {
            "sProcessing": "<i class=\"fa fa-spinner fa-spin fa-3x fa-fw\"></i><span class=\"sr-only\">Loading...</span> '",
        },
        "processing": true,
        "serverSide": true,
        "ajax": window.Laravel.baseURL + '/amministrazione/admins/index',
        "columns": [
            {"data": "DT_RowIndex","orderable":false},
            {"data": "username"},
            {"data": "first_name"},
            {"data": "last_name"},
            {"data": "email"},
            {"data": "status"},
            {"data": "last_login"},
            {"data": "created"},
            {"data": "actions", "orderable":false},
            {"data": "id", "visible": false,"orderable":false},
        ]
    });



