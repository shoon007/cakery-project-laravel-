@extends('admin.layouts.master')
@section('content')
    <div class="main" style="">
        <a href="{{ route('admin#dashboard') }}">
            <button class="back-btn">
                <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
                    <path
                        d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
                    </path>
                </svg>
                <span>Back</span>
            </button>
        </a>
        <div class="category-lists">
            <div class="d-flex justify-content-between align-items-center mb-4 category-title">
                <div class="d-flex">
                    <h1>Like Count List</h1>

                </div>

            </div>
            @if (count($likeCount) > 0)
                <table>
                    <thead class="view-count">
                        <tr>
                            <th>ID</th>
                            <th>CUSTOMER NAME</th>
                            <th>PRODUCT NAME</th>
                            <th class="product-image">PRODUCT IMAGE</th>
                            <th>CREATED AT</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="view-count">
                        @foreach ($likeCount as $item)
                            <tr>
                                <td>
                                    {{ $item->id }}
                                </td>
                                <td>
                                    {{ $item->customer_name }}
                                </td>
                                <td>
                                    {{ $item->product_name }}
                                </td>
                                <td class="product-image">
                                    <img src="{{ asset('storage/' . $item->product_image) }}" alt="">
                                </td>
                                <td>
                                    {{ $item->created_at->format('d-M-y') }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <h1 class="text-center error-title">There is no like!
                </h1>
            @endif
        </div>

        <div class="mt-4">
            {{ $likeCount->links() }}
        </div>
    </div>
@endsection
