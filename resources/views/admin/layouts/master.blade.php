<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Cake Of Paradise</title>
    <link rel="shortcut icon" href="https://webstockreview.net/images/fruit-clipart-cupcake-4.png" type="image/x-icon">

    {{-- bootstrap link --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    {{-- font awesome link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Custom css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/layouts/master.css') }}">
    {{-- changePassword css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/account/changePassword.css') }}">
    {{-- account details css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/account/details.css') }}">
    {{-- account edit css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/account/edit.css') }}">
    {{-- category create css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/category/create.css') }}">
    {{-- category list css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/category/list.css') }}">
    {{-- category update css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/category/update.css') }}">
    {{-- post create css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/post/create.css') }}">
    {{-- post list css --}}
    <link rel="stylesheet" href="{{ asset('css/admin/post/list.css') }}">
    {{-- message list css --}}
    @yield('css-link')

    {{-- customer information --}}
    <link rel="stylesheet" href="{{ asset('css/customer/orderList.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/viewList.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/contact.css') }}">
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
                            <div class="circle"></div>
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
            @yield('content')
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
<script src="{{ asset('js/admin/account/edit.js') }}"></script>
@yield('script')

</html>
