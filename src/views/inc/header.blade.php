<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<script src="{{ url('backend/locomotif/js/jquery-3.4.1.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
	
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="{{ url('backend/locomotif/css/tagcomplete.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('backend/locomotif/css/filter_multi_select.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('backend/locomotif/css/dropzone.css') }}">
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

@include('admin::inc/snackbar')

<script src="{{ url('backend/locomotif/js/tagcomplete.min.js') }}"></script>
<script src="{{ url('backend/locomotif/js/filter-multi-select-bundle.min.js') }}"></script>
<script src="{{ url('backend/locomotif/js/dropzone.js') }}"></script>
<script src="{{ url('backend/locomotif/js/sortable.min.js') }}"></script>
<script src="{{ url('backend/locomotif/js/tinymce/tinymce.min.js') }}"></script>
<script type='module' src="{{ url('backend/locomotif/js/main.js') }}"></script>
</body>
</html>
