<div class="theme-setting-wrapper">
        <div id="email-settings" class="settings-panel">
            <i class="settings-close fa fa-times"></i>
            <p class="settings-heading text-uppercase">{{trans('form.send_email')}}</p>
            <form action="" method="POST" id="sendemailform">
                @csrf
                <div class="mx-0 px-4 mt-2">
                    <div class="form-group py-3">
                        <label class="form-control-label" for="input-email">{{trans('form.add_cc_email')}} </label>
                        <input type="email" name="cc_email" id="input-email" class="form-control"  placeholder="jesse@example.com">
                            <span class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="binput-email">{{trans('form.add_bcc_email')}}</label>
                        <input type="email" name="bcc_email" id="binput-email" class="form-control " placeholder="jesse@example.com">
                            <span class="invalid-feedback" role="alert"></span>

                    </div>
                </div>
                <p class="settings-heading mt-2">{{trans('form.dati_email')}}</p>
                <div class=" mx-0 px-4 mt-2">
                    <div class="form-group pt-2">
                        <label class="form-control-label" for="input-last-name">{{trans('form.subject')}}</label>
                        <input type="text" name="soggetto" id="input-last-name" class="form-control " placeholder="{{trans('form.subject')}}">
                                 <span class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label for="descrizione">{{trans('form.description')}}</label>
                        <textarea class="form-control summernote" name="descrizione" id="descrizione" rows="4"></textarea>
                    </div>
                    <span class="invalid-feedback d-block mb-3 " id="descrizione" role="alert"></span>

                    <div class="form-group mb-5 pb-5">
                        <button class="btn-info sender-email-to btn" type="submit">{{trans('form.send')}}</button>
                    </div>
                </div>
            </form>
        </div>
</div>
@push('scripts')
    <script>
        $('.summernote').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],

        });
    </script>
    <script>
        $('.sender-email-to').on('click',function (e) {
            e.preventDefault();
            $('#sendemailform input').removeClass('is-invalid')
            let actionurl = $('#sendemailform').attr('action');
            let data = getFormData(
                $("#sendemailform")
            );

           axios.post(actionurl,data)
                .then(response => {
                       if (response.data.status == 'success'){
                           swal("Good job!", response.data.msg, "success");
                           table.ajax.reload();
                           $('#email-settings').removeClass('open')
                           $('#sendemailform')[0].reset();
                           swal.stopLoading();
                           swal.close();
                       }
                })
                .catch(err => {
                    if( err.response.status === 422 ) {
                        var errors = (err.response.data.errors);
                        $.each(errors, function (key, val) {
                            if(key =='descrizione'){
                                $('#descrizione').html('<strong>'+val[0]+'</strong>')
                            }
                            $("input[name=" + key + "]")
                                .addClass('is-invalid')
                                .next()
                                .html('<strong>'+val[0]+'</strong>');

                        });
                        document.getElementById('email-settings').scrollIntoView({
                            behavior: 'smooth'
                        });
                        return

                    }
                   if (err.response.status==200) {
                       swal("Good job!", err.response.msg, "success");
                       $('#email-settings').removeClass('open')
                       table.ajax.reload();
                       $('#sendemailform')[0].reset();
                       swal.stopLoading();
                       swal.close();
                   } else {
                       swal("Woops!", "Qualcosa è andato storto!", "error");
                       swal.stopLoading();
                       swal.close();
                   }
               })

        })

        function getFormData($form){
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }
    </script>
@endpush
