<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Nest - Multipurpose eCommerce')</title>

    {{-- Ensure relative asset paths resolve from app root --}}
    <base href="{{ url('/') }}/">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/imgs/theme/favicon.svg') }}">

    {{-- Styles --}}
    {{-- Load Tailwind (compiled) first so theme CSS/Bootstrap can override where necessary --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- for Tailwind --}}
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v=6.0') }}">
    @stack('styles')
</head>
<body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('assets/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader End -->

    {{-- Include header --}}
    @include('components.customer.header')

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Include footer --}}
    @include('components.customer.footer')

</body>

    {{-- Vendor JS --}}
    <script src="{{ asset('assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.elevatezoom.js') }}"></script>

    <!-- Template  JS -->
    <script src="{{ asset('assets/js/main.js?v=6.0') }}"></script>
    <script src="{{ asset('assets/js/shop.js?v=6.0') }}"></script>
    @stack('scripts')
    </body>
</html>
