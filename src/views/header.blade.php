<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="{{ url('backend/locomotif/css/global.css') }}">
</head>
<body>

@extends('admin::menu')
@yield('content')

</body>
</html>