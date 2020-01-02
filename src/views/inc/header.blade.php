<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<script src="{{ url('backend/locomotif/js/jquery-3.4.1.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.0.4/gsap.min.js"></script>
	

	<link rel="stylesheet" type="text/css" href="{{ url('backend/locomotif/css/global.css') }}">
</head>
<body>


@yield('content')

<script src="{{ url('backend/locomotif/js/main.js') }}"></script>
</body>
</html>
