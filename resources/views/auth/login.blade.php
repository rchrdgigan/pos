@extends('layouts.auth')

@section('title')
Login Page
@endsection

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <h1>Sign-In</h1>
    <div class="input-box">
        <input type="email" name="email" @error('email') style="background-color:rgb(201, 93, 93)" @enderror value="{{old('email')}}" placeholder="Email">
    </div>
    @error('email')
        <span class="invalid-feedback" role="alert">
            <small>{{ $message }}</small>
        </span>
    @enderror

    <div class="input-box">
        <input type="password" name="password" @error('password') style="background-color:rgb(201, 93, 93)" @enderror placeholder="Password">
    </div>
    @error('password')
        <span class="invalid-feedback" role="alert">
            <small>{{ $message }}</small>
        </span>
    @enderror

    <div class="remember-forgot">
        <label>
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>Remember me
        </label>
        <a href="{{ route('password.request') }}">Forgot password?</a>
    </div>
    <button type="submit" class="btn">Login</button>

</form>
@endsection
