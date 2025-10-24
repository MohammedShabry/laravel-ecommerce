<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- CSRF token for AJAX requests and scripts that need it -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assetsbackend/imgs/theme/favicon.svg') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="{{ asset('assetsbackend/js/vendors/color-modes.js') }}"></script>
    <link href="{{ asset('assetsbackend/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
    <style>
        /* When a modal is open add this class to the root to prevent underlying
           layout from receiving pointer events (stops hover/collapse on sidebar/header). */
        .modal-open .main-wrap,
        .modal-open .screen-overlay,
        .modal-open .nav,
        .modal-open .sidebar {
            pointer-events: none;
        }

        /* Keep the overlay and modal dialog themselves interactive when modal-open set */
        .modal-open .refund-modal,
        .modal-open .refund-modal * {
            pointer-events: auto !important;
        }
    </style>
</head>

<body>
    <div class="screen-overlay"></div>

    {{-- Sidebar --}}
    @include('components.admin.sidebar')

    <main class="main-wrap">
        {{-- Header --}}
        @include('components.admin.header')

        {{-- Main Content --}}
        <section class="content-main">
            @yield('content')
        </section>

        {{-- Footer --}}
        @include('components.admin.footer')
    </main>

    {{-- Scripts --}}
    <script src="{{ asset('assetsbackend/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assetsbackend/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assetsbackend/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('assetsbackend/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assetsbackend/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('assetsbackend/js/vendors/chart.js') }}"></script>
    <script src="{{ asset('assetsbackend/js/main.js?v=6.0') }}"></script>
    <script src="{{ asset('assetsbackend/js/custom-chart.js') }}"></script>
    <script>
        // Ensure jQuery AJAX includes Laravel CSRF token if jQuery is present
        (function(){
            var tokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (window.jQuery && tokenMeta) {
                window.jQuery.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': tokenMeta.getAttribute('content') }
                });
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>
