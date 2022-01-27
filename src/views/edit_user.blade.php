@extends('admin::inc/header')
@section('title', 'Edit user')
@section('content')

@include('admin::inc/menu')
  <div class="container"> 
    <div class="cms-body">
      <p>Edit user: {{$user->name}}</p>
      <form action="/admin/users/{{$user->id}}" method="POST">
          {{ method_field('PUT') }}
          @csrf
      	<div class="form-group">
      		<label for="name">Namess</label>
      		<input type="text" class="form-control" id="name"  name="name" value="{{$user->name}}">
      	</div>

        <div class="form-group">
          <label for="name">Email</label>
          <input type="text" class="form-control" id="email"  name="email" value="{{$user->email}}">
        </div>

        	<div class="form-group">
          	<label for="text">Password</label>
          	<input type="text" class="form-control" id="password" name="password" value="">
        	</div>
        	<button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
@endsection