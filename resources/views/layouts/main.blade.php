<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>RSOS 2019</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700,900" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" />

	<!-- Owl Carousel -->
	<link type="text/css" rel="stylesheet" href="{{ url('css/owl.carousel.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ url('css/owl.theme.default.css') }}" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="{{ url('css/style.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ url('css/custom.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ url('css/menu.css') }}" />

	<link href='{{ url('css/simplelightbox.css') }}' rel='stylesheet' type='text/css'>
	<link href='{{ url('css/lightbox-style.css') }}' rel='stylesheet' type='text/css'>


    <link href="{{ url('css/jquery-ui.css') }}" rel="stylesheet" />
	<link href="{{ url('css/jquery.multiselect.css') }}" rel="stylesheet" />
	<link href="{{ url('css/app.css') }}" rel="stylesheet" />
   
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="{{ url('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}"></script>
        <script src="{{ url('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}"></script>
    <![endif]-->
    @stack('styles')
</head>
<body>
	@include('includes.header')

	<div id="dashboard-page" class="section container">
		<!-- Dashboard container -->
		<div class="container" >
			@includeWhen(env('APP_DEBUG'), 'demo')

			@includeWhen(session('success'), 'includes.success')
			@includeWhen(session('status'), 'includes.status')
			@includeWhen(session('error'), 'includes.error')

			@yield('content')
			
		</div>
        <!-- /Dashboard container -->		
	</div>

	@include('includes.footer')

<!-- jQuery Plugins -->
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<script src="{{ url('js/jquery.waypoints.min.js') }}"></script>
<script src="{{ url('js/owl.carousel.min.js') }}"></script>
<script src="{{ url('js/jquery.stellar.min.js') }}"></script>
<script src="{{ url('js/jquery.countTo.js') }}"></script>
<script src="{{ url('js/main.js') }}"></script>
<script src="{{ url('js/custom.js') }}"></script>
<script src="{{ url('js/aos.js') }}"></script>    
{{-- <script src="{{ url('js/simple-lightbox.js') }}"></script> --}}
{{-- <script src="{{ url('js/app.js') }}"></script> --}}
{{-- <script src="{{ url('js/jquery-ui.js') }}"></script> --}}

<script>
	$('[title]').tooltip();
</script>
@stack('scripts')
</body>
</html>
