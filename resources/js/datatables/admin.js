var table = $('#order-listing')
    .on('preXhr.dt', function (e, settings, data) {
        data.visible = $('#visibleid').val();
    })
    .DataTable({
        dom: 'Bfrtip',
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
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
$('#order-listing').each(function () {
    var datatable = $(this);
    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
    var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
    search_input.attr('placeholder', 'Search');
    search_input.removeClass('form-control-sm');
    // LENGTH - Inline-Form control
    var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
    length_sel.removeClass('form-control-sm');
});


