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
		if (willDelete) {
			axios.delete(actionurl)
				.then(response => {

					if (response.data.status == 'success') {
						if (typeof table !== 'undefined') {
							table.ajax.reload();
						}
						swal("Good job!", response.data.msg, "success");
						if (typeof table == 'undefined') {
							setTimeout(function () {
								location.reload();
							}, 1500)
						}
					} else if (response.data.status == 'warning') {
						swal({
							title: "Whoops!",
							text: response.data.msg,
							icon: "warning",
							dangerMode: true,
						})
					}
				})
				.catch(err => {
					if (err.response.status == 200) {
						swal("Good job!", err.response.data.msg, "success");
						table.ajax.reload();
						location.reload();
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
			if (response.data.status == 'success') {
				swal("Good job!", response.data.msg, "success");
				setTimeout(function () {
					location.reload();
				}, 1500)
			} else if (response.data.status == 'unauthorized') {
				swal("Woops!", response.data.msg, "error");
			} else {
				swal("Woops!", "Qualcosa è andato storto!", "error");
				swal.stopLoading();
				swal.close();
			}

		})
		.catch(err => {
			if (err.response.status == 200) {
				swal("Good job!", err.response.data.msg, "success");
				setTimeout(function () {
					location.reload();
				}, 1500)
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
	}).then((val) => {
		if (val) {
			axios.post(actionurl)
				.then(response => {
					if (response.data.status == 'success') {
						table.ajax.reload();
						swal("Good job!", response.data.msg, "success");
					}
				})
				.catch(err => {
					if (err.response.status == 200) {
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
	$('#sendemailform').attr('action', actionurl);
});
