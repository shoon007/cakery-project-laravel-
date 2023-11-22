@extends('admin.layouts.master')
@section('content')
    <div class="main">
        @if (session('changeSuccess'))
            <div class="alert alert-box alert-success alert-dismissible fade show" role="alert" style="margin-top:6rem">
                <p class="text-success">{{ session('changeSuccess') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- password form --}}
        <div class="pwd-container">
            <form action="{{ route('admin#changePassword') }}" method="post">
                @csrf
                <h1>Change Password</h1>
                <div class="input-container">
                    <input type="password" id="input" name="oldPassword" maxlength="8">
                    <label for="input" class="label">Old Password</label>
                    <div class="underline"></div>
                </div>
                @error('oldPassword')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
                @if (session('notMatch'))
                    <small class="notMatch" style="color:red"> {{ session('notMatch') }}</small>
                @endif

                <div class="input-container">
                    <input type="password" id="input" name="newPassword" maxlength="8">
                    <label for="input" class="label">New Password</label>
                    <div class="underline"></div>
                </div>
                @error('newPassword')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
                <div class="input-container">
                    <input type="password" id="input" name="confirmPassword" maxlength="8">
                    <label for="input" class="label">Confirm Password</label>
                    <div class="underline"></div>

                </div>
                @error('confirmPassword')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
                <div class="buttons">
                    <button class="btn"><span></span>
                        <p data-start="good luck!" data-text="sure?" data-title="change"></p>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
