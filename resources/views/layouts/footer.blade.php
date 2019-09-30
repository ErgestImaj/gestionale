<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{\Carbon\Carbon::now()->format('Y')}} <a href="#" target="_blank">Mediaform Srl.</a> Tutti i diritti riservati.</span>
    </div>
    <!-- Scripts -->
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
        })
    </script>
</footer>
