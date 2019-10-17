<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>{{ config('app.name') }}</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/css/fonts.min.css') }}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>


	<!-- CSS Files -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
	@yield('styles')
	
</head>
<body>
	<div class="wrapper" id="app">
		@include('admin.includes.header')

		@include('admin.includes.sidemenu')

		<div class="main-panel">
			@yield('content')
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<div class="copyright ml-auto">
							Copyright &copy; 2019 {{ config('app.name') }} , All Rights Reserved
						</div>
					</nav>			
				</div>
			</footer>
		</div>
	</div>
	
	<script src="{{ asset('js/app.js') }}"></script>
	@include('sweetalert::alert')

	@include('admin.includes.script_bottom')

	@yield('scripts')
</body>
</html>