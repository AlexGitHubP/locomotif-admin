@extends('admin::header')

@section('title', 'Admin Dashboard')

@section('content')
	<p>This is admin dashboard</p>
	Logout from dashboard: 
	<a href="{{ route('admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
	<form id="logout-form" action="{{ route('admin/logout') }}" method="POST" style="display: none;">
	    @csrf
	</form>

	<a href="{{ route('admin/users') }}">View users list</a>
@endsection()