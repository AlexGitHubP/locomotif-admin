@extends('admin::inc/header')
@section('title', 'Add new user')

@section('content')
  <div class="container">
    <div class="cms-body">
      <p>Create a new user</p>
      <form action="/admin/users" method="POST">
          @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name"  name="name" value="">
        </div>

        <div class="form-group">
          <label for="name">Email</label>
          <input type="text" class="form-control" id="email"  name="email" value="">
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