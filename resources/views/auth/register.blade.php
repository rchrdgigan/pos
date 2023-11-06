@extends('layouts.auth')

@section('title')
Register Page
@endsection

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    <h1>Sign-Up</h1>
    <div class="input-box">
        <input type="text" name="name" @error('name') style="background-color:rgb(201, 93, 93)" @enderror value="{{old('name')}}" placeholder="Name">
    </div>
    @error('name')
        <span class="invalid-feedback" role="alert">
            <small>{{ $message }}</small>
        </span>
    @enderror

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

    <div class="input-box">
        <input type="password" name="password_confirmation" placeholder="Confirm Password">
    </div>

    <div class="privacy">
        <label>
            <input type="checkbox" name="privacy" required><small> <i>By registering on our website, you agree to our Privacy Policy and consent to the collection and use of your personal information as outlined therein.</i></small>
        </label>
    </div>
    <button type="submit" class="btn">Register</button>

    <div class="register-link">
        <p>Already have an account?<a href="{{ route('login') }}"> Login</a></p>
    </div>
</form>
@endsection