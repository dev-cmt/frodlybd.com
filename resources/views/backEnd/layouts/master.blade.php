<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ env('APP_NAME') }} - @yield('title') </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset($settings ? $settings->favicon : '') }}" type="image/x-icon">
    <!-- Choices JS -->
    <script src="{{ asset('backEnd/js/choices.min.js') }}"></script>
    <!-- Main Theme Js -->
    <script src="{{ asset('backEnd/js/main.js') }}"></script>
    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('backEnd/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Style Css -->
    <link href="{{ asset('backEnd/css/styles.min.css') }}" rel="stylesheet">
    <!-- Icons Css -->
    <link href="{{ asset('backEnd/css/icons.css') }}" rel="stylesheet">
    <!-- Node Waves Css -->
    <link href="{{ asset('backEnd/css/waves.min.css') }}" rel="stylesheet">
    <!-- Simplebar Css -->
    {{-- <link href="{{ asset('backEnd/css/simplebar.min.css') }}" rel="stylesheet" > --}}
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('backEnd/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backEnd/css/nano.min.css') }}">
    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('backEnd/js/choices.min.js') }}">
    <link rel="stylesheet" href="{{ asset('backEnd/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backEnd/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backEnd/plugins/sweetalert2/sweetalert2.min.css') }}">
    {{--    <link rel="stylesheet" href="{{ asset('backEnd/css/custom.css') }}"> --}}
    @stack('css')
</head>
<body>
    <!-- Loader -->
    <div id="loader">
        {{-- <img src="../assets/images/media/loader.svg" alt=""> --}}
    </div>
    <!-- Loader -->

    <div class="page">
        <!-- app-header -->
        @include('backEnd.partials.header')
        <!-- /app-header -->
        <!-- Start::app-sidebar -->
        @include('backEnd.partials.sidebar')
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!-- End::app-content -->

        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="input-group">
                            <a href="javascript:void(0);" class="input-group-text" id="Search-Grid"><i
                                    class="fe fe-search header-link-icon fs-18"></i></a>
                            <input type="search" class="form-control border-0 px-2" placeholder="Search"
                                aria-label="Username">
                            <a href="javascript:void(0);" class="input-group-text" id="voice-search"><i
                                    class="fe fe-mic header-link-icon"></i></a>
                            <a href="javascript:void(0);" class="btn btn-light btn-icon" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group ms-auto">
                            <button class="btn btn-sm btn-primary-light">Search</button>
                            <button class="btn btn-sm btn-primary">Clear Recents</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Start -->
        @include('backEnd.partials.footer')
        <!-- Footer End -->
    </div>


    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->

    <!-- Popper JS -->
    <script src="{{ asset('backEnd/js/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('backEnd/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('backEnd/js/defaultmenu.min.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('backEnd/js/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('backEnd/js/sticky.js') }}"></script>

    <!-- Simplebar JS -->
    {{-- <script src="{{ asset('backEnd/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('backEnd/js/simplebar.js') }}"></script> --}}

    <!-- Color Picker JS -->
    <script src="{{ asset('backEnd/js/pickr.es5.min.js') }}"></script>


    <!-- JSVector Maps JS -->
    <script src="{{ asset('backEnd/js/jsvectormap.min.js') }}"></script>

    <!-- JSVector Maps MapsJS -->
    <script src="{{ asset('backEnd/js/world-merc.js') }}"></script>

    <!-- Apex Charts JS -->
    <script src="{{ asset('backEnd/js/apexcharts.min.js') }}"></script>

    <!-- Chartjs Chart JS -->
    <script src="{{ asset('backEnd/js/chart.min.js') }}"></script>

    <!-- CRM-Dashboard -->
    {{-- <script src="{{ asset('backEnd/js/crm-dashboard.js') }}"></script> --}}

    <!-- Custom-Switcher JS -->
    <script src="{{ asset('backEnd/js/custom-switcher.min.js') }}"></script>

    <!-- Custom JS -->
    {{-- <script src="{{ asset('backEnd/js/custom.js') }}"></script> --}}

    <!-- Jquer JS -->
    <script src="{{ asset('backEnd/js/jquery.js') }}"></script>

    <script src="{{ asset('backEnd/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        @if (session()->has('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>

    @stack('js')

</body>
</html>
