@extends('layouts.main.master')
@section('main')
    <img class="img2 layer" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/cupcake4.png" alt="">
    <h1>Login</h1>
    <div class="form">
        <form action="{{ route('login') }}" method="post">
            @csrf
            <input type="email" placeholder="Enter email" name="email">
            @error('email')
                <small style="color:#fa0303;margin-top:0rem"> {{ $message }}</small>
            @enderror
            <input type="password" placeholder="Enter password" name="password" maxlength="8">
            @error('password')
                <small style="color:#fa0303;margin-top:0rem"> {{ $message }}</small>
            @enderror
            <button class="Btn">
                Login
            </button>
            <small>Does not have an account?<span><a href="{{ route('auth#registerPage') }}">Register
                        Here!</a></span></small>
        </form>
    </div>
@endsection
