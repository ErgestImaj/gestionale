<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')
<body>

    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('layouts.top-nav')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            @include('layouts.right-panel')
            <!-- partial:partials/_sidebar.html -->
            @include('layouts.left-nav')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper" id="app">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('layouts.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
</body>
</html>
