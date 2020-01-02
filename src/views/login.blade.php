@extends('admin::inc/header')

@section('title', 'Locomotif Login')

@section('content')

<div class="login-area">
    <div class="login-holder">
    <img src="{{ url('backend/locomotif/img/logo.png') }}" class="locomotif-logo">
        <form id="login-form" method="POST" action="{{ route('admin/login') }}" autocomplete="off" >
            @csrf
            <div class="login-input-holder">
                <label class="login-label" for="email">Username / Email Adress</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="{{ $errors->has('email') ? ' is-invalid' : '' }}">
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="login-input-holder">
                <label class="login-label" for="password">Password</label>
                <input type="password" name="password" id="password" value="" required class="{{ $errors->has('password') ? ' is-invalid' : '' }}">
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="login-input-holder">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <div class="login-checker"></div>
                <label for="remember" class="login-check-label">Remember credentials.</label>
            </div>
            <input type="submit" value="Login" id="submit-login">
        </form>
    </div>
</div>

@endsection
