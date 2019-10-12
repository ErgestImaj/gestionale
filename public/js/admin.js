var BASE_URL = window.location.protocol + "//" + window.location.host + "/";
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
        "ajax": BASE_URL + 'amministrazione/admins/index',
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
$(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();
    let actionurl = $(this).data('action');
    let msg = $(this).data('content');
    swal({
        title: "Sei sicuro?",
        text: msg,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete){
            axios.delete(actionurl)
                .then(response => {
                  if (response.data.status == 'success'){
                      table.ajax.reload();
                      swal("Good job!", response.data.msg, "success");
                  }
                })
                .catch(err => {
                    if (err.response.status==200) {
                        swal("Good job!", err.response.data.msg, "success");
                        table.ajax.reload();
                    } else {
                        swal("Woops!", "Qualcosa è andato storto!", "error");
                        swal.stopLoading();
                        swal.close();
                    }
                })
        }
        swal.stopLoading();
        swal.close();

    });
});
$(document).on('click', '.update-btn', function (e) {
    e.preventDefault();
     let actionurl = $(this).data('action');
        axios.patch(actionurl)
            .then(response => {
              if (response.data.status == 'success'){
                  table.ajax.reload();
                  swal("Good job!", response.data.msg, "success");
              }
            })
            .catch(err => {
                if (err.response.status==200) {
                    swal("Good job!", err.response.data.msg, "success");
                    table.ajax.reload();
                } else {
                    swal("Woops!", "Qualcosa è andato storto!", "error");
                    swal.stopLoading();
                    swal.close();
                }
            })

});

$(document).on('click', '.post-action', function (e) {
    e.preventDefault();
     let actionurl = $(this).data('action');
     let msg = $(this).data('content');
    swal({
        title: "Sei sicuro?",
        text: msg,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((val)=>{

       if (val){
           axios.post(actionurl)
               .then(response => {
                   if (response.data.status == 'success'){
                       table.ajax.reload();
                       swal("Good job!", response.data.msg, "success");
                   }
               })
               .catch(err => {
                   if (err.response.status==200) {
                       swal("Good job!", err.response.data.msg, "success");
                       table.ajax.reload();
                   } else {
                       swal("Woops!", "Qualcosa è andato storto!", "error");
                       swal.stopLoading();
                       swal.close();
                   }
               })
       }

    })
});

$(document).on('click', '.sender-email', function (e) {
    e.preventDefault();
    let actionurl = $(this).data('action');
    $('#email-settings').toggleClass('open')
    $('#sendemailform').attr('action',actionurl);
});

