@extends('admin.layouts.master')
@section('content')
    {{-- category list page --}}
    <div class="main" style="">
        <div class="category-lists">
            <div class="d-flex justify-content-between align-items-center mb-4 category-title">
                <div class="d-flex">
                    <h1>Category List</h1>
                    <a href="{{ route('category#createPage') }}" title="Add Category">
                        <div tabindex="0" class="plusButton">
                            <svg class="plusIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                <g mask="url(#mask0_21_345)">
                                    <path
                                        d="M13.75 23.75V16.25H6.25V13.75H13.75V6.25H16.25V13.75H23.75V16.25H16.25V23.75H13.75Z">
                                    </path>
                                </g>
                            </svg>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between">
                    <form action="{{ route('category#listPage') }}" method="get" class="category-form">
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
            @if (session('createSuccess'))
                <div class="alert alert-box alert-success alert-dismissible fade show" role="alert"
                    style="margin-top:2rem">
                    <p class="text-success">{{ session('createSuccess') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                        onclick="window.location.reload()"></button>
                </div>
            @endif
            @if (session('updateSuccess'))
                <div class="alert alert-box alert-success alert-dismissible fade show" role="alert"
                    style="margin-top:2rem">
                    <p class="text-success">{{ session('updateSuccess') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                        onclick="window.location.reload()"></button>
                </div>
            @endif
            <table>
                @if (count($categories) > 0)
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>CREATED AT</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->created_at->format('d-M-y') }}</td>
                                <td>

                                    <ul class="wrapper">
                                        <a href="{{ route('category#updatePage', $item->id) }}">
                                            <li class="icon">
                                                <span class="tooltip">Edit</span>
                                                <span> <i class="fa-solid fa-file-pen pen wrapper"></i></span>
                                            </li>
                                        </a>
                                        <a href="{{ route('category#delete', $item->id) }}">
                                            <li class="icon ">
                                                <span class="tooltip">Delete</span>
                                                <span> <i class="fa-solid fa-trash delete"></i></span>
                                            </li>
                                        </a>
                                    </ul>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <h1 class="text-center error-title">There is no Category here!
                            <a href="{{ route('category#createPage') }}">Create one here!</a>
                        </h1>
                @endif
                </tbody>
            </table>

        </div>
        <div class="d-flex justify-content-center align-content-center w-100m mt-4s">

        </div>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>

@endsection
