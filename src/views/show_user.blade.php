@extends('admin::inc/header')
@section('title', 'User ')
@include('admin::inc/menu')

@section('content')
	<div class="container">
		<div class="cms-body">
			<p>This is user show blade</p>
			<p>User is {{$user->name}}</p>
		</div>
	</div>
@endsection