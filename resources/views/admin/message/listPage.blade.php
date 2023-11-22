@extends('admin.layouts.master')
@section('css-link')
    <link rel="stylesheet" href="{{ asset('css/admin/message/listPage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/message/chatInfo.css') }}">
@endsection
@section('content')
    {{-- horizontal scroll bar for choosing chats --}}
    <div class="d-flex justify-content-center">
        <div class="horizontal-scroll">
            <button class="btn-scroll" id="btn-scroll-left" onclick="scrollHorizontally(1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn-scroll" id="btn-scroll-right" onclick="scrollHorizontally(-1)">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="storys-container">
                @yield('story')
            </div>
        </div>
    </div>
    @yield('chats')
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    @yield('chatInfo')
    @yield('list')
    <script>
        /* The horizontal scroll bar */


        let currentScrollPosition = 0;
        let scrollAmount = 320;
        const sCont = document.querySelector('.storys-container');
        const hScroll = document.querySelector('.horizontal-scroll');
        const btnScrollLeft = document.querySelector('#btn-scroll-left');
        const btnScrollRight = document.querySelector('#btn-scroll-right');



        //  let maxScroll = -(sCont.offsetWidth + hScroll.offsetWidth) ;
        const maxScroll = sCont.scrollWidth - sCont.clientWidth;
        console.log(maxScroll)

        function scrollHorizontally(val) {
            currentScrollPosition += (val * scrollAmount);

            if (currentScrollPosition >= 0) {
                currentScrollPosition = 0;

            }
            if (currentScrollPosition <= -maxScroll) {
                currentScrollPosition = -maxScroll;
            }
            sCont.style.left = currentScrollPosition + "px";
        }
    </script>
@endsection
