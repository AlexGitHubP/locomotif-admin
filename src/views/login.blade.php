@extends('admin::header')

@section('title', 'Locomotif Login')

@section('content')
<p>This is the admin login page</p>

<div class="login-wrapper">
    <form  method="POST" action="{{ route('admin/login') }}" class="login-form">
         @csrf
        <div class="login-input">
            <label for="email">{{ __('E-Mail Address') }}</label>    
            <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="login-input">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

         <div class="login-check">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">{{ __('Remember Me') }}</label>
        </div>

        <button type="submit" class="btn login-btn">
            {{ __('Login') }}
        </button>

        @if (Route::has('password.request'))
            <a class="" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
        
    </form>
   
</div>
@endsection