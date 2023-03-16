<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<script src="{{ url('backend/locomotif/js/jquery-3.4.1.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.0.4/gsap.min.js"></script>
	

	<link rel="stylesheet" type="text/css" href="{{ url('backend/locomotif/css/global.css') }}">
</head>
<body>

@if (isset($login_page) && $login_page)
@yield('content')
@else
<div class='flex-dashboard'>
	
	<div class='flex-dashboard-left'>
		@include('admin::inc/left-menu')
	</div><!--flex-dashboard-left-->

	<div class='flex-dashboard-right'>
		@include('admin::inc/cms-search')
		@yield('content')
	</div><!--flex-dashboard-right-->
</div><!--flex-dashboard-->
@endif

<script src="{{ url('backend/locomotif/js/main.js') }}"></script>
</body>
</html>
