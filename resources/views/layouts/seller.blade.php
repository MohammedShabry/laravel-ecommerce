<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Seller Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assetsbackend/imgs/theme/favicon.svg') }}" />
    <script src="{{ asset('assetsbackend/js/vendors/color-modes.js') }}"></script>
    <link href="{{ asset('assetsbackend/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="screen-overlay"></div>

    {{-- Sidebar --}}
    @include('components.seller.sidebar')

    <main class="main-wrap">
        {{-- Header --}}
        @include('components.seller.header')

        {{-- Main Content --}}
        <section class="content-main">
            @yield('content')
        </section>

        {{-- Footer --}}
        @include('components.seller.footer')
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
</body>
</html>
