@extends('admin.layouts.master')
@section('content')
    {{-- admin account details page --}}
    <div class="main">
        <div class="details-container">
            <h1 class="text-center mb-5">Edit Profile</h1>
            <div class="form">
                <div class="account-details">
                    <div class="profile">
                        @if (Auth::user()->image == null)
                            <img src="{{ asset('img/default-male.png') }}" alt="">
                        @else
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="" id="img">
                        @endif

                    </div>
                    <div class="info-container">
                        <div class="info">
                            <p>- {{ $user->email }} </p>
                            <p>- {{ $user->phone }} </p>
                            <p>- {{ $user->address }} </p>
                            <p>- {{ $user->gender }} </p>
                            <p>- {{ $user->created_at->format('d-M-y') }} </p>
                        </div>

                    </div>
                </div>

                <a href="{{ route('admin#editPage') }}">
                    <button class="btn"> Edit
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection
