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

	<link href="{{ url('css/simplelightbox.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ url('css/lightbox-style.css') }}" rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->
</head>
<body>
	<!-- Header -->
	<header id="header" class="transparent-navbar">
		<!-- container -->
		<div class="container">
			<!-- navbar header -->
			<div class="navbar-header">
				<!-- Logo -->
				<div class="navbar-brand">
					<a class="logo" href="/">
						<img class="logo-img" src="{{ url('img/site-logo.png') }}" alt="logo">
						<img class="logo-alt-img" src="{{ url('img/site-logo.png') }}" alt="logo">
					</a>
				</div>
				<!-- /Logo -->
				<!-- Mobile toggle -->
				<button class="navbar-toggle"><i class="fa fa-bars"></i></button>
				<!-- /Mobile toggle -->
			</div>
			<!-- /navbar header -->
			<!-- Navigation -->
			<nav id="nav"></nav>
			<!-- /Navigation -->
		</div>
		<!-- /container -->
	</header>
	<!-- Contact -->
	<div id="contact" class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="col-md-1">
			</div>
			<!-- /row -->
			<div class="col-md-10">
                @yield('content')
			</div>
		</div>
		<!-- /container -->	
	</div>
	<!-- /Contact -->

    <!-- Footer -->
	@include('includes/footer')
    <!-- /Footer -->

	<!-- jQuery Plugins -->
	<script src="{{ url('js/jquery.min.js') }}"></script>
	<script src="{{ url('js/bootstrap.min.js') }}"></script>
	<script src="{{ url('js/jquery.waypoints.min.js') }}"></script>
	<script src="{{ url('js/owl.carousel.min.js') }}"></script>
	<script src="{{ url('js/jquery.stellar.min.js') }}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script src="{{ url('js/google-map.js') }}"></script>
	<script src="{{ url('js/jquery.countTo.js') }}"></script>
	<script src="{{ url('js/main.js') }}"></script>

</body>

</html>
