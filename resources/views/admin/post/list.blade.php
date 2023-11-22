@extends('admin.layouts.master')
@section('content')

    {{-- all products lists --}}
    <div class="main" style="">
        <div class="category-lists">
            <div class="d-flex justify-content-between align-items-center mb-4 category-title">
                <div class="d-flex">
                    <h1>Product List</h1>
                    <a href="{{ route('product#createPage') }}" title="Create Category">
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
                    <form action="{{ route('product#listPage') }}" method="get" class="category-form">
                        @csrf
                        <div class="d-flex justify-content-center align-items-center search input">
                            <input placeholder="Search category name..." type="text" class="" name="key"
                                value="{{ request('key') }}">
                            <button type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
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
                <div class="alert  alert-box alert-success alert-dismissible fade show" role="alert"
                    style="margin-top:2rem">
                    <p class="text-success">{{ session('updateSuccess') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                        onclick="window.location.reload()"></button>
                </div>
            @endif
            <table>
                @if (count($products) > 0)
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IMAGE</th>
                            <th>NAME</th>
                            <th class="category">CATEGORY</th>
                            <th class="price">PRICE</th>
                            <th>VIEW COUNT</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <td>
                                    {{ $item->id }}
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="" class="product-img">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td class="category">{{ $item->category_name }}</td>
                                <td class="price">{{ $item->price }} Kyats</td>
                                <td class="view-count">{{ $item->view_count }}</td>
                                <td class="wrapper-container">
                                    <ul class="wrapper">
                                        <a href="{{ route('product#editPage', $item->id) }}">
                                            <li class="icon">
                                                <span class="tooltip">Edit</span>
                                                <span> <i class="fa-solid fa-file-pen pen"></i></span>
                                            </li>
                                        </a>

                                        <a href="{{ route('product#details', $item->id) }}">
                                            <li class="icon ">
                                                <span class="tooltip">Details</span>
                                                <span> <i class="fa-solid fa-circle-info" style="color:#41f1b6"></i></span>
                                            </li>
                                        </a>
                                        <a href="{{ route('product#delete', $item->id) }}">
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
                        <h1 class="text-center error-title">There is no Product here!
                            <a href="{{ route('product#createPage') }}">Create one here!</a>
                        </h1>
                @endif
                </tbody>
            </table>

        </div>
        <div class="d-flex justify-content-center align-content-center w-100m mt-4s">

        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>

@endsection
