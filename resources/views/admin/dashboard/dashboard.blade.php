<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake of Paradise</title>
    <link rel="shortcut icon" href="https://webstockreview.net/images/fruit-clipart-cupcake-4.png" type="image/x-icon">

    {{-- bootstrap link --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    {{-- font awesome link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Custom css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard/dashboard.css') }}">
</head>

<body>
    <!-- THE WHOLE CONTAINER -->
    <div class="container">

        <!-- START OF SIDEBAR -->
        <aside>
            <div class="top">
                <a href="{{ route('admin#dashboard') }}">
                    <div class="logo">
                        <img src="https://webstockreview.net/images/fruit-clipart-cupcake-4.png" alt="">
                        <h2 style="margin-bottom:0rem">CAKE OF <span class="danger"> PARADISE</span> </h2>
                    </div>
                </a>
                <div class="close" id="close-btn">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
            <div class="sidebar">
                <a href="{{ route('admin#dashboard') }}" class="active">
                    <span><i class="fa-solid fa-grip"></i></span>
                    <h3>Dashboard</h3>
                </a>
                <a href="{{ route('category#listPage') }}">
                    <span> <span>
                            <i class="fa-solid fa-clipboard"></i></span></span>
                    </span></i></span>
                    <h3>Category</h3>
                </a>
                <a href="{{ route('product#listPage') }}">
                    <span> <i class="fa-solid fa-pen-to-square"></i></span>
                    <h3>Product</h3>
                </a>
                <a href="{{ route('customer#list') }}">
                    <span><i class="fa-solid fa-users"></i></span>
                    <h3>Customers</h3>
                </a>

                <a href="{{ route('select#chat') }}">
                    <span> <i class="fa-solid fa-comment"></i></span>
                    <h3 class="mb-0">Chat</h3>

                    @if (count($message) > 0 && count($countMessage) > 0)
                        <span class="message-count">
                            {{ 1 + count($countMessage) }}
                        </span>
                    @elseif(count($countMessage) > 0)
                        <span class="message-count">
                            {{ count($countMessage) }}
                        </span>
                        @elseif (count($message) > 0 )
                        <span class="message-count">
                           1
                        </span>
                    @endif

                </a>
                <a href="{{ route('admin#detailsPage') }}">
                    <span>
                        <i class="fa-solid fa-circle-user"></i></span>
                    <h3>Account</h3>
                </a>
                <a href="{{ route('admin#changePasswordPage') }}">
                    <span><i class="fa-solid fa-key"></i></span>
                    <h3>Change Password</h3>
                </a>
                <a href="{{ route('admin#list') }}">
                    <span><i class="fa-regular fa-address-book"></i></span>
                    <h3>Admin List</h3>
                </a>

                <a href="{{ url('/logout') }}">
                    <span><i class="fa-solid fa-right-from-bracket"></i></span>
                    <h3>Logout</h3>
                </a>

            </div>
        </aside>
        <!-- END OF SIDEBAR -->

        <!-- START OF MAIN SECTION ( THE MIDDLE SECTION )-->
        <main>
            <h1>Dashboard</h1>
            <div class="date">
                <input type="date" id="datepicker">
            </div>
            <div class="insights">
                <a href="{{ route('viewCount#list') }}">
                    <div class="sales">
                        <div class="middle">
                            <div class="left">
                                <h3>View</h3>
                                <h1>{{ $formattedCount }}</h1>
                            </div>
                            <span>
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>

                    </div>
                </a>
                <a href="{{ route('likeCount#list') }}">
                    <div class="expenses">
                        <div class="middle">
                            <div class="left">
                                <h3>Like</h3>
                                <h1>{{ count($likeCount) }} </h1>
                            </div>
                            <span>
                                <i class="fa-solid fa-thumbs-up"></i>
                            </span>
                        </div>

                    </div>
                </a>
                <a href="{{ route('income#list') }}">
                    <div class="income">
                        <div class="middle">
                            <div class="left" style="margin-right: 1.2rem;">
                                <h3>Total Income</h3>
                                <h1>{{ $formattedPrice }} Kyats</h1>
                            </div>

                            <span>
                                <i class="fa-solid fa-sack-dollar"></i>
                            </span>
                        </div>

                    </div>
                </a>

            </div>
            <div class="recent-orders">
                <h2>Recent Orders</h2>
                @if (count($orders) == 0)
                    <h1 class="no-order">There is no order yet!</h1>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Product Id</th>
                                <th class="user">User Name</th>

                                <th>Order code</th>
                                <th class="amount">Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $item)
                                <tr>
                                    <td>{{ $item->id }} </td>
                                    <td class="user">{{ $item->customer_name }} </td>
                                    <td><a href="{{ route('customer#orderList', [$item->id, $item->order_code]) }}"
                                            class="danger">{{ $item->order_code }} </a></td>
                                    <td class="primary amount">{{ $item->total_price }} Kyats</td>
                                    <td class="select pe-2">
                                        <input type="text" id="orderId" value="{{ $item->id }}" hidden>
                                        <select name="category" class="statusChange form-select my-custom-select"
                                            aria-label="Default select example">
                                            <option value="0" @if ($item->status == 0) selected @endif>
                                                Pending
                                            </option>
                                            <option value="1" @if ($item->status == 1) selected @endif>
                                                Success</option>
                                            <option value="2" @if ($item->status == 2) selected @endif>
                                                Reject</option>
                                        </select>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>

        </main>

        <!-- END OF MAIN SECTION -->

        <!-- RIGHT SECTION -->
        <div class="right">

            <!-- top container of right session -->
            <div class="top">
                <button id="menu-btn">
                    <span>
                        <i class="fa-solid fa-bars-staggered"></i>
                    </span>
                </button>
                <div class="theme-toggler">
                    <label class="ui-switch">
                        <input type="checkbox" class="checkbox">
                        <div class="slider">
                            <div class="circle "></div>
                        </div>
                    </label>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>{{ Auth::user()->name }}</b></p>
                        <small>Admin</small>
                    </div>
                    <div class="profile-photo">
                        @if (Auth::user()->image == null)
                            <img src="{{ asset('img/default-male.png') }}" alt="">
                        @else
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="" id="img">
                        @endif

                    </div>
                </div>
            </div>
            <!-- end of top-->
            <!-- recent updates-->
            <div class="recent-updates">
                <h2>Recent Customer Messages</h2>
                <div class="updates">
                    @if (count($customers) == 0)
                        <div class="d-flex justify-content-center align-items-center" style="width:100%;height:100%">
                            <h3>There is no message yet!</h3>
                        </div>
                    @else
                        @foreach ($customers as $customer)
                            <a href="{{ route('customer#viewMessage', $customer->id) }}">
                                <div class="update">
                                    <div class="profile-photo">
                                        @if ($customer->image !== null)
                                            <img src="{{ asset('storage/images/' . $customer->image) }}"
                                                alt="">
                                        @else
                                            <img src="{{ asset('img/default-male.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="message">
                                        <p style="margin-bottom: 3px"><b>{{ $customer->name }} </b> sent a message.
                                        </p>
                                        <small class="">{{ $customer->created_at->diffForHumans() }} </small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- the start of sale analytics -->
            <div class="sales-analytics">
                <h2>Sales Analytics</h2>

                <a href="{{ route('category#createPage') }}">
                    <div class="item add-product add-category">
                        <div>
                            <span>
                                <i class="fa-solid fa-circle-plus"></i>
                            </span>
                            <h3>Add Category</h3>
                        </div>

                    </div>
                </a>
                <a href="{{ route('product#createPage') }}">
                    <div class="item add-product">
                        <div>
                            <span>
                                <i class="fa-solid fa-circle-plus"></i>
                            </span>

                            <h3>Add Product</h3>
                        </div>

                    </div>
                </a>
            </div>
            <!-- the end of sale analytics -->

        </div>
        <!-- END OF RIGHT SECTION -->

    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/admin/layouts/dashboard.js') }}"></script>
<script>
    $('.statusChange').change(function() {
        $currentStatus = $(this).val();
        $parentNode = $(this).parents('tbody tr td');
        $orderId = $parentNode.find('#orderId').val();
        console.log($currentStatus)
        console.log($orderId)
        $.ajax({
            type: 'get',
            url: 'http://127.0.0.1:8000/admin/order/status/change',
            data: {
                'status': $currentStatus,
                'orderId': $orderId
            },
            dataType: 'json',
        })

    })

    //SET CALENDER DATE
    document.getElementById('datepicker').valueAsDate = new Date();
</script>

</html>
