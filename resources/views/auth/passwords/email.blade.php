@extends('layouts.auth')

@section('title')
Reset Password Page
@endsection

@section('content')
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h1>Reset Password</h1>
    <div class="input-box">
        <input type="email" name="email" @error('email') style="background-color:rgb(201, 93, 93)" @enderror value="{{old('email')}}" placeholder="Email Address">
    </div>
    @error('email')
        <span class="invalid-feedback" role="alert">
            <small>{{ $message }}</small>
        </span>
    @enderror
    <br>
    <button type="submit" class="btn">{{ __('Send Password Reset Link') }}</button>
    <div class="register-link">
        <p>Back to<a href="{{ route('login') }}"> Login ?</a></p>
    </div>
</form>
@endsection
