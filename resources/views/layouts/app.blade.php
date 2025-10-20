<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8" />
	<title>{{ config('app.name', 'Laravel') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('assetsbackend/imgs/theme/favicon.svg') }}" />
	<script src="{{ asset('assetsbackend/js/vendors/color-modes.js') }}"></script>
	<link href="{{ asset('assetsbackend/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
	<!-- Flasher (Toastr) styles -->
	<link rel="stylesheet" href="{{ asset('vendor/flasher/toastr.min.css') }}">
</head>

<body>
	<div class="screen-overlay"></div>

	<main class="main-wrap">
		<section class="content-main">
			{{-- Support both component slot and section-based content --}}
			{{ $slot ?? '' }}
			@yield('content')
		</section>
	</main>

	<script src="{{ asset('assetsbackend/js/vendors/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/select2.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/jquery.fullscreen.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/chart.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/main.js?v=6.0') }}"></script>
	<script src="{{ asset('assetsbackend/js/custom-chart.js') }}"></script>
	
	{{-- Flasher scripts (jquery + toastr handler) --}}
	<script src="{{ asset('vendor/flasher/jquery.min.js') }}"></script>
	<script src="{{ asset('vendor/flasher/toastr.min.js') }}"></script>
	<script src="{{ asset('vendor/flasher/flasher-toastr.min.js') }}"></script>
	{{-- Render flasher toast messages --}}
	@flasher_render(['presenter' => 'flasher::toast'])
</body>
</html>
