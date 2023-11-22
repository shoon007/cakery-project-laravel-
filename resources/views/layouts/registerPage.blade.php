@extends('layouts.main.master')
@section('main')
    <img class="img2 layer" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/cupcake1.png" alt="">
    <h1>Register</h1>
    <div class="form">
        <form action="{{ route('register') }}" method="post">
            @csrf
            <input type="text" placeholder="Enter name" name="name" maxlength="10">
            @error('name')
                <small style="color:#fa0303;margin-top:0rem"> {{ $message }}</small>
            @enderror

            <input type="email" placeholder="Enter email" name="email" maxlength="20">
            @error('email')
                <small style="color:#fa0303;margin-top:0rem"> {{ $message }}</small>
            @enderror

            <input type="text" name="phone" class="input" pattern="\d+" placeholder="Enter phone number"
                maxlength="15">
            @error('phone')
                <small style="color:#fa0303;margin-top:0rem"> {{ $message }}</small>
            @enderror

            <input type="text" placeholder="Enter address" name="address" maxlength="20">
            @error('address')
                <small style="color:#fa0303;margin-top:0rem"> {{ $message }}</small>
            @enderror

            <select name="gender" id="" placeholder="Enter gender">
                <option value="">Choose an option</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            @error('gender')
                <small style="color:#fa0303;margin-top:0rem"> {{ $message }}</small>
            @enderror

            <input type="password" placeholder="Enter password" name="password" maxlength="8">
            @error('password')
                <small style="color:#fa0303;margin-top:0rem"> {{ $message }}</small>
            @enderror
            <input type="password" placeholder="Enter confirm password" name="password_confirmation" maxlength="8">
            @error('password_confirmation')
                <small style="color:#fa0303;margin-top:0rem"> {{ $message }}</small>
            @enderror
            <button class="Btn">
                Register
            </button>
            <small>Already have an account?<span><a href="{{ route('auth#loginPage') }}">Login now!</a></span></small>
        </form>
    </div>
@endsection
