@extends('admin.layouts.master')
@section('content')
    {{-- admin list page --}}
    <div class="main" style="">
        <div class="category-lists">
            <div class="d-flex justify-content-between align-items-center mb-4 category-title">
                <div class="">
                    <h1>Customer List</h1>
                    @if (count($customerCount) > 0)
                        <h2 class="mt-3 ms-3">(Total - {{ count($customerCount) }})</h2>
                    @endif

                </div>
                <div class="d-flex justify-content-between">
                    <form action="" method="get" class="category-form">
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

            @if (count($customerList) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th class="customer-img">IMAGE</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th class="time">CREATED AT</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($customerList as $customer)
                            <tr>
                                <td>{{ $customer->id }} </td>
                                <td class="customer-img">
                                    @if ($customer->image !== null)
                                        <img src="{{ asset('storage/images/' . $customer->image) }}" alt=""
                                            style="width:50px;height:50px;border-radius:10px;object-fit:cover;padding:0.4rem;margin:auto">
                                    @else
                                        <img src="{{ asset('img/default-male.png') }}" alt=""
                                            style="width:50px;height:50px;border-radius:10px;object-fit:cover;padding:0.4rem;margin:auto">
                                    @endif
                                </td>
                                <td> {{ $customer->name }} </td>
                                <td>{{ $customer->email }} </td>
                                <td class="time">{{ $customer->created_at->format('d-m-y') }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h1 class="no-customer">There is no customer!</h1>
            @endif

        </div>
        <div class="d-flex justify-content-center align-content-center w-100m mt-4s">

        </div>
        <div class="mt-4">
            {{ $customerList->links() }}
        </div>

    </div>
@endsection
