@extends('admin::header')
@section('title', 'User ')
@section('content')
<p>This is user show blade</p>

<p>User is {{$user->name}}</p>

<a href="/admin/users">Go bec</a>
@endsection