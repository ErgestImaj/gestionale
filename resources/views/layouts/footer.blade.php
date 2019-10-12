<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{\Carbon\Carbon::now()->format('Y')}} <a href="#" target="_blank">Mediaform Srl.</a> Tutti i diritti riservati.</span>
    </div>
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'baseURL' => url('/'),
        ]); ?>
    </script>
    <script src="{{ asset('js/app.js') }}"></script>

@stack('scripts')
    <script>
        jQuery(function () {

           $('.toggleefect').on('click',function () {
               $('body').toggleClass('sidebar-icon-only')
           })
            $('.mobile-menu').on('click',function () {
               $('#sidebar').toggleClass('active')
           })

            //right dashboard

            $('#settings-trigger').on('click',function () {
                $('#theme-settings').toggleClass('open')
            })
            $('#theme-settings .settings-close').on('click',function () {
                $('#theme-settings').removeClass('open')
            })
            $('#email-settings .settings-close').on('click',function () {
                $('#email-settings').removeClass('open')
            })


            //file upload

            $('.file-upload-browse').on('click', function() {
                var file = $(this).parent().parent().parent().find('.file-upload-default');
                file.trigger('click');
            });
            $('.file-upload-default').on('change', function() {
                $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
            });

        })

    </script>
    @jquery
    @toastr_js
    @toastr_render
</footer>
