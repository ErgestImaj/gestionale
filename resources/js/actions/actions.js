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
            }else if(response.data.status == 'unauthorized'){
                swal("Woops!",response.data.msg, "error");
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
