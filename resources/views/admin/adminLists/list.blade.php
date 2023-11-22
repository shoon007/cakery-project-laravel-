@extends('admin.layouts.master')
@section('content')
    {{-- admin list page --}}
    <div class="main" style="">
        <div class="category-lists">
            <div class="d-flex justify-content-between align-items-center mb-4 category-title">
                <div class="">
                    <h1>Admin List</h1>
                    <h2 class="mt-3 ms-3">(Total - {{ count($adminCount) }} )</h2>

                </div>
                <div class="d-flex justify-content-between">
                    <form action="{{ route('admin#list') }}" method="get" class="category-form">
                        @csrf
                        <div class="d-flex justify-content-center align-items-center search input">
                            <input placeholder="Search category name..." type="text" class="" name="key"
                                value="{{ request('key') }}">
                            <button type="submit">
                                <i class="fa-solid fa-magnifying-glass "></i>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

            @if (count($admins) > 0)
                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th class="admin-img">IMAGE</th>
                            <th>NAME</th>
                            <th>EMAIL</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }} </td>
                                <td class="admin-img">
                                    @if ($admin->image !== null)
                                        <img src="{{ asset('storage/' . $admin->image) }}" alt=""
                                            style="width:50px;height:50px;border-radius:10px;object-fit:cover;padding:0.4rem;margin:auto">
                                    @else
                                        <img src="{{ asset('img/default-male.png') }}" alt=""
                                            style="width:50px;height:50px;border-radius:10px;object-fit:cover;padding:0.4rem;margin:auto">
                                    @endif
                                </td>
                                <td>{{ $admin->name }} </td>
                                <td>{{ $admin->email }}</td>

                                <td>
                                    <ul class="wrapper">
                                        <a href="{{ route('admin#accountDetail', $admin->id) }}">
                                            <li class="icon ">
                                                <span class="tooltip">Details</span>
                                                <span> <i class="fa-solid fa-circle-info" style="color:#41f1b6"></i></span>
                                            </li>
                                        </a>
                                        @if ($admin->id !== Auth::user()->id)
                                            <a href="{{ route('admin#delete', $admin->id) }}">
                                                <li class="icon">
                                                    <span class="tooltip">Delete</span>
                                                    <span> <i class="fa-solid fa-trash delete"></i></span>
                                                </li>
                                            </a>
                                        @endif
                                    </ul>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h1 class="no-admin">There is no admin!</h1>
            @endif

        </div>
        <div class="d-flex justify-content-center align-content-center w-100m mt-4s">

        </div>

        <div class="mt-4">
            {{ $admins->links() }}
        </div>
    </div>
@endsection
